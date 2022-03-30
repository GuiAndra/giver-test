<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;
use App\Http\Requests\CustomerImportRequest;
use App\Services\CustomerService;

class CustomersController extends Controller
{

    protected $customer;
    protected $customerService;

    public function __construct(Customer $customer, CustomerService $service)
    {
        $this->customer = $customer;
        $this->customerService = $service;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->customer->paginate(20);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function import(CustomerImportRequest $request)
    {
        $this->customerService->importCSV($request->file);
    }
}
