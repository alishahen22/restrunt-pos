<table class="table table-striped">
    <thead>
      <tr>
        <th>#</th>
        <th>table name</th>
        <th>total price</th>
        <th>payment Type</th>
        <th>Time</th>
      </tr>
    </thead>
    <tbody>

        @foreach ($sales as $sale)
        <tr >
            <th>{{$loop->index+1}}</th>
            <th>{{$sale->table->name}}</th>
            <th>{{$sale->total_price}}</th>
            <th>{{$sale->payment_type}}</th>
            <th>{{$sale->created_at->format('Y-m-d')}}</th>
        </tr>
        <tr>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>quantity</th>
                <th>price</th>
                <th>Time</th>

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
