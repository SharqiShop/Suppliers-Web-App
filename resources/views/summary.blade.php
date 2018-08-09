@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Summary</h3></div>

                    <div class="panel-body">
                        
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Type</th>
                                <th>Amount</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>Total Fund</td>
                                <td >{{$credit*1}}</td>
                            </tr>
                            <tr>
                                <td>Total Products cost</td>
                                <td >{{$allCost}}</td>
                            </tr>
                            <tr>
                                <td>Total Samples cost</td>
                                <td >{{$purchase *-1}}</td>

                            </tr>
                            <tr>
                                <td></td>
                                <td style="border: 1px solid #cccccc !important; "><h3>{{$credit - ($allCost + ($purchase *-1))}}</h3></td>

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