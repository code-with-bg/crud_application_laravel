@extends('layout')

@section('content')
    <div class="col-md-12">
        <div class="container mt-3" >
            @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{Session::get('success')}}
            </div>
            @endif
            <span class="fw-bold fs-3">Student List</span>
            <div style="float:right">
                <a href="{{url('add-student')}}" class="btn btn-primary">Add Student</a>
            </div>
            <hr>
            <div>
                <table class="table">
                    <thead>
                        <th>S.N</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Image</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                        @php
                           $i=1; 
                        @endphp
                        @foreach ($data as $stu)
                        <tr>
                            <td>{{$i++}}</td>
                            <td>{{$stu->name}}</td>
                            <td>{{$stu->email}}</td>
                            <td>{{$stu->phone}}</td>
                            <td>{{$stu->address}}</td>
                            <td> <img src="/uploads/students/{{ $stu->image }}" width="50px" height="50px"></td>
                            <td>
                                <a href="{{url('edit-student/'.$stu->id)}}" class="btn btn-primary">Edit</a>
                                <a href="{{url('delete-student/'.$stu->id)}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
      </div>  
   @endsection