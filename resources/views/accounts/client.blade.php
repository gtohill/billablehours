@extends('layouts.app')

@section('title')

@section('account')

<div class="container">
   
</div>

<nav class="navbar navbar-expand-lg navbar-light bg-light">    
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href="/accounts/{{$client->id}}">{{$client->name}} <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/tasks/{{$client->id}}">Tasks</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/tasks/createtask/{{$client->id}}">Create Task</a>
            </li>           
            <li class="nav-item">
                <a class="nav-link" href="/completed/{{$client->id}}">Generate Invoice</a>
            </li> 
        </ul>
    </div>
</nav>

@yield('account_content')

@endsection