@extends('layouts.app')

@section('title', $client->name)

@section('account')
<style>
.like-link {
  background: none!important;
  border: none;
  padding: 0!important;
  /*optional*/
  font-family: arial, sans-serif;
  /*input has OS specific font-family*/
  color: #069;
  text-decoration: underline;
  cursor: pointer;
}

</style>
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
                <th scope="col">Amount</th> 
                <th scope="col">Edit </th>           
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
                <td>
                    <label class="form-check-label" for="defaultCheck1">
                    {{$task->amount}}
                    </label>
                </td> 
                <td>
                    <a class="like-link" href="/tasks/{{$task->id}}/edit">edit</a>
                </td>               
            </tr>

            @endforeach



        </table>
        <input type="submit" value="Create Invoice">
    </form>

</div>
<script>
    function verifySubmit(){        
        if (confirm("You are about to DELETE a task! Are you sure you want to proceed?")) {
            return true;
        } else {
            return false;
        }        
    }

</script>
@endsection