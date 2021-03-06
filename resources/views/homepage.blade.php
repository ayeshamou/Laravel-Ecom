@extends('header')
@section('body')

<div class="container-fluid">
    <br>
    <div class="row justify-content-center">
        <div class="col-8">
            <div class="container">
                <!-- creating table -->
                <table class="table table-dark table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>
                                Announcement Title
                            </th>
                            <th>
                                Announcement Detail
                            </th>
                            <th>
                                Publication Date
                            </th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($all_announcements as $announcement)
                        <tr>
                            <td>{{ $announcement ->announcement_title }}</td>
                            <td>{{ $announcement ->announcement_detail }}</td>
                            <td>{{ $announcement -> publication_date }}</td>
                            
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                 <a href = "{{ URL :: to('/all-announcements') }}" class = "btn btn-primary">See All announcements</a>
            </div>
        </div>
    </div>
    </div>
     
      
    @endsection