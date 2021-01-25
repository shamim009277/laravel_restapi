<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = auth()->user()->products;

        return response()->json([
             'status'=>true,
             'data'=>$products,
        ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
           'name' => 'required',
           'price' => 'required | integer'
        ]);

        $product = new Product;
        $product->name = $request->name;
        $product->price = $request->price;

        if (Auth()->user()->products()->save($product)) {
            return response()->json([
                'status'=>true,
                'data'=>$product->toArray(),
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'data'=>'Product Could not be found',
            ],400);
        } 
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {  
           return response()->json([
                'status'=>false,
                'data'=>'product with this id' .$id. 'not found',   
           ],400); 
        }

        return response()->json([
            'status'=>true,
            'data'=>$product->toArray(),
        ],200);

        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {
            return response()->json([
               'status'=>false,
               'data'=>'product with id'.$id.'not found',
            ],400);
        }

        $update =  $product->fill($request->all())->save();

        if ($update) {
            return response()->json([
               'status'=>true,
               'message'=>'Data updated successfully',
            ],200);
            
        } else {
            return response()->json([
               'status'=>false,
               'message'=>'data could not be updated',
            ],500);
        }
        
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = auth()->user()->products()->find($id);

        if (!$product) {
            return response()->json([
               'status'=>false,
               'data'=>'product with id'.$id.'not found',
            ],400);
        }

        if ($product->delete()) {
             return response()->json([
                'status'=>true,
                'message'=>'Data deleted successfully',
             ],200);
         } else {
             return response()->json([
                'status'=>false,
                'message'=>'Data could not be deleted',
             ],500);
         }     
    }
}
