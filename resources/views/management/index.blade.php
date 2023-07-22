@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
         <div class="list-group">
        <a href="{{ route('category.index') }}" class="list-group-item list-group-item-action"> <i class="fa-solid fa-align-justify"></i> Category  </a>
        <a href="{{ route('menu.index') }} "class="list-group-item list-group-item-action"><i class="fa-solid fa-hamburger"></i> Menu</a>
        <a href="{{ route('table.index') }}" class="list-group-item list-group-item-action"><i class="fa-solid fa-chair"></i> Table</a>
        <a href="#" class="list-group-item list-group-item-action"><i class="fa-solid fa-users-cog"></i> User</a>
        </div>
        </div>
        <div class="col-md-8">
            @yield('function')
        </div>

    </div>
</div>



@endsection
