@extends('layouts.app')

@section('content')



    <div class="container">
        <div class="row">

            <div class="panel-body">
                <div class="pull-right">
                    <div class="btn-group">
                        <a href="/orders/">
                            <button type="button" class="btn btn-default btn-filter" data-target="pagado">Back</button>
                        </a>

                        @if ((Auth::user()->role != 0))
                        <a href="/invoice/{{$items[0]->orderid}}">
                            <button type="button" class="btn btn-info btn-filter" data-target="pagado">Invoice</button>
                        </a>
                        @endif
                    </div>
                </div>
                <?php if (isset($message)){?>
                <div class="pull-left">
                    <?php switch ($message) {
                    case 'success':?>
                    <div class="alert alert-success">
                        <strong>Done!</strong> New shipment has been created.
                    </div>
                    <?php break;

                    case 'successLabel':?>
                    <div class="alert alert-success">
                        <strong>Done!</strong> New label has been created.
                        <?php  header("Location: ".$header); ?>
                    </div>
                    <?php break;

                    case 'failedLabel':?>
                    <div class="alert alert-danger">
                        <strong>FAILED!</strong> You can't create label, Call ADMIN, please.
                    </div>
                    <?php break;

                    case 'failed':?>
                    <div class="alert alert-danger">
                        <strong>FAILED!</strong> You can't create shipment, Call ADMIN, please.
                    </div>
                    <?php break;

                    case 'notify':?>
                    <div class="alert alert-warning">
                        <strong>Done!</strong> Cleint has been notified, Wait for her replay, please.
                    </div>
                    <?php break;
                    case 'cancel':?>
                    <div class="alert alert-danger">
                        <strong>Done!</strong> The order has been canceled.
                    </div>
                    <?php break;
                    default:
                        # code...
                        break;
                    } ?>
                </div>
                <?php }?>
                </br> </br>


            </div>

            <?php  $i=0;?>
            @foreach ($items as $item)


                <div class="col-md-3 col-xs-12 widget widget_tally_box" style="max-width:100%;">
                    <div class="x_panel fixed_height_310">
                        <div class="x_content">
                            <div class="flex">
                                <ul class="list-inline widget_profile_box">
                                    <li>
                                        <?php
                                        $sku = str_replace(' ', 'XYYXZ', $item->sku);
                                        ?>

                                        <div  sku="{{$item->orderid}}" id="<?php echo $sku; ?>">

                                            @if($item->status == "1")
                                                <a style="padding-top: 5px;" class="btn btn-success" disabled><em class="fa fa-thumbs-o-up"></em></a>
                                            @elseif($item->status == "2")
                                                <a style="padding-top: 5px;" class="action btn btn-default"><em class="fa fa-thumbs-o-up"></em></a>


                                            @endif
                                        </div>

                                    </li>
                                    <li>
                                        <img src="<?php
                                        if ($itemsImages[$i][0] !='NoImage' )
                                            echo $itemsImages[$i][0];

                                        else echo "http://emadov.com/skin/frontend/codazon_fastest/default/images/noimage.png"; $i++;?>" alt="..." class="img-circle profile_img">
                                    </li>
                                    <li>

                                        <div  sku="{{$item->orderid}}" id="<?php echo $sku; ?>">


                                            @if($item->status == "0")
                                                <a style="padding-top: 5px;" class="btn btn-danger" disabled><em class="fa fa-times"></em></a>
                                            @elseif(($item->status == "2"))
                                                <a style="padding-top: 5px;" class="action btn btn-default"><em class="fa fa-times"></em></a>
                                            @endif
                                        </div>
                                    </li>
                                </ul>
                            </div>

                            <h3 class="name">{{$item->name}}</h3>


                            @if (strpos($item->sku,'sample') == false)
                            <ul class="list-inline count2" style="border-bottom:0px;">

                                <li style="width:98%">
                                    <span>السعر</span>
                                    </br>
                                    <input style="text-align:center;" width="50px;" type="text" name="cost" id=text_{{$item->sku}} value="{{$item->cost}}"><br>

                                </li>
                            </ul>
                            @else
                                <input hidden style="text-align:center;" width="50px;" type="text" name="cost" id=text_{{$item->sku}} value=3><br>
                            @endif
                            <span><h3>{{$item->qty}} عدد القطع </h3></span>
                            <div class="flex">
                                <ul class="list-inline count2">
                                    <li>
                                        <h3>{{$item->qty}}</h3>
                                        <span>Piece</span>
                                    </li>

                                    <li>
                                        <h4>{{$item->price}}</h4>
                                        <span>SAR</span>
                                    </li>

                                    <li>
                                        <h5>{{$item->sku}}</h5>
                                        <span>SKU</span>
                                    </li>

                                </ul>
                            </div>

                        </div>
                    </div>
                </div>


            @endforeach





            <div class="col-md-12 col-xs-12">
                <div class="panel panel-default">


                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-24">
                                <div class="pull-right">
                                    <form method="GET" action="../order/status">
                                        <input name="orderid" type="hidden" value="{{$item->orderid}}">
                                        <div id="shiporder">
                                            <?php
                                            if ((($order[0]->instock == $order[0]->bag_count)  && ($order[0]->status == "pending")) || ($order[0]->status == "Client Approved") ) {?>

                                                    <!-- {{csrf_field()}} -->
                                            <input name="action" type="hidden" value="ship">
                                            <button type="submit" id="ship" type="button" class="btn btn-success btn-filter" data-target="pagado">Request Shipping</button>

                                            <?php }

                                            elseif (($order[0]->instock != 0) && ($order[0]->outofstock != 0) && ($order[0]->status == "pending") ) {?>
                                            <input name="action" type="hidden" value="notify">
                                            <button type="submit" id="notify" type="button" class="btn btn-warning btn-filter" data-target="pagado">Notify Client</button>
                                            <?php }
                                            elseif (($order[0]->outofstock == $order[0]->bag_count) && ($order[0]->status == "pending")){ ?>
                                            <input name="action" type="hidden" value="cancel">
                                            <button type="submit" id="cancel" type="button" class="btn btn-danger btn-filter" data-target="pagado">Cancel Order</button>
                                            <?php }
                                            elseif (($order[0]->status == 'Shipment Created')){

                                            $date = new DateTime();
                                            $now = $date->getTimestamp();
                                            $diff = ($now - $order[0]->shipment_time);

                                            if ($diff >= 60){
                                            ?>
                                            <input name="action" type="hidden" value="label">
                                            <button type="submit" id="label" type="button" class="btn btn-success btn-filter" data-target="pagado">Download Shipping Label</button>
                                            <?php }
                                            else{
                                            ?>
                                            <span id="timer">
                               <p id ="timermessage"> The download will begin in <span id="countdowntimer"><?php echo (60 - $diff) ; ?></span> Seconds</p>
                               </span>
                                            <?php
                                            }
                                            }
                                            else{?>
                                            <a href="/orders/">
                                                <button type="button" class="btn btn-default btn-filter" data-target="pagado">Back</button>
                                                <?php } ?>
                                            </a>
                                        </div>
                                    </form>
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

<script src="../script/item.js"></script>

<?php if ($order[0]->status == 'Shipment Created'){
if ($diff <= 60){?>
<script type="text/javascript">
    var label = $('<input name="action" type="hidden" value="label"> <button type="submit" id="label" type="button" class="btn btn-success btn-filter" data-target="pagado">Create label</button>');

    var timeleft = "<?php echo (60 - $diff); ?>"
    var downloadTimer = setInterval(function(){
        timeleft--;
        document.getElementById("countdowntimer").textContent = timeleft;
        if (timeleft == 0 ){
            $( "#timermessage").remove();
            $("#timer").append(label);

        }

        if(timeleft <= 0)
            clearInterval(downloadTimer);
    },1000);
</script>

<?php } }?>
