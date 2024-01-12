<?php

namespace App\Repositories\Contracts;

use App\Models\Customer;
use Cassandra\Custom;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

interface CustomerRepositoryInterface
{

    /**
     * @param  Request  $request
     * @return LengthAwarePaginator<Customer>
     */
    public function paginate(Request $request): LengthAwarePaginator;

    public function find(int $id): Customer;
}