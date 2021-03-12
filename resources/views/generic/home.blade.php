@extends('layouts.master')

@section('content')
    <!-- Main jumbotron for a primary marketing message or call to action -->
    <div class="container nueph pt-5">
      <div class="hero-image">
        <img class="h-img" src="{{url('/images/time-is-money.jpg')}}" alt="Company Logo">
        <div class="hero-text">
          <h1 class="display-4"><b>Time Is Money... TrackIT!</b></h1>
          <p class="h3">Time is money... make sure you're compensated for your time.  With TrackIT, you can create tasks and track how long it takes you to complete them.</p>
          <p ><a style="color:white; background-color:  #FB8604" class="btn btn-lg" href="{{ route('register') }}" role="button">Start Tracking &raquo;</a></p>
        </div>
      </div> 
    </div>
    <br><br><br>

    <div class="container">
      <!-- Example row of columns -->
      <div class="row box_nueph py-5">
          <div class="col-md-4 border-right">
            <h2 class="text-center">Don't Guess... Track It</h2>
            <p>You spend your time helping your clients build their business. Now you can have confidence you've invoiced them for the time you've invested in their business. </p>
            <p class="text-center"><a class="btn btn-success" href="{{ route('register') }}" role="button">Start Tracking &raquo;</a></p>
          </div>
          <div class=" col-md-4 border-right">
            <h2  class="text-center">Improve Your Profitability</h2>
            <p>By using TrackIt, to track the time it takes for you to complete tasks, you can provide accurate estimates and assess ways to improve your workflow.</p>
            <p class="text-center"><a class="btn btn-success" href="{{ route('register') }}" role="button">Improve Profits &raquo;</a></p>
          </div>
          <div class="col-md-4">
            <h2  class="text-center">Budget Vs Actual</h2>
            <p>If you're working within a budget, TrackIt allows you to track the actual time you've invested in the project and compare that amount to the budget the client is willing to pay.</p>
            <p class="text-center"><a class="btn btn-success" href="{{ route('register') }}" role="button">Improve Efficiency &raquo;</a></p>
          </div>
        </div>      
    </div> <!-- /container -->

  @endsection