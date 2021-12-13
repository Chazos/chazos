<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    protected function getUserCart()
    {
        $cart = DB::table('cart')->where('user_id', Auth::id())->first();
        return $cart;
    }

    protected function createUserCart()
    {
        DB::table('cart')->insert([
            'user_id' => Auth::id(),
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }

    public function addCartItem(Request $request)
    {
    }

    public function removeCartItem(Request $request, $id)
    {
    }

    public function updateCartItem(Request $request, $id)
    {
    }

    public function getAllCartItems()
    {
        if (Auth::check()) {
            $cart = DB::table('cart')->where('user_id', Auth::id())->first();

            if ($cart == null){
                $this->createUserCart();
                $cart = DB::table('cart')->where('user_id', Auth::id())->first();
            }


            $cartItems = DB::table('cart_items')->where('cart_id', $cart->id)->get();
            return response()->json([
                'status' => 'success',
                'message' => 'Cart retrieved successfully',
                'data' => [
                    'cart' => $cart,
                    'cart_items' => $cartItems
                ]
            ]);
        }else{
            return response()->json([
                'status' => 'error',
                'message' => 'User not logged in'
            ]);
        }
    }
}
