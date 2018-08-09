<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

use Log;
use App\Item;
use DB;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        Log::useDailyFiles(storage_path().'/logs/itemsAPI.log');
        Log::info("Request=>".$request);

        $item = new Item;
        $item->orderid = $request->input('orderid') ;
        $item->name    = $request->input('name');
        $item->sku     = $request->input('sku');
        $item->qty     = $request->input('qty');
        $item->price   = $request->input('price');
        $item->status  = "2";
        $item->cost    = $request->input('cost');
        
        $item->save();

        echo "Done Items";
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
        if ((DB::table('orders')->where('orderid', '=', $id)->pluck('status')[0]) == "Waiting for client reply")

            DB::table('orders')->where('orderid', '=', $id)
                ->update(['status' => $_GET['result']]);
        else
            $warning = "You can't update your order staus twice";
        return view('update',compact('warning'));
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
