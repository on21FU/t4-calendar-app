<?php 

$selectedMonth = "july";
$selectedYear = 2023;

function debug_to_console($dataToConsole) {
    $output = $dataToConsole;
    if (is_array($output))
        $output = implode(',', $output);

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function convertDayToNumb($day){
    switch ($day) {
        case 'monday':
            return 1;
            break;
        case 'tuesday':
            return 2;
            break;
        case 'wednesday':
            return 3;
            break;
        case 'thursday':
            return 4;
            break;
        case 'friday':
            return 5;
            break;
        case 'saturday':
            return 6;
            break;
        case 'sunday':
            return 7;
            break;     
    }
}
function findActualMonthIndex($monat, $jahr, $monthsData){
    foreach ($monthsData as $key => $value) {
        if($value["name"]==$monat && $value["year"]==$jahr){
            return $key;
        }
    } 
}
function convertArrayToJson($data){
    $newJson = json_decode($data, true);
    return $newJson;
}

function createCalendarArray($monthsData, $selectedMonth, $selectedYear){
    
    $actualMonthIndex = findActualMonthIndex($selectedMonth, $selectedYear, $monthsData);
    $actualMonth = $monthsData[$actualMonthIndex];
    $prevMonth = $monthsData[$actualMonthIndex-1];
    $nextMonth = $monthsData[$actualMonthIndex+1];


    $calendarArray = array("<div class='weekday'>Mon</div>","<div class='weekday'>Tue</div>","<div class='weekday'>Wed</div>","<div class='weekday'>Thu</div>","<div class='weekday'>Fri</div>","<div class='weekday'>Sat</div>","<div class='weekday'>Sun</div>");
    


    $stopper = convertDayToNumb($actualMonth["startDay"]);
    
    for ($i=1; $i < $stopper; $i++) {   //füllt Array bis zum 1. mit den Zahlen vom vorherigen Monat auf
        $calendarArray []="<div class='prev-day'>".$prevMonth["maxDays"]-$stopper+$i+"1"."</div>";
    }
    for ($i=1; $i <= $actualMonth["maxDays"]; $i++) {  //füllt Array von 1-maxDays
        $calendarArray []= "<div>".$i."</div>";
    }
    $iteration = 1;
    while((count($calendarArray)%7)!=0){
        $calendarArray []= "<div class='prev-day'>".$iteration."</div>"; 
        $iteration++;
    }
      
    return $calendarArray;
}

function importCalendar($monthsData, $selectedMonth, $selectedYear){
    $calendarArray = createCalendarArray($monthsData, $selectedMonth, $selectedYear);
    $calendar = "";
    foreach ($calendarArray as $day) {
        $calendar = $calendar.$day;
    }
    echo $calendar;
}
?>
<x-app-layout>
    <style>
        .calendarGridParent {
            margin-top: 20px;
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            grid-template-rows: repeat(6, 1fr);
            grid-column-gap: 0px;
            grid-row-gap: 0px;
            }
        .calendarGridParent div {
            width: 45px;
            height: 45px;
            border: 1px groove rgba(0,0,0,0.1);
            background-color: rgba(8,214,214,0.1);
            padding-top: 5px;
        }
        .weekday {
            background-color: #08D6D6 !important; 
            font-weight: bold;
        }
        .prev-day {
            color: rgba(0,0,0,0.3);
        }
    </style>
    <div class="container mt-5">
        <div class="row">
            <select name="selectMonth" id="selectMonth" onchange="load_new_content()">
                <option value="january">January</option>
                <option value="february">February</option>
                <option value="march">March</option>
                <option value="april">April</option>
                <option value="may">May</option>
                <option value="june">June</option>
                <option value="july">July</option>
                <option value="september">September</option>
                <option value="oktober">Oktober</option>
                <option value="november">November</option>
                <option value="dezember">Dezember</option>
            </select>
            <select name="selectYear" id="selectYear" select="2023">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024" selected="selected">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="row justify-content-center">
            <div class="col-3 text-center calendarGridParent">
                <?php importCalendar(convertArrayToJson($monthsData), $selectedMonth, $selectedYear);?>                
            </div>
        </div>
        <label for="startDate">Start date:</label>
        <input type="date" id="startDate" name="startDate" onchange="checkDate('start')"></br>

        <label for="endDate">End date:</label>
        <input type="date" id="endDate" name="endDate" onchange="checkDate('end')"></br> 

        <label for="titleInput">Title:</lavel>
        <input type="text" id="titleInput" name="titleInput"></br>

        <label for="startTime">Start Time:</label>
        <input type="time" id="startTime" name="startTime" value="00:00" onchange="checkTime('start')"></br>

        <label for="endTime">End Time:</label>
        <input type="time" id="endTime" name="endTime" value="00:00" onchange="checkTime('end')"></br>
    </div> 
    <script>
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
            $.post("calendar", {option_value: selected_option_value},
                function(data){ //this will be executed once the `script_that_receives_value.php` ends its execution, `data` contains everything said script echoed.
                    $("#place_where_you_want_the_new_html").html(data);
                    alert(data); //just to see what it returns
                }
            );
        }
    </script>

    
</x-app-layout>
