<?php

namespace App\Imports;

use App\Models\BoqItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BoqItemsImport implements ToCollection, WithHeadingRow
{
    private int $boqId;
    public int $inserted = 0;

    public function __construct(int $boqId)
    {
        $this->boqId = $boqId;
    }

    public function collection(Collection $rows)
    {
        $rowNo = 1;

        foreach ($rows as $row) {
            $itemCode = $row['item_code'] ?? $row['code'] ?? $row['item'] ?? null;
            $desc     = $row['description'] ?? $row['desc'] ?? $row['item_description'] ?? null;
            $unit     = $row['unit'] ?? $row['uom'] ?? null;
            $qty      = $row['qty'] ?? $row['quantity'] ?? 0;
            $rate     = $row['rate'] ?? $row['unit_rate'] ?? null;
            $amount   = $row['amount'] ?? null;

            if (!$itemCode && !$desc) { $rowNo++; continue; }

            $qty = is_numeric($qty) ? (float)$qty : 0;

            if ($amount === null && $rate !== null && is_numeric($rate)) {
                $amount = $qty * (float)$rate;
            }

            BoqItem::create([
                'boq_id'      => $this->boqId,
                'row_no'      => $rowNo,
                'item_code'   => $itemCode,
                'description' => $desc,
                'unit'        => $unit,
                'qty'         => $qty,
                'rate'        => (is_numeric($rate) ? (float)$rate : null),
                'amount'      => (is_numeric($amount) ? (float)$amount : null),
            ]);

            $this->inserted++;
            $rowNo++;
        }
    }
}