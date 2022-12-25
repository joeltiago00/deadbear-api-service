<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Services\Integrations\Payment\PostbackService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Fluent;
use Symfony\Component\HttpFoundation\Response;

class PostbackController extends Controller
{
    public function __construct(
        private readonly PostbackService $postbackService
    )
    {
    }

    public function postback(Request $request): JsonResponse
    {
        $this->postbackService->updateTransaction(new Fluent($request->all()));

        return response()->json([], Response::HTTP_OK);
    }
}
