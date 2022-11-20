<x-app-layout>
    <div class="container mt-5">
        <div class="row">
            <div class="col-12">
                <h2 class="h2">Appointment List</h2>
                @if(Session::has('success'))
                <div class="alert alert-success" role="alert">
                    {{Session::get('success')}}
                </div>
                @endif
                <div style="float: right;">
                    <a href="addAppointment" class="btn btn-primary">Add</a>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Titel</th>
                            <th>Datum</th>
                            <th>Start Uhrzeit</th>
                            <th>End Uhrzeit</th>
                            <th>User ID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data as $item)
                            <tr>
                                <td>{{$item->id}}</td>
                                <td>{{$item->title}}</td>
                                <td>{{$item->date}}</td>
                                <td>{{$item->startTime}}</td>
                                <td>{{$item->endTime}}</td>
                                <td>{{$item->userId}}</td>
                                <td><a href="{{url('editAppointment/'.$item->id)}}" class="btn btn-primary">Edit</a> | <a href="{{url('deleteAppointment/'.$item->id)}}" class="btn btn-danger">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</x-app-layout>
