<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Repositories\Transaction\TransactionRepository;
use App\Services\Payment\PostbackService;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;

class PostbackController extends Controller
{
    public function __construct(
        private readonly PostbackService $postbackService
    )
    {
    }

    public function postback(Request $request): void
    {
        //TODO:: testar essa implementação!!
        try {
            $this->postbackService->updateTransaction(new Fluent($request->all()));

        } catch (\Exception $exception) {
            file_put_contents(storage_path('error.txt'), $exception->getMessage());
        }
    }
}
