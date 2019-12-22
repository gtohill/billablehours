@extends('accounts.client')

@section('title', $client->name)

@section('account_content')

<div class="container">
    <h4>Completed Tasks</h4>
    <form action="/invoice" method="POST">
        @csrf
        <input type="hidden" name="client_id"  value="{{$client->id}}">
        <table class="table">
            <tr>
                <th scope="col">Select Invoice</th>
                <th scope="col">Name</th>
                <th scope="col">Description</th>
                <th scope="col">Time</th>                
            </tr>

            <tr>
                @foreach ($completed_tasks as $task)
                <td>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="{{$task->id}}" name="services[]"
                            id="defaultCheck1">
                    
                    </div>
                </td>
                <td>
                    <label class="form-check-label" for="defaultCheck1">
                        {{$task->name}}
                    </label>
                </td>
                <td>
                    <label class="form-check-label" for="defaultCheck1">
                        {{$task->description}}
                    </label>
                </td>
                <td>
                    <label class="form-check-label" for="defaultCheck1">
                        {{$task->time}}
                    </label>
                </td>                
            </tr>

            @endforeach



        </table>
        <input type="submit" value="Create Invoice">
    </form>

</div>

@endsection