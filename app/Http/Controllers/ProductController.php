<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return Product::orderBy('created_at', 'DESC')->get();
        return DB::table('products')
                ->leftJoin('files', 'products.id', '=', 'files.product_id')
                ->where('products.status', 1)
                ->orderBy('products.created_at', 'DESC')
                ->get();
    }

    public function disbaledProduct()
    {
        return DB::table('products')
                ->leftJoin('files', 'products.id', '=', 'files.product_id')
                ->where('products.status', 0)
                ->orderBy('products.created_at', 'DESC')
                ->get();         
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
        $newProduct = new Product; 
        $newProduct->name = $request->product["name"];
        $newProduct->description = $request->product["description"];
        $newProduct->quantity = $request->product["quantity"];
        $newProduct->price = $request->product["price"];
        $newProduct->status = 1;
        $newProduct->save();

        return $newProduct;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $existingProduct = Product::find( $id ); 

        if( $existingProduct ) {
            $existingProduct->name = $request->product['name'];
            $existingProduct->description = $request->product['description'];
            $existingProduct->quantity = $request->product['quantity'];
            $existingProduct->price = $request->product['price'];
            $existingProduct->save();

        }

        return json_encode(array(['msg' => 'Product not found!']));
    }

    public function disable(Request $request, $id)
    {
        $disabledProduct = Product::find( $id ); 

        if( $disabledProduct ) {
            $disabledProduct->status = !$disabledProduct->status;
            $disabledProduct->save();

            return $disabledProduct;
        }

        return json_encode(array(['msg' => 'Product not found!']));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $existingProduct = Product::find( $id ); 

        if( $existingProduct ) {
            $existingProduct->delete();

            return json_encode(array(['msg' => 'Product successfully deleted!']));;
        }

        return json_encode(array(['msg' => 'Product not found!']));
    }
}
