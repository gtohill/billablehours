// GLOBAL VARIABLES
// get current domain
const DOMAIN = document.domain

let myVar = 0;
let autSav = 0;   
let flag = false;
let startFlag = true;

// get raw string of number to raw integer '3221' => 3221 from task.clienttask Open Task 
let count = parseInt(document.getElementById('actual').value);
// take count and convert to hours:minutes:seconds   
let formattedTime = secondsToTime(count);
// insert time to task.clienttask Open Task
document.getElementById('time').innerHTML = formattedTime;
// get the value from the task being moved from To Do task to open task
document.getElementById('actual2').value = formattedTime;

//document.getElementById('showSubmit').disabled = true;

// convert seconds to formatted time
function secondsToTime(rawSeconds) {

    let timeFlag = false;        
    // calculate time
    var seconds = rawSeconds % 60;
    var minutes = Math.floor(rawSeconds / 60) % 60;
    var hours = Math.floor(rawSeconds / (60 * 60)) % 24;
    // format time
    var formatSeconds = (seconds < 10) ? "0"+seconds : seconds;
    var formatMinutes = (minutes < 10) ? "0"+minutes : minutes;
    var formatHours = (hours < 10) ? "0"+hours:  hours;
    
    var formatTime = formatHours + " : " + formatMinutes + " : " + formatSeconds;        
    return formatTime;
}

// start the timer
function startFunc() {
    flag = false;
    // show or hide start or stop buttons        
    document.getElementById('btn1').style.display = 'inline';
    document.getElementById('btn2').style.display = 'none';
    
    // start timer
    myVar = setInterval(myTimer, 1000);

    // auto save open task everyone one minute
    autSav = setInterval(autoSave, 60000);
}

// stop the timer
async function stopFunc() {
    try 
    {
        let taskId = document.getElementById('id').value;
        let taskTime = document.getElementById('actual').value;
        const data = await postData(`https://${DOMAIN}/autosave`, { id: taskId, time: taskTime });
        //console.log("JSON| " + JSON.stringify(data)); // JSON-string from `response.json()` call

    } 
    catch (error) {
        console.error("error message "+error);
    }
    // stop main timer
    clearInterval(myVar); 
    // stop autosave timer
    clearInterval(autSav);

    flag = true;
    // show or hide start or stop buttons
    document.getElementById('btn2').style.display = 'inline';
    document.getElementById('btn1').style.display = 'none';        

}

function myTimer() {
    count += 1;  
    // input raw integer return formated time (60000 seconds => 1:00)      
    let newFormatedTime = secondsToTime(count);
    document.getElementById("time").innerHTML = newFormatedTime;
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
        const data = await postData(`https://${DOMAIN}/autosave`, { id: taskId, time: taskTime });
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