<?php

namespace App\Services;

use App\Imports\CustomersImport;

class CustomerService
{
    public function importCSV($csv)
    {
        \Excel::import(new CustomersImport, $csv);
    }
}