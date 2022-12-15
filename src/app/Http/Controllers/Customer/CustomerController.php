<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Http\Requests\Customer\CustomerStoreRequest;
use App\Services\Customer\CustomerService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CustomerController extends Controller
{
    public function __construct(
        private readonly CustomerService $customerService
    )
    {
    }

    public function storeOrUpdate(CustomerStoreRequest $request): \Illuminate\Http\JsonResponse
    {
        $customer = $this->customerService->storeOrUpdate($request->validated());

        return response()->json(['id' => $customer->getKey()], Response::HTTP_OK);
    }
}
