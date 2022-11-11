<?php 

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
    $index = array_search($jahr, $monthsData->year);
    debug_to_console($index);

}

function createCalendarArray($monthsData){
    $monat = "november";
    $jahr = 2022;

    $actualMonthIndex = findActualMonthIndex($monat, $jahr, $monthsData);
    $prevMonthIndex;
    $nextMonthIndex;

    $calendarArray = array("<div class='weekday'>Mon</div>","<div class='weekday'>Tue</div>","<div class='weekday'>Wed</div>","<div class='weekday'>Thu</div>","<div class='weekday'>Fri</div>","<div class='weekday'>Sat</div>","<div class='weekday'>Sun</div>");
    
    /*$stopper = convertDayToNumb($monthsData[0]->startDay);
    
    for ($i=1; $i < $stopper; $i++) {   //füllt Array bis zum 1. mit den Zahlen vom vorherigen Monat auf
        $calendarArray []="<div class='prev-day'>p</div>";
    }
    $calendarArray []= "<div>1</div>";*/
    //debug_to_console($monthsData);
    

    return $calendarArray;
}

function importCalendar($monthsData){
    $calendarArray = createCalendarArray($monthsData);
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
            <select name="selectMonth" id="selectMonth">
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
            <select name="selectYear" id="selectYear">
                <option value="2022">2022</option>
                <option value="2023">2023</option>
                <option value="2024">2024</option>
                <option value="2025">2025</option>
            </select>
        </div>
        <div class="row justify-content-center">
            <div class="col-3 text-center calendarGridParent">
                <?php importCalendar($monthsData);?>
                
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

    </script>
    
</x-app-layout>
