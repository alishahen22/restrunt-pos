@extends('management.index')


@section('function')
<i class="fa-solid fa-align-justify"></i> Category
    <a style="float: right" href="{{ route('category.create') }}" class=" btn btn-success btn-sm"> <i class="fa-solid fa-plus"></i> Create Category</a>
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
        <th scope="col">Category</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>
      </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td >{{ $category->name }}</td>
            <td><a href="{{ route('category.edit' , $category->id) }}" class="btn btn-warning">Edit</a></td>
            <td> <a data-bs-toggle="modal" class="btn btn-danger" data-bs-target="#deletemenuModal_{{$category->id}}"
                data-action="{{ route('menu.destroy', $category->id) }}">Delete</a> </td>
          </tr>
                 <!-- Delete menu Modal -->
        <div class="modal fade" id="deletemenuModal_{{$category->id}}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="deletemenuModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deletemenuModalLabel">Are You Sure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('category.destroy', $category->id) }}" method="post">
                    <div class="modal-body">
                      @csrf
                      @method('DELETE')
                      <h5 class="text-center"> you want to delete   {{ $category->name }}  ?</h5>
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

<div > {{ $categories->links("pagination::bootstrap-4") }}</div>



  </div>



@endsection
