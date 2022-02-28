<?php

namespace App\Http\Controllers\API;

use App\Events\PurchaseMade;
use App\Http\Controllers\Controller;
use App\Services\PaynowService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PaymentStatus;

class PaymentController extends Controller
{


    public function performPayment(Request $request, $id)
    {

        $transaction = DB::table('transactions')->where('id', $id)->first();
        $paymentMethod = $request->input('payment_method');

        if ($paymentMethod == "paynow"){
            $result =  $this->paynowExpress($request, $transaction);
            return response()->json($result);
        }

        return response()->json(['error' => 'Payment method not supported']);
    }

    protected function paynowExpress(Request $request, $transaction){

        $email = $request->input('email');
        $phone = $request->input('phone');


        $order = DB::table('orders')->where('id', $transaction->order_id)->first();
        $orderItems = DB::table('order_items')->where('order_id', $transaction->order_id)->get();

        $paynowService = new PaynowService(
            $email,
            $phone
        );

        $paynowService->addItems($orderItems);
        $response = $paynowService->makePayment();

        $transaction_paid = false;
        $order_status = \PaymentStatus::failed;

        if ($response['status'] == "success"){

            $transaction_paid = true;
            $order_status = \PaymentStatus::paid;
            PurchaseMade::dispatch($transaction, $order, $orderItems);

        }else if ($response['status'] == "failed"){

            $transaction_paid = false;
            $order_status = \PaymentStatus::failed;
        }else if ($response['status'] == "timeout"){

            $transaction_paid = false;
            $order_status = \PaymentStatus::timeout_reached;
        }

        // Update tables
        DB::table('transactions')->where('id', $transaction->id)->update([
            'gateway' => 'paynow',
            'paid' => $transaction_paid
        ]);

        DB::table('orders')->where('id', $order->id)->update([
            'status' => $order_status
        ]);


        $response['data'][] = $transaction;


        return $response;
    }
}
