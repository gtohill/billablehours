@extends('master')
@section('content')
<h3>TEST PAGE </h3>
<br>
@if($client)
    {{$client->name}}
@endif
<br>
@if($error)
    {{$error}}
@endif

@endsection