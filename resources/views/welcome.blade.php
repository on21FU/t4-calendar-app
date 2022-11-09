<?php 


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
                <div class="weekday">Mon</div>
                <div class="weekday">Tue</div>
                <div class="weekday">Wed</div>
                <div class="weekday">Thu</div>
                <div class="weekday">Fri</div>
                <div class="weekday">Sat</div>
                <div class="weekday">Sun</div>
                <div class="prev-day">31</div>
                <div>1</div>
                <div>2</div>
                <div>3</div>
                <div>4</div>
                <div>5</div>
                <div>6</div>
                <div>7</div>
                <div>8</div>
                <div>9</div>
                <div>10</div>
                <div>11</div>
                <div>12</div>
                <div>13</div>
                <div>14</div>
                <div>15</div>
                <div>16</div>
                <div>17</div>
                <div>18</div>
                <div>19</div>
                <div>20</div>
                <div>21</div>
                <div>22</div>
                <div>23</div>
                <div>24</div>
                <div>25</div>
                <div>26</div>
                <div>27</div>
                <div>28</div>
                <div>29</div>
                <div>30</div>
                <div class="prev-day">1</div>
                <div class="prev-day">2</div>
                <div class="prev-day">3</div>
                <div class="prev-day">4</div>
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
