@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10 col-md-offset-1">
                <div class="panel panel-default">
                    <div class="panel-heading"><h3>Credit</h3></div>

                    <div class="panel-body">

                        <p>Show and add new transactions, deposit or purchase.</p>
                        <table class="table">
                            <thead>
                            <tr>
                                <th>#ID</th>
                                <th>Type</th>
                                <th>Type of transaction</th>
                                <th>Note</th>
                                <th>Date</th>
                                <th>Amount (Sar)</th>
                            </tr>
                            </thead>
                            <tbody>

                            @foreach($funds as $fund)

                                <tr>
                                    <td>{{$fund->id}}</td>
                                    <td >{{$fund->type}}</td>
                                    <td>{{$fund->transaction}}</td>
                                    <td>{{$fund->note}}</td>
                                    <td>{{$fund->date}}</td>
                                    @if ($fund->amount > 0)
                                        <td class="success">{{$fund->amount}}</td>
                                    @else
                                        <td class="danger">{{$fund->amount}}</td>
                                    @endif
                                </tr>
                            @endforeach
                            <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td style="border: 1px solid #cccccc !important; "><h3>{{$total}}</h3></td>

                            </tr>

                            </tbody>
                        </table>
                    </div>

                    <div class="panel-footer">
                        <div class="row">
                            <div class="col col-xs-24">
                                <div class="pull-right">


                                    <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">Add new transaction</button>

                                </div>

                            </div>
                        </div>
                    </div>



                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel">Add new transaction</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">

                                    <form class="form-horizontal" method="get" action="/accounting/addfund/">

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="amount">Amount</label>
                                            <div class="col-sm-10">
                                                <input type="number" class="form-control" id="amount" placeholder="Enter Amount" name="amount" required>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="type">Type</label>
                                            <div class="col-sm-10">
                                                <select name="type" class="form-control" id="type" required>
                                                    <option value="" selected disabled hidden>Choose Type</option>
                                                    <option value="Credit">Credit</option>
                                                    <option value="Purchase">Purchasing Samples</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="how">How done</label>
                                            <div class="col-sm-10">
                                                <select name="how" class="form-control" id="how" required>
                                                    <option value="" selected disabled hidden>Choose How</option>
                                                    <option value="Cash">Cash</option>
                                                    <option value="Deposit">Deposit</option>
                                                    <option value="Bank_Transfer">Bank Transfer</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="date">Date:</label>
                                            <div class="col-sm-10">

                                                <input id='date' class="form-control" value=<?php echo (Date('Y-m-d'));?> type="text" class="input-sm form-control" name="date" required />
                                            </div>
                                        </div>
                                        <script>
                                            $('#date').datepicker({
                                                format: 'yyyy-mm-dd'
                                            });

                                        </script>

                                        <div class="form-group">
                                            <label class="control-label col-sm-2" for="note">Note:</label>
                                            <div class="col-sm-10">
                                                <input type="text" class="form-control" id="note" placeholder="Any note" name="note" required>
                                            </div>
                                        </div>


                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-primary">Submit transaction</button>
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


<script type="text/javascript">

//    $('#exampleModal').on('show.bs.modal', function (event) {
//        var button = $(event.relatedTarget) // Button that triggered the modal
//        var recipient = button.data('whatever') // Extract info from data-* attributes
//        // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
//        // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
//        var modal = $(this)
//        modal.find('.modal-title').text('New message to ' + recipient)
//        modal.find('.modal-body input').val(recipient)
//    })
</script>
