@extends('layouts.app')

@section('content')
<style>

    .form-group {
      margin-bottom: 20px;
    }
    label {
      font-weight: bold;
    }
  </style>
@if(session('error'))
<div class="alert alert-danger">
    {{ session('error') }}
</div>
@endif
<div class="container">
    <h1>Reports </h1>
    <form method="GET" action="/getreport">
      <div class="form-group col-4">
        <label for="start-date">Start Date </label>
        <input type="date" class="form-control col-3" id="start-date" name="startDate">
      </div>
      <div class="form-group col-4">
        <label for="end-date"> End Date</label>
        <input type="date" class="form-control" id="end-date" name="endDate">
      </div>
      <input type="submit" value="show reports">
    </form>
  </div>

@endsection
