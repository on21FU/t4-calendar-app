<?php
/*if(!(isset($_COOKIE["cookieMonth"]))){
    setcookie("cookieMonth", 'november');
    setcookie("cookieYear", 2022);
}*/

$data = $allData[1];
$monthsData = $allData[0];

$selectedMonth = $allData[2];
$selectedYear = $allData[3];


function debug_to_console($dataToConsole)
{
    $output = $dataToConsole;
    if (is_array($output)) {
        $output = implode(',', $output);
    }

    echo "<script>console.log('Debug Objects: " . $output . "' );</script>";
}

function convertDayToNumb($day)
{
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
function convertMonthToNumb($month)
{
    switch ($month) {
        case 'january':
            return 1;
            break;
        case 'february':
            return 2;
            break;
        case 'march':
            return 3;
            break;
        case 'april':
            return 4;
            break;
        case 'may':
            return 5;
            break;
        case 'june':
            return 6;
            break;
        case 'july':
            return 7;
            break;
        case 'august':
            return 8;
            break;
        case 'september':
            return 9;
            break;
        case 'october':
            return 10;
            break;
        case 'november':
            return 11;
            break;
        case 'december':
            return 12;
            break;
    }
}
function findActualMonthIndex($monat, $jahr, $monthsData)
{
    foreach ($monthsData as $key => $value) {
        if ($value['name'] == $monat && $value['year'] == $jahr) {
            return $key;
        }
    }
}
function convertArrayToJson($data)
{
    $newJson = json_decode($data, true);
    return $newJson;
}

function createCalendarArray($monthsData, $selectedMonth, $selectedYear, $data)
{
    $actualMonthIndex = findActualMonthIndex($selectedMonth, $selectedYear, $monthsData);
    $actualMonth = $monthsData[$actualMonthIndex];
    $prevMonth = $monthsData[$actualMonthIndex - 1];
    $nextMonth = $monthsData[$actualMonthIndex + 1];


    $calendarArray = ["<div class='weekday'>Mon</div>", "<div class='weekday'>Tue</div>", "<div class='weekday'>Wed</div>", "<div class='weekday'>Thu</div>", "<div class='weekday'>Fri</div>", "<div class='weekday'>Sat</div>", "<div class='weekday'>Sun</div>"];

    $stopper = convertDayToNumb($actualMonth['startDay']);

    for ($i = 1; $i < $stopper; $i++) {
        //füllt Array bis zum 1. mit den Zahlen vom vorherigen Monat auf
        $calendarArray[] = "<div class='prev-day'>" . $prevMonth['maxDays'] - $stopper + $i + '1' . '</div>';
    }
    for ($i = 1; $i <= $actualMonth['maxDays']; $i++) {
        //füllt Array von 1-maxDays
        $selectedDate = $selectedYear . '-' . convertMonthToNumb($selectedMonth) . '-' . sprintf('%02d', $i);
        $appointmentMarker = '';
        foreach ($data as $object) {
            if ($object->date == $selectedDate) {
                $appointmentMarker = "</br><p class='point' id='" . $i . "'>·</p>";
            }
        }
        if ($appointmentMarker == '') { //der aktuell ausgewählte Tag hat keinen Termin
            if($selectedDate == date("Y-m-d")){
                $calendarArray[] = "<div class='normalDay currentDay'><span>" . sprintf('%02d', $i) . $appointmentMarker . '</span></div>';
            } else {
                $calendarArray[] = "<div class='normalDay'><span>" . sprintf('%02d', $i) . $appointmentMarker . '</span></div>';
            }
        } else { //der aktuell ausgewählte Tag hat einen Termin
            if($selectedDate == date("Y-m-d")){
                $calendarArray[] = "<div class='normalDay hasAppointment currentDay' id='" . $i . "'><p id='" . $i . "'>" . sprintf('%02d', $i) . '</p>' . $appointmentMarker . '</div>';
            } else {
                $calendarArray[] = "<div class='normalDay hasAppointment' id='" . $i . "'><p id='" . $i . "'>" . sprintf('%02d', $i) . '</p>' . $appointmentMarker . '</div>';
            }
        }
    }
    $iteration = 1;
    while (count($calendarArray) % 7 != 0) {
        $calendarArray[] = "<div class='prev-day'>" . $iteration . '</div>';
        $iteration++;
    }

    return $calendarArray;
}

function importCalendar($monthsData, $selectedMonth, $selectedYear, $data)
{
    $calendarArray = createCalendarArray($monthsData, $selectedMonth, $selectedYear, $data);
    $calendar = '';
    foreach ($calendarArray as $day) {
        $calendar = $calendar . $day;
    }
    echo $calendar;
}
function openAppointmentInfo()
{
    $title = "<div class='appointmentInfoText'>Geburtstag Olli</div>";
    $date = "<div class='appointmentInfoText'>20.11.2022</div>";
    $startTime = "<div class='appointmentInfoText'>00:00</div>";
    $endTime = "<div class='appointmentInfoText'>00:00</div>";

    $value = "<div class='d-flex justify-content-center' style='gap:10px;'>" . $title . $date . $startTime . "<div class='appointmentInfoText'>-</div>" . $endTime . '</div>';

    echo $value;
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
            border: 1px groove rgba(0, 0, 0, 0.1);
            background-color: rgba(8, 214, 214, 0.1);
        }

        .weekday {
            background-color: #08D6D6 !important;
            font-weight: bold;
        }

        .prev-day {
            color: rgba(0, 0, 0, 0.3);
        }

        .normalDay {
            position: relative;
        }

        .normalDay .point {
            position: absolute;
            left: 50%;
            top: 70%;
            transform: translate(-50%, -50%);
            font-weight: bold;
            font-size: 30px;
            line-height: 5px;
            user-select: none;
        }

        .normalDay span {
            user-select: none;
        }

        .currentDay {
            background-color: rgba(8, 214, 214, 0.3) !important;
        }

        #insertAppointmentInfo p {
            display: inline-block;
            margin-right: 10px;
        }

        #insertAppointmentInfo #title {
            font-weight: bold;
        }
    </style>
    <div class="container mt-5">
        <div class="d-flex justify-content-center">
            <form action="" method="POST">
                @csrf
                <select name="selectMonth" id="selectMonth" onchange="reload()">
                    <option value="january">January</option>
                    <option value="february">February</option>
                    <option value="march">March</option>
                    <option value="april">April</option>
                    <option value="may">May</option>
                    <option value="june">June</option>
                    <option value="july">July</option>
                    <option value="september">September</option>
                    <option value="october">Oktober</option>
                    <option value="november">November</option>
                    <option value="december">Dezember</option>
                </select>
                <select name="selectYear" id="selectYear" onchange="reload()">
                    <option value="2022">2022</option>
                    <option value="2023">2023</option>
                    <option value="2024">2024</option>
                    <option value="2025">2025</option>
                </select>
            </form>
        </div>
        <div class="d-flex justify-content-center">
            <div class="col-3 text-center calendarGridParent">
                <?php importCalendar(convertArrayToJson($monthsData), $selectedMonth, $selectedYear, $data); ?>
            </div>
        </div>
        <div class="d-flex justify-content-center">
            <ul id="insertAppointmentInfo">

            </ul>
        </div>
        @php
            $selectedMonthNumb = convertMonthToNumb($selectedMonth);
            echo "<div class='d-none'><p id='selectedMonth'>$selectedMonthNumb</p><p id='selectedYear'>$selectedYear</p></div>";
        @endphp

        <div class="row">
            <div class="col-12">
                <h2 class="h2">Add Appointment</h2>
                <form method="post" action="saveAppointment">
                    @csrf
                    <label for="dateInput">Date:</label></br>
                    <input type="date" id="dateInput" name="dateInput" required></br>

                    <label for="titleInput">Title:</lavel></br>
                        <input type="text" id="titleInput" name="titleInput" required></br>

                        <label for="startTimeInput">Start Time:</label></br>
                        <input type="time" id="startTimeInput" name="startTimeInput" value="00:00"
                            onchange="checkTime('start')" required></br>

                        <label for="endTimeInput">End Time:</label></br>
                        <input type="time" id="endTimeInput" name="endTimeInput" value="00:00"
                            onchange="checkTime('end')" required></br>

                        <button class="btn btn-primary" type="submit">Create</button>
                        <a href="listAppointments" class="btn btn-danger">Back</a>
                </form>

            </div>
        </div>
    </div>
    <script>
        const dateElement = document.querySelector("#dateInput");
        const startTimeElement = document.querySelector("#startTimeInput");
        const endTimeElement = document.querySelector("#endTimeInput")

        const optionMonths = document.querySelectorAll('#selectMonth option');
        const optionYears = document.querySelectorAll('#selectYear option');

        preselectInput();
        function preselectInput(){
            $.ajax({
                type: "GET",
                url: 'getLastSelection',
                success: function(response) {
                    preMonth(response[0].month);
                    preYear(response[0].year);
                }
            })
        }
        function preMonth(month){
            optionMonths.forEach(option => {
                if(option.value == month){
                    option.setAttribute("selected", "selected");
                }
            });
        }
        function preYear(year){
            optionYears.forEach(option => {
                if(option.value == year){
                    option.setAttribute("selected", "selected");
                }
            });
        }





        dateElement.value = getCurrentDate();
        dateElement.min = getCurrentDate();
        dateElement.max = getMaxDate();

        function getCurrentDate() {
            let currentDate = new Date().toISOString();
            let currentDateArray = currentDate.split("T");
            return currentDateArray[0];
        }

        function getMaxDate() {
            let date = new Date();
            let dateInThreeYears = new Date(date.setFullYear(date.getFullYear() + 3));
            let dateArray = dateInThreeYears.toISOString().split("T");
            return dateArray[0];
        }

        function checkTime(switchTimeDirection) {
            let startDate = new Date(dateElement.value).valueOf();
            let endDate = new Date(dateElement.value).valueOf();
            let startTime = startTimeElement.value.split(":");
            let endTime = endTimeElement.value.split(":");
            if (startDate == endDate) {
                if ((startTime[0] > endTime[0]) || (startTime[0] = endTime[0] && startTime[1] > endTime[1])) {
                    if (switchTimeDirection == "start") {
                        endTimeElement.value = startTimeElement.value;
                    } else {
                        startTimeElement.value = endTimeElement.value;
                    }
                }
            }
        }

        const appointmentInfo = document.querySelector('#insertAppointmentInfo');
        const hasAppointmentButtons = document.querySelectorAll('.hasAppointment');
        const selectedYear = document.querySelector('#selectedYear').innerText;
        const selectedMonth = document.querySelector('#selectedMonth').innerText;

        hasAppointmentButtons.forEach((button) => {
            button.addEventListener("click", (e) => {
                let clickedDay = e.target.id;
                let clickedDate = `${selectedYear}-${selectedMonth}-${clickedDay}`;
                getAppointments(clickedDate);
            })
        });

        function getAppointments(date) {
            $.ajax({
                type: "GET",
                url: 'get-appointments-bydate',
                data: {
                    date: date
                },
                success: function(response) {
                    displaySelectedAppointments(response);

                }
            })
        }

        function displaySelectedAppointments(appointments) {
            appointmentInfo.innerHTML = appointments.map((appointment) => {
                return "<li class='mt-3'><p id='title'>" + appointment.title + "</p><p id='date'>" + appointment
                    .date + "</p><p id='startTime'>" + appointment.startTime + "</p><p id='endTime'>" + appointment
                    .endTime +
                    `</p><a href='{{ url('editAppointment/${appointment.id}') }}' class='btn btn-primary'>Edit</a><a href='{{ url('deleteAppointment/${appointment.id}') }}' class='btn btn-danger'>Delete</a></li>`;
            });
        }

        const selectMonth = document.querySelector('#selectMonth');
        const selectYear = document.querySelector('#selectYear');

        selectMonth.addEventListener('change', (e) => {
            changeSelectedMonth(e.target.value);
        });
        selectYear.addEventListener('change', (e) => {
            changeSelectedYear(e.target.value);
        });

        function changeSelectedMonth(month) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: 'inputSelectedMonth',
                data: {
                    month: month
                }
            })
        }

        function changeSelectedYear(year) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: "POST",
                url: 'inputSelectedYear',
                data: {
                    year: year
                }
            })
        }
        function reload(){
            setTimeout(() => {
                location.reload();
            }, 250);
        }

        
    </script>
</x-app-layout>
