@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-24">
                <div class="x_panel">
                    <div class="x_content">
                        <!-- start accordion -->
                        <div class="accordion" id="accordion" role="tablist" aria-multiselectable="true">
                            <div class="panel">
                                <a class="panel-heading collapsed " style="background-color:#E0F2F1; text-decoration: none !important;" role="tab" id="headingOne" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                    <h4 class="panel-title ">OnHold <?php echo '('.sizeof($pending).')';?></h4>
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        @foreach ($pending as $order)
                                            <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                                <div class="x_panel fixed_height_310">
                                                    <div class="x_content">
                                                        <div class="flex">
                                                            <ul class="list-inline widget_profile_box">
                                                                {{--<li>--}}
                                                                    {{--<img src={{$order->order_image}} alt="..." class="img-circle profile_img">--}}
                                                                {{--</li>--}}
                                                                <li style="width:70%;">
                                                                    <h4 style="color:#da2835;" >
                                                                        <?php
                                                                        $date = round((time() - strtotime($order->date)) /60) ;
                                                                        switch ($date) {
                                                                            case ($date > 0 && $date <= 60) :
                                                                                echo $date.' Mins ago';
                                                                                break;
                                                                            case ($date >60  && $date <= 1440) :
                                                                                echo round($date/60) ." Hours ago";
                                                                                break;
                                                                            case ($date >1440  && $date <= 2880) :
                                                                                echo "Yesterday";
                                                                                break;
                                                                            default:
                                                                                echo round(($date/60)/24).' Days ago';
                                                                                break;
                                                                        }?>
                                                                    </h4>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <h3 class="name">{{$order->name}}</h3>
                                                        <h4 style="color:#f0ad4e;"align="center">{{$order->city}}</h4>
                                                        <h5 style="color:#f0ad4e;"align="center">{{$order->street_one}}</h5>
                                                        <h5 class="name">{{$order->phone}}</h5>
                                                        <div class="flex">
                                                            <ul class="list-inline count2">
                                                                <li style="width:48%">
                                                                    <h5>{{$order->orderid}}</h5>
                                                                </li>
                                                                <li style="width:48%">
                                                                    <h4 class="price">{{$order->total}} SAR</h4>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="flex" style="height:70px; overflow: scroll; overflow-x: hidden; margin-bottom:25px;">
                                                            <ul class="list-group" style="width: 100%;">
                                                                @foreach($items as $item)
                                                                    @if ($item->orderid == $order->orderid)
                                                                        <li class="list-group-item"><p style="direction:rtl;">{{$item->name}} -- {{$item->qty}}</p></li>
                                                                    @endif
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        <div class="form-group">
                                                            <label>Status</label>
                                                            <select class="state" id={{$order->orderid}}>
                                                                <option selected disabled>Client Say</option>
                                                                <option>Confirm</option>
                                                                <option>Cancel</option>
                                                                <option disabled>Attempt</option>
                                                                <option <?php if ($order->status =='First Attempt') echo 'selected';?>>First Attempt</option>
                                                                <option <?php if ($order->status =='Second Attempt') echo 'selected';?>>Second Attempt</option>
                                                                <option>Third Attempt</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        @endforeach

                                    </div>
                                </div>
                            </div>

                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" style="background-color:#f1f1f1; text-decoration: none !important;" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <h4 class="panel-title">All Orders <?php echo '('.sizeof($other).')';?></h4>
                                </a>
                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading" aria-expanded="false">
                                    <div class="panel-body">
                                        @foreach ($other as $order)

                                                <div class="col-md-3 col-xs-12 widget widget_tally_box">
                                                    <div class="x_panel fixed_height_310">

                                                        <div class="x_content">
                                                            <div class="flex">
                                                                <ul class="list-inline widget_profile_box">

                                                                    {{--<li>--}}
                                                                        {{--<img src={{$order->order_image}} alt="..." class="img-circle profile_img">--}}
                                                                    {{--</li>--}}
                                                                    <li style="width:70%;">

                                                                        {{--<i class="fa fa-twitter"></i>--}}
                                                                        <h4 style="color:#da2835;" >
                                                                            <?php

                                                                            $date = round((time() - strtotime($order->date)) /60) ;
                                                                            switch ($date) {
                                                                                case ($date > 0 && $date <= 60) :
                                                                                    echo $date.' Mins ago';
                                                                                    break;
                                                                                case ($date >60  && $date <= 1440) :
                                                                                    echo round($date/60) ." Hours ago";
                                                                                    break;
                                                                                case ($date >1440  && $date <= 2880) :
                                                                                    echo "Yesterday";
                                                                                    break;
                                                                                default:
                                                                                    echo round(($date/60)/24).' Days ago';
                                                                                    break;
                                                                            }?>
                                                                        </h4>


                                                                    </li>
                                                                </ul>
                                                            </div>
                                                            <h4 style="height: 20px;" class="name">{{$order->name}}</h4>
                                                            <h4 style="color:#f0ad4e;"align="center">{{$order->city}}</h4>
                                                            <h5 style="height: 30px; color:#f0ad4e;"align="center">{{$order->street_one}}</h5>
                                                            <h5 class="name">{{$order->phone}}</h5>

                                                            <h4 style="color:#d9534f;"align="center">{{$order->status}}</h4>

                                                            <div class="flex">
                                                                <ul class="list-inline count2">
                                                                    <li style="width:48%">
                                                                        <a href="/items/{{$order->orderid}}">
                                                                            <h5>{{$order->orderid}}</h5>
                                                                        </a>
                                                                    </li>
                                                                    <li style="width:48%">
                                                                        <h4 class="price">{{$order->total}} SAR</h4>
                                                                    </li>
                                                                </ul>
                                                            </div>

                                                            <div class="flex">
                                                                @if($order->status == "Shipment Created")
                                                                    <span class="toggle" style="width: 150px;" id="{{$order->orderid}}" >
                                                                     @if($order->status != "return")
                                                                            <button type="submit" class="btn btn-danger">Return</button>
                                                                        @endif
                                                                </span>
                                                                @endif

                                                            </div>

                                                                @if(empty($order->tracking_id))
                                                                    <p>No Shipment</p>
                                                                @else
                                                                    <p>{{$order->tracking_id}}</p>

                                                                @endif

                                                        </div>
                                                    </div>
                                                </div>

                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end of accordion -->
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

<script src="script/onhold.js"></script>