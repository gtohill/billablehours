@extends('layouts.app')

@section('title', 'Clients')

@section('clients')
    <div class="container">
        <div class="h2 py-3">
            Client List
        </div>
        @foreach ($clients as $client)
        <div class="list-group">
            <a href="/accounts/{{$client->id}}" class="list-group-item list-group-item-action">{{$client->name}}</a>             
        </div> 
    @endforeach
    </div>    
@endsection