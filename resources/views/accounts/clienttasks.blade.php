@extends('layouts.app')

@section('title', $client->name)

@section('account')
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

@if($message ?? '')
<div class="alert alert-danger">
    {{$message ?? ''}}
</div>
@endif
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
            <td>
                <form action="/completed/{{$client->id}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input class="btn btn-primary" type="submit" name="id" value="{{$openTask->id}}">
                    <input type="hidden" name="actual2" id="actual2">
                    <i class="fas fa-arrow-down"></i><i class="fas fa-arrow-down"></i>
                </form>

            </td>
            <form method="POST" action="/tasks/{{$client->id}}">
                @method('PUT')
                @csrf
                <td>
                    <input class="btn btn-success" type="submit" name="id" id="id" value="{{$openTask->id}}">
                    <i class="fas fa-arrow-down"></i>
                </td>

                <td>
                    {{$openTask->name}}
                </td>
                <td>
                    {{$openTask->description}}
                </td>
                <td>
                    <div id="time" ></div>                    
                    <input type="hidden" name="actual" id="actual" value="{{$openTask->time}}">
                </td>
            </form>
            <td>
                <button id="btn2" class="btn btn-success" onclick="startFunc();">Start</button>
                <button id="btn1" class="btn btn-danger" onclick="stopFunc();">Stop</button>
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
            <td>
                <form action="/completed/{{$client->id}}" method="POST">
                    @method('PUT')
                    @csrf
                    <input class="btn btn-primary" type="submit" name="id" value="{{$taskInProgress->id}}">
                    <input type="hidden" name="actual2" value="{{$taskInProgress->time}}">
                    <i class="fas fa-arrow-down"></i>
                </form>
            </td>
            <form method="POST" action="/opentask/{{$client->id}}">
                @method('PUT')
                @csrf
                <td>
                    <input class="btn btn-success" type="submit" name="id" value="{{$taskInProgress->id}}">
                    <i class="fas fa-arrow-up"></i>
                </td>
                <td>
                    {{$taskInProgress->name}}
                </td>
                <td>
                    {{$taskInProgress->description}}
                </td>
                <td>
                    {{$taskInProgress->time}}
                </td>
            </form>
            <td>
                <a class="like-link" href="/tasks/{{$taskInProgress->id}}/edit">edit</a> |
                <form action="/tasks/{{$taskInProgress->id}}" method="POST" onsubmit="return verifySubmit();">
                    @csrf
                    @method('DELETE')
                    <input class="like-link" type="submit" value="delete">
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
            <th scope="col">Send To Invoice</th>
            <th scope="col">Change Status</th>
            <th scope="col">ID</th>
            <th scope="col">Name</th>
            <th scope="col">Description</th>
            <th scope="col">Time</th>
        </tr>

        @foreach ($completedTasks as $completedTask)
        <tr>
            <td>
                <form action="/invoice" method="POST">
                    @csrf
                    <input type="submit" name="task_id" value="{{$completedTask->id}}" class="btn btn-info">
                    <input type="hidden" name="client_id" value="{{$client->id}}">
                </form>
            </td>
            <td>
                <form action="/completed/{{$completedTask->id}}/edit" method="GET">
                    <input type="submit" value="{{$completedTask->id}}" class="btn btn-success">
                    <i class="fas fa-arrow-up"></i>
                </form>
            </td>
            <td>
                {{$completedTask->id}}
            </td>
            <td>
                {{$completedTask->name}}
            </td>
            <td>
                {{$completedTask->description}}
            </td>
            <td>
                {{$completedTask->time}}
            </td>
            <td>
                <a class="like-link" href="/tasks/{{$completedTask->id}}/edit">edit</a> |
                <form action="/tasks/{{$completedTask->id}}" method="POST" onsubmit="return verifySubmit();">
                    @csrf
                    @method('DELETE')
                    <input class="like-link" type="submit" value="delete">
                </form>
            </td>
        </tr>
        @endforeach

    </table>
    @endif
</div>
<!-- END OF COMPLETED TASKS -->

<script>
    let myVar = 0;
    let autSav = 0;   
    let flag = false;
    let startFlag = true;
    
    let count = parseInt(document.getElementById('actual').value);    
    let formattedTime = secondsToTime(count);
    document.getElementById('time').innerHTML = formattedTime;
    document.getElementById('actual2').value = formattedTime;

    //document.getElementById('showSubmit').disabled = true;

    // convert seconds to time
    function secondsToTime(ct) {

        let timeFlag = false;        
        // calculate time
        var seconds = ct % 60;
        var minutes = Math.floor(ct / 60) % 60;
        var hours = Math.floor(ct / (60 * 60)) % 24;
        // format time
        var fSeconds = (seconds < 10) ? "0"+seconds : seconds;
        var fMinutes = (minutes < 10) ? "0"+minutes : minutes;
        var fHours = (hours < 10) ? "0"+hours:  hours;
        
        var fTime = fHours + " : " + fMinutes + " : " + fSeconds;        
        return fTime;
    }

    // start the timer
    function startFunc() {
        flag = false;        
        document.getElementById('btn1').style.display = 'inline';
        document.getElementById('btn2').style.display = 'none';
        myVar = setInterval(myTimer, 100);
        autSav = setInterval(autoSave, 60000);
    }

    // stop the timer
    async function stopFunc() {

        try {

            let taskId = document.getElementById('id').value;
            let taskTime = document.getElementById('actual').value;
            const data = await postData('http://localhost:8000/autosave', { id: taskId, time: taskTime });
            //console.log("JSON| " + JSON.stringify(data)); // JSON-string from `response.json()` call

        } catch (error) {
            console.error("error message "+error);
        }

        clearInterval(myVar); 
        clearInterval(autSav);

        flag = true;
        // show or hide start or stop buttons
        document.getElementById('btn2').style.display = 'inline';
        document.getElementById('btn1').style.display = 'none';        

    }

    function myTimer() {
        count += 1;        
        let newTime = secondsToTime(count);

        document.getElementById("time").innerHTML = newTime;
        document.getElementById("actual").value = count;
        document.getElementById("actual2").value = count;
    }


    function handleChange() {
        let v = document.getElementById('chkBox').value;

        // if box is checked. Allow submit
        if (document.getElementById('chkBox').checked && flag === true) {
            document.getElementById('showSubmit').disabled = false;
        } else {
            document.getElementById('showSubmit').disabled = true;
        }
    }

    // auto save open task in data base every 1 minute

    async function autoSave() {        
        
        try {

            let taskId = document.getElementById('id').value;
            let taskTime = document.getElementById('actual').value;
            console.log(taskTime);
            const data = await postData('http://localhost:8000/autosave', { id: taskId, time: taskTime });
            console.log("JSON| " + JSON.stringify(data)); // JSON-string from `response.json()` call

        } catch (error) {
            console.error("error message "+error);
        }
    }
    

    async function postData(url = '', data = {}) {        
        // Default options are marked with *
        const response = await fetch(url, {
            method: 'POST', // *GET, POST, PUT, DELETE, etc.
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {                
                'Content-Type': 'application/json'
                //'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrer: 'no-referrer', // no-referrer, *client
            body: JSON.stringify(data) // body data type must match "Content-Type" header
        });        
        return await response.json(); // parses JSON response into native JavaScript objects
    }

    function verifySubmit(){
        var txt;
        if (confirm("You are about to DELETE a task! Are you sure you want to proceed?")) {
            return true;
        } else {
            return false;
        }        
    }
</script>

@endsection