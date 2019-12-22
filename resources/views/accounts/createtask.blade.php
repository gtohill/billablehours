@extends('accounts.client')

@section('account_content')
<div class="container">
    <h4>{{$client->name}}</h4>
    <div class="text-center display-4 m-5">Create Client</div>
    <div class="row">
        <div class="col-3"></div>
        <div class="col-6">
            <form action="/tasks" method="POST">
                @csrf
                <div class="form-group">
                    <label for="formGroupExampleInput">Task Name</label>
                    <input type="text" class="form-control" name="name" id="formGroupExampleInput">
                    <input type="hidden" name="clientid" value="{{$client->id}}">
                </div>
                <div class="form-group">
                    <label for="exampleFormControlTextarea1">Task Description</label>
                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1"
                        rows="3"></textarea>
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
            <div class="p-2 text-center bg-info text-white">
                @if($message ?? '')
                    {{$message ?? ''}}
                @endif            
            </div>                
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