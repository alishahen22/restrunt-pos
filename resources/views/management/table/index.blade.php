@extends('management.index')


@section('function')
<i class="fa-solid fa-table"></i> Table
    <a style="float: right" href="{{ route('table.create') }}" class=" btn btn-success btn-sm"> <i class="fa-solid fa-plus"></i> Create Table</a>
<hr>
@if (session()->has('success'))
<div class="alert alert-success">
    {{ session()->get('success') }}
</div>
@endif
<div class="">
<table class="table table-bordered">
    <thead>
      <tr>
        <th scope="col">#</th>
        <th scope="col">Table</th>
        <th scope="col">Status</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>

      </tr>
    </thead>
    <tbody>
        @foreach ($tables as $table)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td >{{ $table->name }}</td>
            <td >{{ $table->status }}</td>
            <td><a href="{{ route('table.edit' , $table->id) }}" class="btn btn-warning">Edit</a></td>
            <td> <a data-bs-toggle="modal" class="btn btn-danger" data-bs-target="#deletemenuModal_{{$table->id}}"
                data-action="{{ route('table.destroy', $table->id) }}">Delete</a> </td>
          </tr>
          <div class="modal fade" id="deletemenuModal_{{$table->id}}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="deletemenuModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deletemenuModalLabel">Are You Sure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('table.destroy', $table->id) }}" method="post">
                    <div class="modal-body">
                      @csrf
                      @method('DELETE')
                      <h5 class="text-center"> you want to delete   {{ $table->name }}  ?</h5>
                    </div>
                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancel</button>
                      <button type="submit" class="btn btn-danger">Delete</button>
                    </div>
                </form>
                </div>
              </div>
            </div>

        @endforeach

    </tbody>

  </table>

<div > {{ $tables->links("pagination::bootstrap-4") }}</div>



  </div>


  <!-- Modal -->

@endsection
