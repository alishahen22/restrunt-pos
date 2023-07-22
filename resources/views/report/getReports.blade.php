@extends('layouts.app')

@section('content')
@if (count($sales)==0)
    <div  style="text-align:center;">
        <h2>No Invoices in this time</h2>

    </div>
    @else
    <div class="container h-100">
        <div class="row justify-content-end h-100 align-items-center">
          <div class="col-md-6">
            <div class="text-right">
              <h2>You have {{ count($sales) }} invoices</h2>
              <h2>Total price is {{ $totalPrice }} $</h2>
            </div>
            <form method="GET" action="{{ route('result-exel') }}">
             <input type="hidden" name="dateStart" value="{{   $fromDate }}">
             <input type="hidden" name="dateend" value="{{   $toDate }}">

           <input type="submit" class=" bg-success text-white" value="extact to exel">
       </form>
         </div>
            </div>

          </div>

    <div class="container">


    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">table name</th>
            <th scope="col">total price</th>
            <th scope="col">payment Type</th>
            <th scope="col">Time</th>
          </tr>
        </thead>
        <tbody>

            @foreach ($sales as $sale)
            <tr style="background-color:#5b5bff;">
                <th>{{$loop->index+1}}</th>
                <th>{{$sale->table->name}}</th>
                <th>{{$sale->total_price}}</th>
                <th>{{$sale->payment_type}}</th>
                <th>{{$sale->created_at->format('Y-m-d')}}</th>
            </tr>
            <tr>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">name</th>
                    <th scope="col">quantity</th>
                    <th scope="col">price</th>
                    <th scope="col">Time</th>

                  </tr>
                        @foreach ($sale->saleDetails as $invoce)
                        <tr>
                            <th>{{$loop->index+1}}</th>
                            <td>{{$invoce->menu_name}}</td>
                            <td>{{$invoce->quentity}}</td>
                            <td>{{$invoce->menu_price}}</td>
                            <td>{{$invoce->created_at}}</td>
                        @endforeach
            @endforeach
        </tbody>
      </table>
@endif




@endsection
