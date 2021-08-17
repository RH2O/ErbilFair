
var currentTab = 0; // Current tab is set to be the first tab (0)
showTab(currentTab); // Display the current tab

function showTab(n) {
  document.getElementsByClassName("circle-round")[0].className += " active";

// This function will display the specified tab of the form...
var x = document.getElementsByClassName("tab");
x[n].style.display = "block";
//... and fix the Previous/Next buttons:
if (n == (x.length - 1)) {
  document.getElementById("toSubmit").innerHTML = `<button type="submit" class="nextButton arrow-bu sub" name="submit" id="nextBtn" onclick="nextPrev(1)">Submit</button>`;
// document.getElementById("nextBtn").innerHTML = "SUBMIT";
// document.getElementsByClassName("nextButton")[0].className += " sub";
} else {
document.getElementById("nextBtn").innerHTML = "NEXT";
}
//... and run a function that will display the correct step indicator:
// fixStepIndicator(n)
}

function nextPrev(n) {
// This function will figure out which tab to display
var x = document.getElementsByClassName("tab");
// Exit the function if any field in the current tab is invalid:
if (n == 1 && !validateForm()) return false;
// Hide the current tab:
x[currentTab].style.display = "none";
// Increase or decrease the current tab by 1:
currentTab = currentTab + n;
// if you have reached the end of the form...
if (currentTab >= x.length) {
// ... the form gets submitted:
document.getElementById("regForm").submit();
return false;
}
// Otherwise, display the correct tab:
showTab(currentTab);

if(n==-1){
 
  $('.nextButton').removeClass(' sub');


}



}

function validateForm() {
// This function deals with validation of the form fields
var x, y, i, valid = true;
x = document.getElementsByClassName("tab");
y = x[currentTab].getElementsByTagName("input");
// A loop that checks every input field in the current tab:
for (i = 0; i < y.length; i++) {
// If a field is empty...
if(y[i].hasAttribute("required")){
if (y[i].value == "") {
  // and set the current valid status to false
  valid = false;
}

}

}
// If the valid status is true, mark the step as finished and valid:
if (valid) {

  if(currentTab==0){
    document.getElementsByClassName("circle-round")[0].className += " active";

    
    // document.getElementsByClassName("circle-round")[0].className += " active";
  }
  if(currentTab==1){
    document.getElementsByClassName("circle-round")[0].className += " finish";
    document.getElementsByClassName("info")[0].className += " info-bold";
    document.getElementsByClassName("dis-num")[0].className += " hidden-num";
    document.getElementsByClassName("circle-round")[1].className += " active";

  }
  if(currentTab==2){
    document.getElementsByClassName("circle-round")[1].className += " finish";
    document.getElementsByClassName("info")[1].className += " info-bold";
    document.getElementsByClassName("dis-num")[1].className += " hidden-num";
    document.getElementsByClassName("circle-round")[2].className += " active";

  }
  if(currentTab==3 ){
    document.getElementsByClassName("circle-round")[2].className += " finish";
    document.getElementsByClassName("info")[2].className += " info-bold";
    document.getElementsByClassName("dis-num")[2].className += " hidden-num";
  }

}
return valid; // return the valid status
}

// function fixStepIndicator(n) {
// // This function removes the "active" class of all steps...
// var i, x = document.getElementsByClassName("circle-round");
// for (i = 0; i < x.length; i++) {
//   if(currentTab==0)
// x[i].className = x[i].className.replace(" active", "");
// }
// //... and adds the "active" class on the current step:
// x[n].className += " active";
// }




///// check if the email is already registerd or not

function validateemail() {

  var request;
  
  try {
  
  request= new XMLHttpRequest();
  
  }
  
  catch (tryMicrosoft) {
  
  try {
  
  request= new ActiveXObject("Msxml2.XMLHTTP");
  }
  
  catch (otherMicrosoft) 
  {
  try {
  request= new ActiveXObject("Microsoft.XMLHTTP");
  }
  
  catch (failed) {
  request= null;
  }
  }
  }
  
  
  
  var url= "emailvalidation.php";
  var emailaddress= document.getElementById("email").value;
  var vars= "email="+emailaddress;
  request.open("POST", url, true);
  
  request.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
  
  request.onreadystatechange= function() {
  if (request.readyState == 4 && request.status == 200) {
    var return_data=  request.responseText;
    document.getElementById("validate").innerHTML= return_data;
  }
  }
  
  request.send(vars);
  }
  
  
  
  