<?php

namespace App\Services;

use App\Imports\CustomersImport;

class CustomerService
{
    public function importCSV($csv, bool $force = false)
    {
        \Excel::import(new CustomersImport($force), $csv);
    }
}