<?php

namespace App\Http\Controllers;

use App\Http\Controllers\API\CartController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    //



    public function createOrder(){
        $cart = (new CartController)->getUserCart();
        $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->get();

        $total = 0;

        foreach ($cartItems as $cartItem){
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

        foreach ($cartItems as $cartItem){

            $product = DB::table('products')->where('id', $cartItem->product_id)->first();

            // Apply discount
            $total_price = $product->price - ($product->price * ($product->discount/100));

            DB::table('order_items')->insert([
                'order_id' => $order_id,
                'product_id' => $cartItem->product_id,
                'name' => $product->name,
                'quantity' => $cartItem->quantity,
                'price' => $total_price,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Order created successfully',
                'data' => [
                    'order' => DB::table('orders')->where('id', $order_id)->first(),
                    'order_items' => DB::table('order_items')->where('order_id', $order_id)->get()
                ]
            ]);
        }
    }
}
