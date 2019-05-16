<?php

namespace App\Http\Controllers;

use App\Models\ProductModel;
use Illuminate\Http\Request;
use DB;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

   public function search(Request $request){
    try {
        $maxprice=$request['price']+1000;
        $start = date("Y-m-d",strtotime($request['startdate']));
        $end = date("Y-m-d",strtotime($request['enddate']));
        $products = ProductModel::where("product_name", "LIKE","%".$request['productname']."%")
                    ->whereBetween("created_at", [$start,$end])
                    ->whereBetween("price",[$request['price'],$maxprice])->orWhere("sku", "LIKE", "%".$request['productname']."%")
                    ->get();


        // $products = ProductModel::whereBetween("created_at",[$start,$end])->where("product_name", "LIKE","%".$request['productname']."%")->get();
        // $products=DB::table('products')->where(function($query){$query->where("product_name", "LIKE","%".$request['productname']."%")
        //     ->orWhere("sku", "LIKE", "%".$request['productname']."%");})->whereBetween("created_at",[$start,$end])->where("price",">=",$request['price'])->where("price","<=",$maxprice)->get();
        //     $products=DB::table('products')->where("product_name", "LIKE","%".$request['productname']."%")->get();
        // $products = ProductModel::fullTextSearch($request['productname'],$request['startdate'],$request['enddate'],$request['price']);
        // $products=ProductModel::all();
        if(count($products) > 0){
            return response()->json(['status' => 'SUCCESS', 'products' => $products, 'total' => count($products), 'message' => ''], 200);
        }else{
            return response()->json(['status' => 'SUCCESS', 'products' => [], 'total' => 0, 'message' => 'No matching products found.'], 200);
        }
    } catch (\Exception $e) {
        return response()->json(['status' => 'FAILURE', 'message' => $e->getMessage()], 400);
    }
   }


}
