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
                                    <h4 class="panel-title ">New Orders <?php echo '('.sizeof($pending).')';?></h4>
                                </a>
                                <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        @foreach ($pending as $order)
                                            <a href="/items/{{$order->orderid}}">
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
                                                            <h3 class="name">{{$order->city}}</h3>
                                                            <h4 style="color:#f0ad4e;"align="center">{{$order->status}}</h4>

                                                            <div class="flex">
                                                                <ul class="list-inline count2">
                                                                    <li style="width:100%">
                                                                        <h3>{{$order->bag_count}}</h3>
                                                                        <span>Items</span>
                                                                    </li>
                                                                    {{--<li style="width:48%">--}}
                                                                        {{--<h3 class="price">{{$order->total}}</h3>--}}
                                                                        {{--<span >SAR</span>--}}
                                                                    {{--</li>--}}

                                                                </ul>
                                                            </div>
                                                            <p>
                                                            <h4 class="name" style="margin-bottom:-15px;">Order.No</h4>
                                                            <h3 class="name"> {{substr($order->orderid, -4)}}</h3>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach

                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" style="background-color:#B2DFDB; text-decoration: none !important;" id="headingTwo" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    <h4 class="panel-title">Pending <?php echo '('.sizeof($waiting).')';?></h4>
                                </a>
                                <div id="collapseTwo" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingTwo" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        @foreach ($waiting as $order)
                                            <a href="/items/{{$order->orderid}}">
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
                                                            <h3 class="name">{{$order->city}}</h3>
                                                            <h4 style="color:#f0ad4e;"align="center">{{$order->status}}</h4>

                                                            <div class="flex">
                                                                <ul class="list-inline count2">
                                                                    <li style="width:100%">
                                                                        <h3>{{$order->bag_count}}</h3>
                                                                        <span>Items</span>
                                                                    </li>
                                                                    {{--<li style="width:48%">--}}
                                                                        {{--<h3 class="price">{{$order->total}}</h3>--}}
                                                                        {{--<span >SAR</span>--}}
                                                                    {{--</li>--}}

                                                                </ul>
                                                            </div>
                                                            <p>
                                                            <h5 class="name">{{$order->orderid}}</h5>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" style="background-color:#80CBC4; text-decoration: none !important;" id="headingThree" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    <h4 class="panel-title">Completed <?php echo '('.sizeof($created).')';?></h4>
                                </a>
                                <div id="collapseThree" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingThree" aria-expanded="false" style="height: 0px;">
                                    <div class="panel-body">
                                        @foreach ($created as $order)
                                            <a href="/items/{{$order->orderid}}">
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
                                                            <h3 class="name">{{$order->city}}</h3>
                                                            <h4 style="color:#26b99a;"align="center">{{$order->status}}</h4>

                                                            <div class="flex">
                                                                <ul class="list-inline count2">
                                                                    <li style="width:100%">
                                                                        <h3>{{$order->bag_count}}</h3>
                                                                        <span>Items</span>
                                                                    </li>
                                                                    {{--<li style="width:48%">--}}
                                                                        {{--<h3 class="price">{{$order->total}}</h3>--}}
                                                                        {{--<span >SAR</span>--}}
                                                                    {{--</li>--}}

                                                                </ul>
                                                            </div>
                                                            <p>
                                                            <h5 class="name">Order: {{$order->orderid}}</h5>
                                                            <h5 class="name">{{$order->tracking_id}}</h5>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>


                            <div class="panel">
                                <a class="panel-heading collapsed" role="tab" style="background-color:#4DB6AC; text-decoration: none !important;" id="headingFour" data-toggle="collapse" data-parent="#accordion" href="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    <h4 class="panel-title">canceled Orders <?php echo '('.sizeof($canceld).')';?></h4>
                                </a>
                                <div id="collapseFour" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading" aria-expanded="false">
                                    <div class="panel-body">
                                        @foreach ($canceld as $order)
                                            <a href="/items/{{$order->orderid}}">
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
                                                            <h3 class="name">{{$order->city}}</h3>
                                                            <h4 style="color:#d9534f;"align="center">{{$order->status}}</h4>

                                                            <div class="flex">
                                                                <ul class="list-inline count2">
                                                                    <li style="width:100%">
                                                                        <h3>{{$order->bag_count}}</h3>
                                                                        <span>Items</span>
                                                                    </li>
                                                                    {{--<li style="width:48%">--}}
                                                                        {{--<h3 class="price">{{$order->total}}</h3>--}}
                                                                        {{--<span >SAR</span>--}}
                                                                    {{--</li>--}}

                                                                </ul>
                                                            </div>
                                                            <p>
                                                            <h5 class="name">{{$order->orderid}}</h5>
                                                            </p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
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

<script src="script/order.js"></script>
