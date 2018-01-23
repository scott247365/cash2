<div id="clockdiv">

<div style="height: 10px; display: block; color: black; font-size:10px;">
<span style="color: white;">Break:</span>
<select id="hour1" onchange="start()">
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17" selected>17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
</select>
<select id="min1" onchange="start()">
  <option value="0">00</option>
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
</select>
<select id="length1" onchange="start()">
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option>
  <!-- option value="5">5</option>
  <option value="10">10</option>
  <option value="15">15</option>
  <option value="20">20</option>
  <option value="25">25</option>
  <option value="30">30</option>
  <option value="35">35</option>
  <option value="40">40</option>
  <option value="45">45</option>
  <option value="50">50</option>
  <option value="55">55</option>
  <option value="60">60</option>
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option -->
</select>
</div>

<div style="height: 10px; display: block; color: black; font-size:10px;">
<span style="color: white;">Lunch:</span>
<select id="hour2" onchange="start()">
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19" selected>19</option>
  <option value="20">20</option>
  <option value="21">21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
</select>
<select id="min2" onchange="start()">
  <option value="0">00</option>
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
</select>
<select id="length2" onchange="start()">
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option>
</select>
</div>

<div style="height: 10px; display: block; color: black; font-size:10px;">
<span style="color: white;">Break:</span>
<select id="hour3" onchange="start()">
  <option value="6">6</option>
  <option value="7">7</option>
  <option value="8">8</option>
  <option value="9">9</option>
  <option value="10">10</option>
  <option value="11">11</option>
  <option value="12">12</option>
  <option value="13">13</option>
  <option value="14">14</option>
  <option value="15">15</option>
  <option value="16">16</option>
  <option value="17">17</option>
  <option value="18">18</option>
  <option value="19">19</option>
  <option value="20">20</option>
  <option value="21" selected>21</option>
  <option value="22">22</option>
  <option value="23">23</option>
  <option value="24">24</option>
</select>
<select id="min3" onchange="start()">
  <option value="0">00</option>
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
</select>
<select id="length3" onchange="start()">
  <option value="15">15</option>
  <option value="30">30</option>
  <option value="45">45</option>
  <option value="60">60</option>
</select>
</div>


<!-- h1>Time Remaining:</h1 -->
<h1></h1>
  <div>
    <span class="hours"></span>
    <!-- div class="smalltext">Hours</div -->
  </div>
  <div class="colon">:</div>
  <div>
    <span class="minutes"></span>
    <!-- div class="smalltext">Minutes</div -->
  </div>
  <div class="colon">:</div>
  <div>
    <span class="seconds"></span>
    <!-- div class="smalltext">Seconds</div -->
  </div>
</div>
<div>
  <span id="dbg"></span>
</div>

<script>

var times = null; //[1, 0.5, 0.1, 0.5, 0.1, 0.5];

var ix = 0;
var deadline = null;
var timeinterval = null;
var timercount = 0;

function getTimeRemaining(endtime) 
{
  var t = endtime - new Date();
  
  var seconds = Math.floor((t / 1000) % 60);
  var minutes = Math.floor((t / 1000 / 60) % 60);
  var hours = Math.floor((t / (1000 * 60 * 60)) % 24);
  var days = Math.floor(t / (1000 * 60 * 60 * 24));
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}

function clearDebug(info)
{
	var d = document.getElementById('dbg');
	d.innerHTML = "";
}

function showDebug(info)
{
	//var d = document.getElementById('dbg');
	//d.innerHTML = d.innerHTML + '<br/>' + info;
}

function initializeClock(id, endtime) 
{
	showDebug("init clock: " + endtime);
	//dump();
	
	var clock = document.getElementById(id);
	var hoursSpan = clock.querySelector('.hours');
	var minutesSpan = clock.querySelector('.minutes');
	var secondsSpan = clock.querySelector('.seconds');
    
	function updateClock() 
	{
		var t = getTimeRemaining(endtime);

		hoursSpan.innerHTML = ('0' + t.hours).slice(-2);
		minutesSpan.innerHTML = ('0' + t.minutes).slice(-2);
		secondsSpan.innerHTML = ('0' + t.seconds).slice(-2);

		// if time is up
		if (t.total <= 0 && timeinterval != null) 
		{
			showAlarm();
			showDebug("clear timeinterval: " + timeinterval);	  
			
			timercount--;
			clearInterval(timeinterval);
		  
			ix++;
		  
			// if anymore times are defined
			if (ix < times.length)
			{
				//deadline = new Date(Date.parse(times[ix]));
				//initializeClock('clockdiv', deadline);
			
				showDebug('init: ix = ' + ix);
				initializeClock('clockdiv', times[ix]);	
			}
			else
			{
				// this is the end
				showDebug("THIS IS THE END");
				return;
			
				hoursSpan.innerHTML = "";
				minutesSpan.innerHTML = "";
				secondsSpan.innerHTML = "";
				showOddColor();
				document.body.style.backgroundColor = "red";
				document.getElementById("clockdiv").style.backgroundColor = "red";
			}
		}
	}

	updateClock();
	timercount++;
	showDebug("start timeinterval: " + timeinterval + ", " + timercount);
	clearInterval(timeinterval);
	timeinterval = setInterval(updateClock, 1000);
	showAlarm();
}

var color = 0;
function showAlarm()
{
	//changeColor((color % 2) == 0);
	showDebug(ix);
	if (ix % 2)
	{
		document.body.style.backgroundColor = "red";
		document.getElementById("clockdiv").style.backgroundColor = "red";
	}
	else
	{
		document.body.style.backgroundColor = "white";
		document.getElementById("clockdiv").style.backgroundColor = "blue";
	}	
}

function changeColor(odd = false)
{
	if (!odd)
	{
		document.body.style.backgroundColor = "red";
		document.getElementById("clockdiv").style.backgroundColor = "red";
	}
	else
	{
		document.body.style.backgroundColor = "white";
		document.getElementById("clockdiv").style.backgroundColor = "blue";
	}
}

function loadTimes()
{  
	//clearDebug();
	
	var d = [];
	var index = 0;
	for (var i = 0; i < 20; i++)
	{
		var h = getValue("hour", i + 1);
		var m = getValue("min", i + 1);
		var l = getValue("length", i + 1);
		
		if (h == null || m == null || l == null)
			break;

		h = parseInt(h);
		m = parseInt(m);
		l = parseInt(l);
		
		d[index] = new Date();
		d[index].setHours(h);
		d[index].setMinutes(m);
		d[index].setSeconds(0);
		index++;

		d[index] = new Date();
		d[index].setHours(h);
		d[index].setMinutes(m + l);
		d[index].setSeconds(0);			
		index++;		
	}	
			
	return d;
}

function getValue(tag, id)
{
	var v = tag + id.toString()
	v = document.getElementById(v);	
	if (v != null)
		v = v.value;
	
	return v;
}

function setDeadline(minutes)
{
	deadline = new Date(Date.parse(new Date()) + minutes * 60 * 1000);
	setDebug(deadline);
	return;
}

function start()
{
	ix = 0;
	color = 0;
	timercount--;
	clearInterval(timeinterval);
	timeinterval = null;
	times = loadTimes();
			
	showDebug("start");
	initializeClock('clockdiv', times[ix]);	
}

function dump()
{
	//clearDebug();
	
	//for (var j = 0; j < times.length; j++)
	//	showDebug(times[j])
	//showDebug(times[ix])
	
	showDebug("ix = " + ix);
    var t = getTimeRemaining(times[ix]);
	//showDebug("rem: " + t.total);		
	//showDebug("times: " + times.length);		
}

</script>

<style>

body{
	text-align: center;
	background: white;
  font-family: sans-serif;
  font-weight: 100;
}

h1{
  color: white;
  font-weight: 100;
  font-size: 30px;
  margin: 40px 0px 20px;
}

#clockdiv{
  background-color: blue;
	font-family: sans-serif;
	color: #fff;
	display: inline-block;
	font-weight: 100;
	text-align: center;
	font-size: 30px;
  padding: 10px 50px 50px 50px;
  border-radius: 10px;
  min-width:350px;
}

#clockdiv > div{
	padding: 10px;
	display: inline-block;
}

#clockdiv div > span{
	padding: 5px;
	display: inline-block;
}

.smalltext{
	padding-top: 5px;
	font-size: 16px;
}

.colon {
  vertical-align:top;
  padding-top:5px;
  xcolor:green;
}

</style>


