// Davis Djaja, 17981197
//Javascript file to handle ajax post request for searching for a booking

var xhr = createRequest();

//function to handle searching
function getData(dataSource, divID, aRef) {
  if (xhr) {
    var obj = document.getElementById(divID); //Target div\
    var form = document.getElementById("searchform");

    //prevent the form from refreshing after submitting
    function handleForm(event) {
      event.preventDefault();
    } 

    form.addEventListener("sbutton", handleForm);
    var requestbody = "bsearch=" + encodeURIComponent(aRef);


    xhr.open("POST", dataSource, true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function () {
      if (xhr.readyState == 4 && xhr.status == 200) {
        obj.innerHTML = xhr.responseText;
      }
    };
    xhr.send(requestbody);
  }
}



