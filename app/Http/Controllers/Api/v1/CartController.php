<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use App\Http\Resources\Api\v1\CartResource;
use App\Http\Requests\Api\v1\StoreCart;
use App\Cart;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'sales_id' => 'required|integer',
            'order_by' => [
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

         $data = DB::table('carts')
            ->leftjoin('products','products.id', '=', 'product_id')
            ->select('carts.*', 'products.name as product_name')
            ->where('sales_id', '=', $validated_data['sales_id'])
            ->orderBy('name', $validated_data['order_by'])
            ->paginate($validated_data['items_per_page']);

        return CartResource::collection($data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCart $request)
    {
        /* return DB::table('carts')
            ->where('sales_id', '=', $request['sales_id'])
            ->where('product_id', '=', $request['product_id'])
            ->get();   */ 

        //pordernumber int,pproduct int,pprice decimal(10,2),pqty int,ptotal decimal(10,2)
        return DB::select(
            'call addProductToOrder(?,?,?,?,?)',
            array(
                $request['sales_id'],
                $request['product_id'],
                $request['price'],
                $request['quantity'],
                $request['subtotal']
            )
        );

        /* $data = Cart::create($request->validated());
        return response()->json(
            [
                'status_code' => JsonResponse::HTTP_OK,
                'message' => 'Added to Cart',
                'data'=>$data
            ],
            JsonResponse::HTTP_OK
        ); */
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
