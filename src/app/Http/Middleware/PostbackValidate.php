<?php

namespace App\Http\Middleware;

use App\Exceptions\Payment\Postback\InvalidPostback;
use App\Payment\Payment;
use Closure;
use Illuminate\Http\Request;

class PostbackValidate
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws InvalidPostback
     */
    public function handle(Request $request, Closure $next)
    {
        $signature = $request->header('x-hub-signature');

        $payload = file_get_contents("php://input");

        $paymentService = app(Payment::class);

        if (!$paymentService->postbackIsValid($payload, $signature))
            throw new InvalidPostback();

        return $next($request);
    }
}
