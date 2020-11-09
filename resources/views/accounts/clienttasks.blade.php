@extends('layouts.app') @section('title', $client->name) @section('account')
<style>
    .div1 {
        width: 100%;
        min-height: 200px;
        height: auto;
        padding: 10px;
        border: 1px solid #aaaaaa;
        border-radius: 15px;
        box-shadow: 10px 10px;
    }

    #btn1 {
        display: none;
        color: white;
    }

    #btn2 {
        display: inline;
        color: white;
    }
    .like-link {
        background: none !important;
        border: none;
        padding: 0 !important;
        /*optional*/
        font-family: arial, sans-serif;
        /*input has OS specific font-family*/
        color: #069;
        text-decoration: underline;
        cursor: pointer;
    }

    .format-name {
        width:200px;
    }
    .format-description {        
        width: 350px;
        height: 75px;
        overflow: scroll;                                    
    }
    .format-time {
        min-width: 100px;
    }
</style>

@if($message ?? '')
<div class="alert alert-danger">
    {{$message ?? ''}}
</div>
@endif
<!-- TASKS CONTAINER -->
<div style="padding-bottom: 50px">
<!-- OPEN TASKS -->

<div class="container div1 my-5 pt-3">
    <h4>Open Tasks</h4>
    @if($openTask)
    <table class="table table-hover">
        <tr>
            <th scope="col">Complete</th>
            <th scope="col">Move To: Todo</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Time</th>
        </tr>
        <tr>
            <td class="format-task-btn">
                <form action="/completed/{{$client->id}}" method="POST">
                    @method('PUT') @csrf
                    <input
                        class="btn btn-primary"
                        type="submit"
                        name="id"
                        value="{{$openTask->id}}"
                    />
                    <input type="hidden" name="actual2" id="actual2" />
                    <i class="fas fa-arrow-down"></i
                    ><i class="fas fa-arrow-down"></i>
                </form>
            </td>
            <form method="POST" action="/tasks/{{$client->id}}">
                <td class="format-task-btn">
                @method('PUT') @csrf
                    <input
                        class="btn btn-success"
                        type="submit"
                        name="id"
                        id="id"
                        value="{{$openTask->id}}"
                    />
                    <i class="fas fa-arrow-down"></i>
                </td>

                <td class="format-name">
                    {{$openTask->name}}
                </td>
                <td class="format-description">
                    {!! $openTask->description !!}
                </td>
                <td class="format-time">                    
                    <div id="time"></div>
                        <input
                            type="hidden"
                            name="actual"
                            id="actual"
                            value="{{$openTask->time}}"
                        />                    
                </td>
            </form>
            <td class="format-task-btn">
                <button
                    id="btn2"
                    class="btn btn-success"
                    onclick="startFunc()"
                >
                    Start
                </button>
                <button id="btn1" class="btn btn-danger" onclick="stopFunc();">
                    Stop
                </button>
            </td>
        </tr>
    </table>

    @endif
</div>
<!-- END OF OPEN TASKS -->

<!-- TO DO TASKS -->
<div class="container div1 mb-5">
    <h4>To Do Tasks</h4>
    <div>
        <a href="/tasks/createtask/{{$client->id}}">Create Task</a>
    </div>
    @if(count($tasksInProgress) > 0)
    <table class="table table-hover">
        <tr>
            <th scope="col">Completed</th>
            <th scope="col">Move To Open</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Time</th>
        </tr>
        @foreach ($tasksInProgress as $taskInProgress)
        <tr>
            <td class="format-task-btn">
                <form action="/completed/{{$client->id}}" method="POST">
                    @method('PUT') @csrf
                    <input
                        class="btn btn-primary"
                        type="submit"
                        name="id"
                        value="{{$taskInProgress->id}}"
                    />
                    <input
                        type="hidden"
                        name="actual2"
                        value="{{$taskInProgress->time}}"
                    />
                    <i class="fas fa-arrow-down"></i>
                </form>
            </td>
            <form method="POST" action="/opentask/{{$client->id}}">
                @method('PUT') @csrf
                <td class="format-task-btn">
                    <input
                        class="btn btn-success"
                        type="submit"
                        name="id"
                        value="{{$taskInProgress->id}}"
                    />
                    <i class="fas fa-arrow-up"></i>
                </td>
                <td class="format-name">
                    {{$taskInProgress->name}}
                </td>
                <td>
                    <div class="format-description">
                        {!! $taskInProgress->description !!}
                    </div>
                </td>
                <td class="format-time">
                    {{$taskInProgress->time}}
                </td>
            </form>
            <td class="format-task-btn">
                <a class="like-link" href="/tasks/{{$taskInProgress->id}}/edit"
                    >edit</a
                >
                |
                <form
                    action="/tasks/{{$taskInProgress->id}}"
                    method="POST"
                    onsubmit="return verifySubmit();"
                >
                    @csrf @method('DELETE')
                    <input class="like-link" type="submit" value="delete" />
                </form>
            </td>
        </tr>
        @endforeach
    </table>
    @endif
</div>
<!-- END TO DO TASKS -->

<!-- COMPLETE TASKS -->
<div class="container div1 mb-5">
    <h4>Completed Tasks</h4>
    @if(count($completedTasks) > 0)
    <table class="table">
        <tr>
            <th scope="col">Change Status</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Time</th>
        </tr>

        @foreach ($completedTasks as $completedTask)
        <tr>
            <td class="format-task-btn">
                <form
                    action="/completed/{{$completedTask->id}}/edit"
                    method="GET"
                >
                    <input
                        type="submit"
                        value="{{$completedTask->id}}"
                        class="btn btn-success"
                    />
                    <i class="fas fa-arrow-up"></i>
                </form>
            </td>
            <td>
                {{$completedTask->id}}
            </td>
            <td class="format-name">
                {{$completedTask->name}}
            </td>
            <td>
                <div class="format-description"> 
                    {!! $completedTask->description !!}
                </div>
            </td>
            <td class="format-time">
                {{$completedTask->time}}
            </td>
            <td>
                <a class="like-link" href="/tasks/{{$completedTask->id}}/edit"
                    >edit</a
                >
                |
                <form
                    action="/tasks/{{$completedTask->id}}"
                    method="POST"
                    onsubmit="return verifySubmit();"
                >
                    @csrf @method('DELETE')
                    <input class="like-link" type="submit" value="delete" />
                </form>
            </td>
        </tr>
        @endforeach
    </table>

    @endif
</div>
</div>
<!-- END OF COMPLETED TASKS -->

<script type="text/javascript" src="{{ asset('/js/timer.js') }}"></script>

@endsection
