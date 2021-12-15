<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //

    protected $order;
    protected $orderItems;
    protected $transaction;


    public function checkout()
    {
        $order_result = $this->createOrder();

        if ($order_result) {
            $trans_result = $this->createTransaction();

            if ($trans_result) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Order placed successfully',
                    'data' => [
                        'order' => $this->order,
                        'order_items' => $this->orderItems,
                        'transaction' => $this->transaction
                    ]
                ]);
            } else {
                // delete order items
                DB::table('order_items')->where('order_id', $this->order->id)->delete();

                // delete order
                DB::table('orders')->where('id', $this->order->id)->delete();
            }
        }

        return response()->json([
            'status' => 'error',
            'message' => 'Order could not be placed'
        ]);
    }



    public function createOrder()
    {
        $cart = (new CartController)->getUserCart();
        $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->get();

        $total = 0;

        foreach ($cartItems as $cartItem) {
            $product = DB::table('products')->where('id', $cartItem->product_id)->first();
            $total += $product->price * $cartItem->quantity;
        }

        $order_id = DB::table('orders')->insertGetId([
            'user_id' => Auth::user()->id,
            'status' => 'pending',
            'total' => $total,
            'discount' => 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        foreach ($cartItems as $cartItem) {

            $product = DB::table('products')->where('id', $cartItem->product_id)->first();

            // Apply discount
            $total_price = $product->price - ($product->price * ($product->discount / 100));

            DB::table('order_items')->insert([
                'order_id' => $order_id,
                'product_id' => $cartItem->product_id,
                'name' => $product->name,
                'quantity' => $cartItem->quantity,
                'price' => $total_price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            // TODO: Delete cart and cart items

            $this->order = DB::table('orders')->where('id', $order_id)->first();
            $this->orderItems = DB::table('order_items')->where('order_id', $order_id)->get();
            return true;
        }
    }

    public function createTransaction()
    {

        $tax_rate = cg_get_setting("TAX_RATE");
        $tax_amount = $this->order->total * ($tax_rate / 100);
        $grand_total = $this->order->total + $tax_amount;


        $transaction_id = DB::table('transactions')->insertGetId([
            'user_id' => Auth::user()->id,
            'order_id' => $this->order->id,
            'total' => $this->order->total,
            'discount' => $this->order->discount,
            'currency' => 'USD',
            'tax' => $tax_rate,
            'grand_total' => $grand_total,
            'gateway' => 'unknown',
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $this->transaction = DB::table('transactions')->where('id', $transaction_id)->first();
        return true;
    }
}
