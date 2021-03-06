<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //
    public function getUserCart()
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
        $product_id = $request->input('product_id');
        $quantity = $request->input('quantity');

        $cart = $this->getUserCart();

        DB::table('cart_items')->insert([
            'cart_id' => $cart->id,
            'product_id' => $product_id,
            'quantity' => $quantity,
            'created_at' => now(),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Item added to cart',
            'data' => [
                'cart' => $cart,
                'cart_items' => DB::table('cart_items')->where('cart_id', $cart->id)->get()
            ]
        ]);


    }

    public function removeCartItem(Request $request, $id)
    {
        $cart = $this->getUserCart();
        $result = DB::table('cart_items')->where('id', $id)->delete();

        if ($result) {
            return response()->json([
                'status' => 'success',
                'message' => 'Item removed from cart',
                'data' => [
                    'cart' => $cart,
                    'cart_items' => DB::table('cart_items')->where('cart_id', $cart->id)->get()
                ]
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Item not removed from cart',
                'data' => [
                    'cart' => $cart,
                    'cart_items' => DB::table('cart_items')->where('cart_id', $cart->id)->get()
                ]
            ]);
        }
    }

    public function updateCartItem(Request $request, $id)
    {
        $cart = $this->getUserCart();
        $result = DB::table('cart_items')->where('id', $id)->update([
            'quantity' => $request->input('quantity'),
            'updated_at' => now()
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Item updated',
            'data' => [
                'cart' => $cart,
                'cart_items' => DB::table('cart_items')->where('cart_id', $cart->id)->get()
            ]
        ]);
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
