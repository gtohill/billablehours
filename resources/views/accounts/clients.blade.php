@extends('layouts.app')

@section('title', 'Clients')

@section('clients')

<ul>
    @foreach ($clients as $client)

    <li><a href="/accounts/{{$client->id}}">{{$client->name}}</a> </li>

    @endforeach
    <br>
</ul>

<script>
    function getId() {
        event.preventDefault();
        var id = document.forms['taskForm']['id'].value;
        console.log("Id is:" + id);

    }
</script>
@endsection