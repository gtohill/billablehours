@extends('layouts.app')

@section('title')

@section('account')
<div class="row py-5">
    <div class="col">
        <div class="h4 text-center">Client: {{$client->name}}</div>
        @if($message ?? '')
          {{$message}}
        @endif
    </div>
</div>
<div class="container-fluid">  
  <div class="row">  
  <nav class="navbar navbar-expand-lg navbar-light bg-light">  
    <h4>Quick Menu:</h4> 
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
  </div> 


<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-primary shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Value Of Work</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">${{$invoice}}</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-calendar fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-success shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Earnings To Date</div>
              <div class="h5 mb-0 font-weight-bold text-gray-800">$0</div>
            </div>
            <div class="col-auto">
              <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-info shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Tasks In Progress</div>
              <div class="row no-gutters align-items-center">
                <div class="col-auto">
                  <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$num_tasks}}</div>
                </div>
                <div class="col">
                  <div class="progress progress-sm mr-2">
                  <div class="progress-bar bg-info" role="progressbar" style="width: {{$perc_completed}}%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-auto">
              <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
      <div class="card border-left-warning shadow h-100 py-2">
        <div class="card-body">
          <div class="row no-gutters align-items-center">
            <div class="col mr-2">
              <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Completed Tasks</div>
            <div class="h5 mb-0 font-weight-bold text-gray-800">{{$completed}}</div>
            </div>
            <div class="col-auto">
                <i class="fas fa-check fa-2x text-gray-300"></i>              
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

@endsection