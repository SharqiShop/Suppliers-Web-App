@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Orders Costs({{sizeof($shipped)}})</h3></div>

                    <div class="panel-body">

                        <p>All transactions table.</p>

                        <div class="row">
                            <div class="col col-xs-24">
                                <div class="pull-left">
                                    <form class="form-horizontal" method="get" action="/accounting/filter/">

                                            <div class="input-daterange input-group" id="datepicker" style="width: 400px; margin-left: 10px;">
                                                <input value=<?php echo (Date('Y-m-d', strtotime("-30 days")));?> type="text" class="input-sm form-control" name="start" />
                                                <span class="input-group-addon">to</span>
                                                <input value= <?php echo date("Y-m-d")?> type="text" class="input-sm form-control" name="end" />

                                            </div>
                                            <div style=" margin-left: 10px;">
                                                    <button type="submit" class="btn btn-success" >Apply</button>
                                            </div>
                                    </form>
                                </div>

                            </div>
                        </div>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Date</th>
                                <th>Products</th>
                                <th>Qty</th>
                                <th>P.cost</th>
                                <th>Order Cost</th>
                            </tr>
                            </thead>
                            <tbody>

                            <?php $allCost=0; ?>
                            @foreach($shipped as $order)
                                <?php unset($qty); unset($cost);?>

                                @if($order->status =="return")
                                    <tr class="danger" style="border: 1px double #AAAAAA">
                                @else
                                    <tr style="border:1px solid #EEEEEE;">
                                @endif
                                        <td>{{$order->orderid}}({{$order->name}})</td>
                                        <td >{{$order->date}}</td>
                                        <td>
                                            <?php $qty=array();
                                            $cost = array();?>
                                            @foreach($items as $item)
                                                @if ($item->orderid == $order->orderid)

                                                    @if($item->status == 0)
                                                        <p>{{$item->name}}</p>
                                                    @endif
                                                    @if ((!(strpos($item->sku, 'sample'))) && ($item->status != 0))
                                                        <p >{{$item->name}}</p>
                                                            <?php
                                                            $qty[]=$item->qty;
                                                            $cost[]=$item->cost;?>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($items as $item)
                                                @if ($item->orderid == $order->orderid)
                                                    @if($item->status == 0)
                                                        <p>N/A</p>
                                                    @endif
                                                    @if ((!(strpos($item->sku, 'sample'))) && ($item->status != 0))
                                                        <p >{{$item->qty}}</p>

                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            @foreach($items as $item)
                                                @if ($item->orderid == $order->orderid)
                                                    @if($item->status == 0)
                                                        <p>0</p>
                                                    @endif
                                                    @if ((!(strpos($item->sku, 'sample'))) && ($item->status != 0))
                                                        <p >{{$item->cost}}</p>
                                                    @endif
                                                @endif
                                            @endforeach
                                        </td>
                                        <?php
                                        $total = array_map(function($x, $y) { return $x * $y; },
                                                $qty, $cost);

                                        ?>
                                        <td>
                                            @if($order->status =="return")
                                                <?php //$allCost += array_sum($total)*-1;?>
                                                <p >(0)</p>
                                            @else
                                                <?php $allCost += array_sum($total);?>
                                                <p >{{array_sum($total)}}</p>
                                            @endif
                                        </td>
                                    </tr>

                            @endforeach
                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td><h3>Total of purchased items</h3></td>
                                        <td></td>
                                        <td></td>
                                        <td style="border: 1px solid #cccccc !important; "><h3>{{$allCost}}</h3></td>

                                    </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-24">
                                <div class="pull-right">

                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

<script src="../script/cost.js"></script>