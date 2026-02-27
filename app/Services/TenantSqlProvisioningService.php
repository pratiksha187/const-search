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
            CREATE TABLE boq_items (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                project_id BIGINT UNSIGNED NULL,
                item_name VARCHAR(255) NOT NULL,
                unit VARCHAR(50) NULL,
                qty DECIMAL(12,3) NOT NULL DEFAULT 0,
                rate DECIMAL(15,2) NOT NULL DEFAULT 0,
                amount DECIMAL(15,2) NOT NULL DEFAULT 0,
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                INDEX (project_id),
                CONSTRAINT fk_boq_project FOREIGN KEY (project_id)
                    REFERENCES projects(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
        ");

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

        // 5) bids table
        $conn->statement("
            CREATE TABLE bids (
                id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
                rfq_id BIGINT UNSIGNED NULL,
                vendor_name VARCHAR(255) NOT NULL,
                item_name VARCHAR(255) NOT NULL,
                quoted_rate DECIMAL(15,2) NOT NULL DEFAULT 0,
                terms VARCHAR(255) NULL,
                bid_status VARCHAR(50) NOT NULL DEFAULT 'Submitted',
                created_at TIMESTAMP NULL DEFAULT NULL,
                updated_at TIMESTAMP NULL DEFAULT NULL,
                INDEX (rfq_id),
                CONSTRAINT fk_bid_rfq FOREIGN KEY (rfq_id)
                    REFERENCES rfqs(id) ON DELETE SET NULL
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
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
