const startDateElement = document.querySelector("#startDate");
const endDateElement = document.querySelector("#endDate");
const startTimeElement = document.querySelector("#startTime");
const endTimeElement = document.querySelector("#endTime");

startDateElement.value = getCurrentDate();
startDateElement.min = getCurrentDate();
startDateElement.max = getMaxDate();
endDateElement.value = startDateElement.value;
endDateElement.min = startDateElement.value;
endDateElement.max = startDateElement.max;

function getCurrentDate(){
    let currentDate = new Date().toISOString();
    let currentDateArray = currentDate.split("T");
    return currentDateArray[0]; 
}
function getMaxDate(){
    let date = new Date();
    let dateInThreeYears = new Date(date.setFullYear(date.getFullYear() + 3));
    let dateArray = dateInThreeYears.toISOString().split("T");
    return dateArray[0];
}
function checkDate(switchDateDirection){
    let startDate = new Date(startDateElement.value).valueOf();
    let endDate = new Date(endDateElement.value).valueOf();
    if (startDate > endDate){
        if(switchDateDirection == "start"){
            endDateElement.value = startDateElement.value;
        } else {
            startDateElement.value = endDateElement.value;
        }
    }
}
function checkTime(switchTimeDirection){
    let startDate = new Date(startDateElement.value).valueOf();
    let endDate = new Date(endDateElement.value).valueOf();
    let startTime = startTimeElement.value.split(":");
    let endTime = endTimeElement.value.split(":");
    if (startDate == endDate){
        if((startTime[0] > endTime[0]) || (startTime[0] = endTime[0] && startTime[1] > endTime[1])){
            if(switchTimeDirection == "start"){
                endTimeElement.value = startTimeElement.value;
            } else {
                startTimeElement.value = endTimeElement.value;
            }
        }
    }
}
function load_new_content(){
    var selected_option_value=$("#select1 option:selected").val(); //get the value of the current selected option.
    $.post("calendar.blade.php", {option_value: selected_option_value},
        function(data){ //this will be executed once the `script_that_receives_value.php` ends its execution, `data` contains everything said script echoed.
            $("#place_where_you_want_the_new_html").html(data);
            alert(data); //just to see what it returns
        }
    );
}