<?php

namespace app\infrastructure;

use moonland\phpexcel\Excel;

class ExperimentExcel extends Excel
{
    public function getRow()
    {
        foreach ($this as $item) {
            if (stripos($item, $row['A']) === 0) {
                return $row['B'];
            }
        }

        return null;
    }
}