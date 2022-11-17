<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2 class="h2">Appointment List</h2>
                <form method="post" action="saveAppointment">
                    @csrf
                    <label for="dateInput">Date:</label>
                    <input type="date" id="dateInput" name="dateInput" required></br>
    
                    <label for="titleInput">Title:</lavel>
                    <input type="text" id="titleInput" name="titleInput" required></br>
    
                    <label for="startTimeInput">Start Time:</label>
                    <input type="time" id="startTimeInput" name="startTimeInput" value="00:00" onchange="checkTime('start')" required></br>
    
                    <label for="endTimeInput">End Time:</label>
                    <input type="time" id="endTimeInput" name="endTimeInput" value="00:00" onchange="checkTime('end')" required></br>      
                    
                    <button class="btn btn-primary" type="submit">Create</button>
                    <a href="listAppointments" class="btn btn-danger">Back</a>
                </form>

            </div>
        </div>
    </div>
    <script>
        const dateElement = document.querySelector("#dateInput");
        const startTimeElement = document.querySelector("#startTimeInput");
        const endTimeElement = document.querySelector("#endTimeInput");

        dateElement.value = getCurrentDate();
        dateElement.min = getCurrentDate();
        dateElement.max = getMaxDate();

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
        function checkTime(switchTimeDirection){
            let startDate = new Date(dateElement.value).valueOf();
            let endDate = new Date(dateElement.value).valueOf();
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