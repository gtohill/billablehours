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
    myVar = setInterval(myTimer, 1000);
    autSav = setInterval(autoSave, 60000);
}

// stop the timer
async function stopFunc() {

    try 
    {

        let taskId = document.getElementById('id').value;
        let taskTime = document.getElementById('actual').value;
        const data = await postData('http://localhost:8000/autosave', { id: taskId, time: taskTime });
        //console.log("JSON| " + JSON.stringify(data)); // JSON-string from `response.json()` call

    } 
    catch (error) {
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