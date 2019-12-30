@extends('layouts.app')

@section('account')
<div class="container">    
    <div class="text-center h2 m-5">Create Task for {{$client->name}}</div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6 border border-primary rounded p-5">
            <form action="/tasks" method="POST">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">Task Name</label>
                    <input type="text" class="form-control" name="name" id="formGroupExampleInput" required>
                    <input type="hidden" name="clientid" value="{{$client->id}}">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Task Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                        rows="3" required></textarea>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput">Hourly Rate</label>
                    <input type="text" class="form-control" name="rate" id="formGroupExampleInput" required>
                </div>
                <div class="form-group">
                    <label for="formGroupExampleInput2"></label>
                    <input type="submit" class="form-control btn-success" id="formGroupExampleInput2"
                        value="Create Client">
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            
        </div>
        <div class="col-6">
            @if($message ?? '')
            <div class="p-2 text-center bg-info text-white">                
                    {{$message ?? ''}}                   
            </div>                
            @endif         
        </div>
    </div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <div class="text-center pt-5">
                <a class="h3 text-center" href="/tasks/{{$client->id}}">Back To Tasks </a>
            </div>
            
        </div>        
    </div>
</div>
@endsection