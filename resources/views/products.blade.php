
@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="panel-body">
               
            @foreach ($products as $product)
                <div class="col-md-3 col-xs-12 widget widget_tally_box" data-status="{{$product->stock}}">
                    <div class="x_panel fixed_height_390">
                        <div class="x_content">

                            <div class="flex">
                                <ul class="list-inline widget_profile_box">
                                    <li>
                                        <img src="{{$product->image}}" alt="..." class="img-circle profile_img">
                                    </li>
                                    <li>

                                    </li>
                                </ul>
                            </div>

                            <h4 class="name">{{$product->name}}</h4>

                            <div class="flex">
                                <ul class="list-inline count2">
                                    <li style="width: 48%;">
                                        <h3 >{{$product->qty}}</h3>
                                        <span>Piece</span>
                                    </li>

                                    <li  style="width: 48%;">
                                        <h5>{{$product->sku}}</h5>
                                        <span>CODE</span>
                                    </li>
                                </ul>
                            </div>
                            <p>

                    <span class="toggle" id="{{$product->sku}}" >
                        @if($product->stock)
                            <input type="checkbox" checked data-toggle="toggle" data-onstyle="success">

                        @else

                            <input  type="checkbox"  data-toggle="toggle" data-onstyle="success">
                    </span>
                                @endif

                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
           </div>

            <div class="panel-footer">
                <div class="col col-xs-8">
                    {{ $products->links() }}
                </div>
            </div>

        </div>
    </div>
@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.3/jquery.min.js" integrity="sha384-I6F5OKECLVtK/BL+8iSLDEHowSAfUo76ZL9+kGAgTRdiByINKJaqTPH/QVNS1VDb" crossorigin="anonymous"></script>

<script src="script/pub.js"></script>

