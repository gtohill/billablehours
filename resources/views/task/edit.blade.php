@extends('layouts.app')

@section('account')


@if($task)
<table class="table">
    <tr>
        <th scope="col">ID</th>
        <th scope="col">Name</th>
        <th scope="col">Description</th>
        <th scope="col">Hours</th>
        <th scope="col">Minutes</th>
        <th scope="col">Seconds</th>
        <th scope="col">Submit</th>

    </tr>
    <tr>
        <form action="{{url('edittask')}}" method="POST">
            @csrf            
            <td>
                <input type="text" size="5" value="{{$task->id}}" disabled>
                <input type="hidden" name="id" value="{{$task->id}}">
            </td>
            <td>
                <input type="text" name="name"  value="{{$task->name}}" />
            </td>
            <td>                
                <textarea class="form-cotrol" id="summary-ckeditor" name="description"> {!! $task->description !!}</textarea>                                
            </td>
            <td>
                <input type="text" name="hour"   size="3" value="{{$task->hour}}" /> :
            </td>
            <td>
                <input type="text" name="minute"   size="3" value="{{$task->minute}}" /> :
            </td>
            <td>
                <input type="text" name="second"   size="3" value="{{$task->second}}" />
            </td>
            <td>
                <input type="submit" value="Update">
            </td>
        </form>
    </tr>

    </form>

</table>
@endif

@if($message ?? '')
<div class="bg-success">
    <h4 class="bg-success">{{$message ?? ''}}</h4>
</div>
@endif

<a href="/tasks/{{$client->id}}">Back To Tasks</a>

@endsection