@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-center card-header"><h4>Main Functions</h4></div>

                <div class="justify-content-center text-center card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <a  class="text-dark text-decoration-none" href="{{ route('management') }}">
                            <h4>Management</h4>
                            <img width="50px" class="img-fluid" src="{{ asset('image/management.png') }}" alt="">
                        </a>
                        </div>
                        <div class="col-md-4">
                            <a  class="text-dark text-decoration-none" href="{{ route('cashier') }}">

                            <h4>Cashier</h4>
                            <img width="50px" class="img-fluid" src="{{ asset('image/casher.png') }}" alt="">
                                </a>
                        </div>
                        <div class="col-md-4">
                            <a class="text-dark text-decoration-none" href="{{ route('report') }}">
                            <h4>Report</h4>
                            <img width="50px" class="img-fluid" src="{{ asset('image/report.png') }}" alt="">
                            </a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
