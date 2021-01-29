<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Product;
use App\Http\Resources\Api\v1\ProductResource;
use App\Http\Requests\Api\v1\StoreProduct;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name_search' => 'string',
            'name_order' => [
                'required',
                Rule::in(['asc','desc'])
            ],
            'items_per_page' => 'required|integer',
        ]);

        if ($validator->fails()){
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_ACCEPTABLE,
                    'message' => $validator->errors()
                ],
                JsonResponse::HTTP_NOT_ACCEPTABLE
            );
        }

        $validated_data = $validator->validated();

        $products = DB::table('products')
            ->where('name', 'like', '%'.$validated_data['name_search'].'%')
            ->orderBy('name', $validated_data['name_order'])
            ->paginate($validated_data['items_per_page']);

        return ProductResource::collection($products);
    }//index

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProduct $request)
    {          
            Product::create($request->validated());

            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_OK,
                    'message' => 'Product has been Saved!'
                ],
                JsonResponse::HTTP_OK
            );
    }//store

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if($product=Product::find($id)){
            return new ProductResource($product);
        }else{
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'message' => 'Product not found'
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }

        
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
        if($product = Product::find($id)){
            $validator = Validator::make($request->all(), [
                'name' => 'sometimes|unique:products,name',
                'regular_price' => 'sometimes|regex:/^\d+(\.\d{1,2})?$/',
                'is_for_sale' => 'sometimes|boolean',
                'available_stock' => 'sometimes|integer'
            ]);
    
            if ($validator->fails()){
                return response()->json(
                    [
                        'status_code' => JsonResponse::HTTP_NOT_ACCEPTABLE,
                        'message' => $validator->errors()
                    ],
                    JsonResponse::HTTP_NOT_ACCEPTABLE
                );
            }

            if($validated_data = $validator->validate()){
                $product->name = $validated_data['name'] ?? $product->name;
                $product->regular_price = $validated_data['regular_price'] ?? $product->regular_price;
                $product->is_for_sale = $validated_data['is_for_sale'] ?? $product->is_for_sale;
                $product->available_stock = $validated_data['available_stock'] ?? $product->available_stock;
            }

            //save the data
            $product->save();

             //return sucess response
             return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_OK,
                    'message' => 'Product has been updated!'
                ],
                JsonResponse::HTTP_OK
            );

        }else{
            //return validator errors
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'message' => 'Product not found!'
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }//if else
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if($product = Product::find($id)){
            //delete the data
            $product->delete();

             //return sucess response
             return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_OK,
                    'message' => 'Product has been deleted!'
                ],
                JsonResponse::HTTP_OK
            );

        }else{
            //return validator errors
            return response()->json(
                [
                    'status_code' => JsonResponse::HTTP_NOT_FOUND,
                    'message' => 'Product not found!'
                ],
                JsonResponse::HTTP_NOT_FOUND
            );
        }//if else
    }

    public function showDeleted()
    {
        return Product::onlyTrashed()->get();
    }
}
