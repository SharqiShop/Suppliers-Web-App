@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard</div>
                <div class="panel-body">
                    <div class="panel panel-default">

                      <table class="table">
                        <thead>
                          <tr>
                            <th>ID</th>
                            <th>Cat_ID</th>
                            <th>Name</th>
                            <th>E-mail</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                        @foreach ($users as $user)
                          <tr>
                            <th scope="row">{{$user->id}}</th>
                            <td>{{$user->cat_id}}</td>
                            <td>{{$user->name}}</td>
                            <td>{{$user->email}}</td>
                            <td>
                              <div class="form-group" style="margin-bottom: 0px;">
                                <a href=<?php echo '"/update/'.$user->cat_id.'"';?>>
                                  <button type="submit" id="notify" type="button" class="btn btn-default btn-filter" >Update</button>
                                </a>
                              </div>
                            </td>
                          </tr>
                          @endforeach

                        </tbody>
                      </table>
                    </div>
                    <a href="/supplier/add">
                        <button type="button" class="btn btn-primary">Add Supplier</button>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
