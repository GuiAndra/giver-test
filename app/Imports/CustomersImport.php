<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomersImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, ShouldQueue, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Customer([
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'email' => filter_var($row['email'], FILTER_VALIDATE_EMAIL) ?: null,
            'gender' => $row['gender'],
            'ip_address' => filter_var($row['ip_address'], FILTER_VALIDATE_IP) ?: null,
            'company' => $row['company'],
            'city' => $row['city'],
            'title' => $row['title'],
            'website' => $row['website']
        ]);
    }

    public function chunkSize(): int
    {
        return 500;
    }

    public function batchSize(): int
    {
        return 500;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required|string|max:255',
        ];
    }
}
