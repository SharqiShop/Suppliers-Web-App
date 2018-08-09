<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use App\Order;
use Log;
use App\User;
use Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        echo "index";
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

        Log::useDailyFiles(storage_path().'/logs/ordersAPI.log');
        Log::info("Request=>".$request);

        if (!(Auth::attempt(['email' => $request->input('user'), 'password' => ($request->input('key')).'xy']))) {
            Log::info("Login=>Failed");
            return "failed";
        }
        $order = new order;

        $order->orderid  = $request->input('orderid');
        $order->status = 'onhold';//$request->input('status');
        $order->instock = 0;
        $order->outofstock = 0;
        $order->total =  $request->input('total');
        $order->name = $request->input('name');
        $order->phone =$request->input('phone');
        $order->bag_count = $request->input('bag_count');
        $order->country = $request->input('country');
        $order->city = $request->input('city');
        $order->street_one = $request->input('street_one');
        $order->payment_type = $request->input('payment_type');
        $order->email = $request->input('email');
        $order->weight = $request->input('weight');
        $order->date = $request->input('date');
        $order->order_image = $request->input('image_url');
        $order->shipping_cost = $request->input('shipping_cost');
        $order->discount_amount = ($request->input('discount_amount')*-1);

        $order->save();

        return "Done";
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
