// Davis Djaja, 17981197 
//Javascript file to generate date and time for the booking form as well as handle the ajax

var xhr = createRequest();

//function to handle booking submission
function submitData(dataSource, divID, aName, aPhone, aUnitNum, aSnum, aStname, aSbname, aDsbname, aDate, aTime)  {

  if(aName === "" || aPhone === "" || aSnum === "" || aStname === "" || aTime < timeNow){
    alert("Fill in all required fields and correctly!");
    return false;
  } else {
    if(xhr) {
      var obj = document.getElementById(divID);	//Target div
      var form = document.getElementById("bookingform");
      function handleForm(event) { event.preventDefault(); } //prevent the form from refreshing after submitting
      form.addEventListener('submit', handleForm);
      var requestbody = "name="+encodeURIComponent(aName)+"&phone="+encodeURIComponent(aPhone)+"&unitNum="+encodeURIComponent(aUnitNum)
      +"&sNum="+encodeURIComponent(aSnum)+"&stName="+encodeURIComponent(aStname)+"&sbName="+encodeURIComponent(aSbname)
      +"&dsbName="+encodeURIComponent(aDsbname)+"&date="+encodeURIComponent(aDate)+"&time="+encodeURIComponent(aTime);
  
      xhr.open("POST", dataSource, true);
      xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
      xhr.onreadystatechange = function() {
      if (xhr.readyState == 4 && xhr.status == 200) {
          obj.innerHTML = xhr.responseText;
        } 
      }
      xhr.send(requestbody);
    }
  }
} 

//Few functions and variables to get the html form to display current date and time with a format
const [date, time] = formatDate(new Date()).split(' ');

//Set min date
var today = new Date();
var dd = today.getDate();
var mm = today.getMonth()+1; //January set to 0, need to add 1
var yyyy = today.getFullYear();
if(dd<10){
  dd='0'+dd;
} 
if(mm<10){
  mm='0'+mm;
} 

today = yyyy+'-'+mm+'-'+dd;

//Set min & time
var timeNow = new Date();
var hour = timeNow.getHours();
var minutes = timeNow.getMinutes();
if(hour<10){
  hour='0'+hour;
} 
if(minutes<10){
  minutes='0'+minutes;
} 

timeNow = hour+":"+minutes;


const dateInput = document.getElementById('date');
dateInput.value = date;
dateInput.setAttribute("min", today);

const timeInput = document.getElementById('time');
timeInput.value = time;
timeInput.setAttribute("min", timeNow);

function padTo2Digits(num) {
  return num.toString().padStart(2, '0');
}

//Format date
function formatDate(date) {
  return (
    [
      date.getFullYear(),
      padTo2Digits(date.getMonth() + 1),
      padTo2Digits(date.getDate()),
    ].join('-') +
    ' ' +
    [
      padTo2Digits(date.getHours()),
      padTo2Digits(date.getMinutes()),
    ].join(':')
  );
}


