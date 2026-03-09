<?php

namespace App\Services;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class TenantSqlProvisioningService
{
    public function createDatabase(string $dbName): void
    {
        // creates DB
        DB::statement("CREATE DATABASE `$dbName` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    }

    public function switchTenantDb(string $dbName): void
    {
        Config::set('database.connections.tenant.database', $dbName);
        DB::purge('tenant');
        DB::reconnect('tenant');
    }

    public function createTables(string $dbName): void
    {
        $this->switchTenantDb($dbName);

        // ✅ Use tenant connection for all SQL
        $conn = DB::connection('tenant');

        // IMPORTANT: disable FK checks while creating tables
        $conn->statement("SET FOREIGN_KEY_CHECKS=0;");

        // 0) sessions table
        $conn->statement("
            CREATE TABLE sessions (
                id VARCHAR(255) PRIMARY KEY,
                user_id BIGINT UNSIGNED NULL,
                ip_address VARCHAR(45) NULL,
                user_agent TEXT NULL,
                payload LONGTEXT NOT NULL,
                last_activity INT NOT NULL,
                INDEX (user_id),
                INDEX (last_activity)
            ) ENGINE=InnoDB 
            DEFAULT CHARSET=utf8mb4 
            COLLATE=utf8mb4_unicode_ci;
        ");


         $conn->statement("CREATE TABLE `project_vendor_emails` (
                `id` BIGINT(20) UNSIGNED NOT NULL AUTO_INCREMENT,
                `project_id` BIGINT(20) UNSIGNED NOT NULL,
                `vendor_id` BIGINT(20) UNSIGNED NOT NULL,
                `vendor_email` VARCHAR(255) NOT NULL,
                `subject` VARCHAR(255) NOT NULL,
                `message` TEXT NOT NULL,
                `sent_at` TIMESTAMP NULL DEFAULT NULL,
                `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                `mail_status` ENUM('sent','failed') DEFAULT 'sent',
                `mail_type` VARCHAR(100) DEFAULT NULL,
                `opened_at` TIMESTAMP NULL DEFAULT NULL,
                `responded_at` TIMESTAMP NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                INDEX (`project_id`),
                INDEX (`vendor_id`)
                ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        // 1) users table (employer DB)
        $conn->statement("
            CREATE TABLE users (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                email VARCHAR(255) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                role VARCHAR(50) NOT NULL DEFAULT 'employer_admin',
                active TINYINT(1) NOT NULL DEFAULT 1,
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // 2) projects table
        $conn->statement("
            CREATE TABLE projects (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,

                code VARCHAR(50) NOT NULL UNIQUE,
                work_type_id INT NOT NULL,
                work_subtype_id  INT NOT NULL,

                title VARCHAR(100) NULL,
                state_id INT NULL,
                region_id INT NULL,
                city_id INT NULL,

                budget INT NULL,
               
                contact_name VARCHAR(150) NULL,
                mobile VARCHAR(20) NULL,
                description VARCHAR(150) NULL,

                start_date DATE NULL,
                end_date DATE NULL,

                status ENUM('Planning','Active','On Hold','Completed','Cancelled') 
                    NOT NULL DEFAULT 'Planning',

                created_by BIGINT UNSIGNED NULL,

                created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                deleted_at TIMESTAMP NULL DEFAULT NULL,

                INDEX (status),
                INDEX (created_by)

            ) ENGINE=InnoDB 
            DEFAULT CHARSET=utf8mb4 
            COLLATE=utf8mb4_unicode_ci;
        ");

        // 3) boq_items table
        $conn->statement("
           CREATE TABLE `boq_items` (
        `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
        `boq_id` BIGINT UNSIGNED NOT NULL,
        `row_no` INT UNSIGNED NULL,
        `item_code` VARCHAR(100) NULL,
        `description` TEXT NULL,
        `unit` VARCHAR(50) NULL,
        `qty` DECIMAL(12,3) NOT NULL DEFAULT 0.000,
        `rate` DECIMAL(14,2) NULL,
        `amount` DECIMAL(16,2) NULL,
        `created_at` TIMESTAMP NULL DEFAULT NULL,
        `updated_at` TIMESTAMP NULL DEFAULT NULL,
        PRIMARY KEY (`id`),
        KEY `idx_boq_items_boq_id` (`boq_id`),
        CONSTRAINT `fk_boq_items_boq_id`
            FOREIGN KEY (`boq_id`) REFERENCES `boqs`(`id`)
            ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");


       $conn->statement(" CREATE TABLE `rfq_vendor_invites` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `rfq_id` BIGINT UNSIGNED NOT NULL,
            `vendor_id` BIGINT UNSIGNED NOT NULL,
            `project_id` BIGINT UNSIGNED NOT NULL,
            
            `status` VARCHAR(30) NOT NULL DEFAULT 'invited',
            `invited_at` TIMESTAMP NULL DEFAULT NULL,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            UNIQUE KEY `uq_rfq_vendor` (`rfq_id`,`vendor_id`),
            KEY `idx_rfq_id` (`rfq_id`),
            KEY `idx_vendor_id` (`vendor_id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");


 $conn->statement("CREATE TABLE `mail_logs` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `type` VARCHAR(60) NOT NULL,
  `rfq_id` BIGINT UNSIGNED NULL,
  `vendor_id` BIGINT UNSIGNED NULL,
  `to_email` VARCHAR(255) NOT NULL,
  `subject` VARCHAR(255) NULL,
  `status` VARCHAR(30) NOT NULL DEFAULT 'queued',
  `error` TEXT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idx_type` (`type`),
  KEY `idx_rfq_id` (`rfq_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");



$conn->statement("CREATE TABLE `vendor_boq_replies` (
  `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
  `vendor_id` BIGINT UNSIGNED DEFAULT NULL,
  `rfq_id` BIGINT UNSIGNED DEFAULT NULL,
  `project_id` BIGINT UNSIGNED DEFAULT NULL,
  `file_path` VARCHAR(255) DEFAULT NULL,
  `status` VARCHAR(50) DEFAULT 'uploaded',
  `remarks` TEXT DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");
        // 4) rfqs table
        $conn->statement("
            CREATE TABLE rfqs (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                project_id BIGINT UNSIGNED NULL,
                rfq_no VARCHAR(50) NOT NULL UNIQUE,
                title VARCHAR(255) NOT NULL,
                bid_deadline DATE NULL,
                payment_terms VARCHAR(255) NULL,
                status VARCHAR(50) NOT NULL DEFAULT 'Draft',
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                INDEX (project_id),
                CONSTRAINT fk_rfq_project FOREIGN KEY (project_id)
                    REFERENCES projects(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $conn->statement("
                CREATE TABLE rfq_vendors (
        id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        rfq_id BIGINT UNSIGNED NOT NULL,
        vendor_id BIGINT UNSIGNED NOT NULL,
        invited_at TIMESTAMP NULL DEFAULT NULL,
        status ENUM('invited','responded','rejected') DEFAULT 'invited',
        created_at TIMESTAMP NULL DEFAULT NULL,
        updated_at TIMESTAMP NULL DEFAULT NULL,
        UNIQUE KEY uq_rfq_vendor (rfq_id, vendor_id),
        INDEX(rfq_id),
        INDEX(vendor_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
                "
        );

         $conn->statement("
         CREATE TABLE rfq_bids (
            id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            rfq_id BIGINT UNSIGNED NOT NULL,
            vendor_id BIGINT UNSIGNED NOT NULL,
            total_quote DECIMAL(15,2) NULL,
            delivery_timeline VARCHAR(120) NULL,
            terms TEXT NULL,
            status ENUM('draft','submitted') DEFAULT 'submitted',
            created_at TIMESTAMP NULL DEFAULT NULL,
            updated_at TIMESTAMP NULL DEFAULT NULL,
            UNIQUE KEY uq_bid (rfq_id, vendor_id),
            INDEX(rfq_id),
            INDEX(vendor_id)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;");

            
        // 5) bids table
        $conn->statement("
            CREATE TABLE `boqs` (
            `id` BIGINT UNSIGNED NOT NULL AUTO_INCREMENT,
            `project_id` BIGINT UNSIGNED NOT NULL,
            `uploaded_by` BIGINT UNSIGNED NULL,
            `boq_type` VARCHAR(100) NULL,
            `original_name` VARCHAR(255) NULL,
            `file_path` VARCHAR(255) NOT NULL,
            `file_ext` VARCHAR(10) NULL,
            `total_items` INT UNSIGNED NOT NULL DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT NULL,
            `updated_at` TIMESTAMP NULL DEFAULT NULL,
            PRIMARY KEY (`id`),
            KEY `idx_boqs_project_id` (`project_id`)
            )ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // 6) purchase_orders table (PO)
        $conn->statement("
            CREATE TABLE purchase_orders (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                po_no VARCHAR(50) NOT NULL UNIQUE,
                project_id BIGINT UNSIGNED NULL,
                vendor_name VARCHAR(255) NOT NULL,
                total DECIMAL(15,2) NOT NULL DEFAULT 0,
                status VARCHAR(50) NOT NULL DEFAULT 'Open',
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                INDEX (project_id),
                CONSTRAINT fk_po_project FOREIGN KEY (project_id)
                    REFERENCES projects(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        // 7) invoices table
        $conn->statement("
            CREATE TABLE invoices (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                invoice_no VARCHAR(50) NOT NULL UNIQUE,
                po_id BIGINT UNSIGNED NULL,
                amount DECIMAL(15,2) NOT NULL DEFAULT 0,
                status VARCHAR(50) NOT NULL DEFAULT 'Unpaid',
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                INDEX (po_id),
                CONSTRAINT fk_invoice_po FOREIGN KEY (po_id)
                    REFERENCES purchase_orders(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

        $conn->statement("SET FOREIGN_KEY_CHECKS=1;");
    }

    public function provision(string $dbName): void
    {
        $this->createDatabase($dbName);
        $this->createTables($dbName);
    }
}
