<?php

namespace App\Imports;

use App\Models\Customer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Illuminate\Contracts\Queue\ShouldQueue;

class CustomersImport implements ToModel, WithHeadingRow, WithChunkReading, WithBatchInserts, WithValidation
{
    private $force;

    public function __construct(bool $force)
    {
        $this->force = $force;
    }

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
            'last_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'gender' => 'nullable|string|max:50',
            'ip_address' => 'nullable|ip|max:15',
            'company' => 'nullable|string|max:50',
            'city' => 'nullable|string|max:50',
            'title' => 'nullable|string|max:100',
            'website' => 'nullable|string|max:1500'
        ];
    }

    public function prepareForValidation($data, $index)
    {
        if($this->force) {
            $data['email'] = filter_var($data['email'], FILTER_VALIDATE_EMAIL) ?: null;
            $data['ip_address'] = filter_var($data['ip_address'], FILTER_VALIDATE_IP) ?: null;
        }
        
        return $data;
    }
}
