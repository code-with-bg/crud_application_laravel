@extends('layout')
<style>
  #desgin{
    background-color:rgb(205, 205, 211) !important;
  }
  .col-md-3{
    display: flex !important;
    justify-content: center !important;
    margin-bottom: 5px !important;
  }
  #_Header{
    font-family: Georgia, 'Times New Roman', Times, serif
  }
</style>
@section('content')
<div class="container-fluid w-100" id="desgin">
  <div class="row">
    <div class="col-md-12 d-flex justify-content-center">
      <h1 id="_Header">IS ANYONE FUN WITH FRIENDS</h1>
    </div>
  </div>
    <div class="row mt-2 p-2" style="height: 82vh; overflow: scroll; display:flex; justify-content:center;">
      {{-- @php 
      $i=1;
      @endphp  --}}
      @foreach ($data as $stu)
        <div class="col-md-3">
            <div class="card" style="width: 18rem;">
              <img src="/uploads/students/{{ $stu->image }}" class="card-img-top" alt="...">
              <div class="card-body">
                <h5 class="card-title">Name:  {{$stu->name}}</h5>
                <p class="card-text">Email: {{$stu->email}}</p>
                <p class="card-text">Mobile:  {{$stu->phone}}</p>
                <p class="card-text">Address: {{$stu->address}}</p>
                <h6 class="card-title">Post Date: {{$stu->created_at}}</h6>
                </div>
              </div>
        </div>
       @endforeach
    </div>
</div>
@endsection