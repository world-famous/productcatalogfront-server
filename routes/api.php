<?php

use Illuminate\Http\Request;

/*
  |--------------------------------------------------------------------------
  | API Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register API routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | is assigned the "api" middleware group. Enjoy building your API!
  |
 */

/**
 * LOGIN 
 *      URL : oauth/token
 *      HEADER:Content-Type : application/x-www-form-urlencoded
 *      BODY : 
 *  grant_type:password
    client_id:2
    client_secret:swIAll6hKT8vc9tfYhZ7RQTz2IZW4LVNtzLpM1Z1
    username:useremail
    password:userpassword
    scope:*
 * 
 * RESPONSE
 *      TOKEN
 * 
 */

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * REGISTER
 *      URL : api/register
 *      HEADER : 
    Accept:application/json
    Authorization:Bearer TOKEN
    Content-Type:application/json
 *      BODY :
 *          name :
 *          email : 
 *          password : 
 *          gender : 
 */
Route::post('/register', function (Request $request) {
    try {
        $cust = Customer::add(['name' => $request['name'], 'email' => $request['email'], 'password' => $request['password'], 'gender' => $request['gender']]);
        return response()->json(['status' => 'SUCCESS', 'message' => $cust->user->name . " registered successfully. Proceed to login"], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
});

/**
 * Returns an array of all the products
 */
Route::get('/product/all', function() {
    return response()->json(['status' => 'SUCCESS', 'products' => Product::getAll()], 200);
});

/**
 * Return the best matching products
 */

Route::middleware('cors')->post('/product/search','ProductController@search');

Route::get('/cart', function(Request $request) {
    try {
        $user = $request->user();
        Cart::setUserId($user->id);
        $cart_items = Cart::get();
        $cart_total = Cart::cartTotal();
        return response()->json(['status' => 'SUCCESS', 'cart_items' => $cart_items, 'total' => $cart_total], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
});

Route::post('/cart/add', function(Request $request) {
    try {
        $user = $request->user();
        Cart::setUserId($user->id);
        Cart::addProduct($request['product_id'], 1);
        $cart_items = Cart::get();
        $cart_total = Cart::cartTotal();
        return response()->json(['status' => 'SUCCESS', 'cart_items' => $cart_items, 'total' => $cart_total], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
});

Route::post('/cart/remove', function(Request $request) {
    try {
        $user = $request->user();
        Cart::setUserId($user->id);
        Cart::removeProduct($request['product_id'], $request['quantity']);
        $cart_items = Cart::get();
        $cart_total = Cart::cartTotal();
        return response()->json(['status' => 'SUCCESS', 'cart_items' => $cart_items, 'total' => $cart_total], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
});

Route::get('/cart/empty', function(Request $request) {
    try {
        $user = $request->user();
        Cart::setUserId($user->id);
        Cart::emptyCart();
        $cart_items = Cart::get();
        $cart_total = Cart::cartTotal();
        return response()->json(['status' => 'SUCCESS', 'cart_items' => $cart_items, 'total' => $cart_total], 200);
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
});
