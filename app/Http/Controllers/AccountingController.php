<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Fund;
use DB;
use URL;
use Auth;

class AccountingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function showTransaction()
    {
        if ((Auth::user()->role) == 3 || (Auth::user()->role == 1)){
            $funds =DB::table('funds')->orderBy('date', 'desc')->get();
            $total =DB::table('funds')->orderBy('date', 'desc')->sum('amount');

            return view('trans',compact('funds','total'));
        }
        else
            return redirect('/');
    }

    public function addfund()
    {
        if ((Auth::user()->role) == 3 || (Auth::user()->role == 1)) {
            $fund = new Fund;

            $fund->type = $_GET['type'];
            $fund->transaction = $_GET['how'];
            if ($_GET['type'] != "Credit")
                $fund->amount = $_GET['amount'] * -1;
            else
                $fund->amount = $_GET['amount'];
            $fund->note = urldecode($_GET['note']);
            $fund->date = $_GET['date'];

            $fund->save();

            return redirect('/accounting/trans');
        }
        else
            return redirect('/');


    }

    public function filter(){

        $start= $_GET['start'];
        $end= $_GET['end'];

        $shipped = DB::table('orders')->orderBy('orderid', 'desc')->whereIn('status', ['Shipment Created','return'])
            ->where([
                ['created_at','>',$start],
                ['created_at', '<', $end]])->get();

        $ordersId = array_map(create_function('$o', 'return $o->orderid;'), $shipped);

        $items = DB::table('items')->whereIn('orderid', $ordersId)->get();

        return view('cost', compact('shipped', 'items'));

    }

    public function showcost()
    {

        if ((Auth::user()->role) == 3 || (Auth::user()->role == 1)) { //check if a Super admin or Accounting user
            $shipped = DB::table('orders')->orderBy('orderid', 'desc')->whereIn('status', ['Shipment Created','return'])
                ->where([
                                ['created_at','>',Date('Y-m-d', strtotime("-30 days"))],
                                ['created_at', '<', date("Y-m-d")]])->get();


            $ordersId = array_map(create_function('$o', 'return $o->orderid;'), $shipped);

            $items = DB::table('items')->whereIn('orderid', $ordersId)->get();

            return view('cost', compact('shipped', 'items'));
        }
        else
            return redirect('/');
    }

    public function showSummary()
    {
        if ((Auth::user()->role) == 3 || (Auth::user()->role == 1)) {

            $credit   = DB::table('funds')->where('type', 'Credit')->sum('amount');
            $purchase = DB::table('funds')->where('type', 'Purchase')->sum('amount');

            $shipped = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Shipment Created')->orwhere('status', 'return')->get();//get();

            $ordersId = array_map(create_function('$o', 'return $o->orderid;'), $shipped);

            $items = DB::table('items')->whereIn('orderid', $ordersId)->get();

            $allCost = 0;
            foreach ($shipped as $order) {
                $qty = array();
                $cost = array();
                foreach ($items as $item) {
                    if ($item->orderid == $order->orderid) {
                        if ((!(strpos($item->sku, 'sample'))) && ($item->status != 0)) {
                            $qty[] = $item->qty;
                            $cost[] = $item->cost;
                        }
                    }
                }
                $total = array_map(function ($x, $y) {
                    return $x * $y;
                },
                    $qty, $cost);
                if ($order->status == "return")
                    $allCost += array_sum($total) * -1;
                else
                    $allCost += array_sum($total);
            }
            return view('summary', compact('credit', 'purchase', 'allCost'));
        }
        else
            return redirect('/');
    }

    public function showOrder()
    {
        if (Auth::user()->role == 3) {

            $created = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Shipment Created')->get();
            
            return view('invoiceOrders', compact('created'));
        }
    }
}
