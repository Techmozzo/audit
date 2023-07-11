<?php

namespace App\Imports;

use App\Models\TrialBalance;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class TrialBalanceImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        if(isset($row['class']) && !is_null($row['class'])){
            return new TrialBalance([
                'classes'  => $row['class']
            ]);
        }
    }
}
