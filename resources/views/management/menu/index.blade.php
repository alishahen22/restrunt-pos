@extends('management.index')


@section('function')
<i class="fa-solid fa-hamburger"></i> Menu
    <a style="float: right" href="{{ route('menu.create') }}" class=" btn btn-success btn-sm"> <i class="fa-solid fa-plus"></i> Create Menu</a>
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
        <th scope="col">Name</th>
        <th scope="col">Price</th>
        <th scope="col">picture</th>
        <th scope="col">Description</th>
        <th scope="col">Category</th>
        <th scope="col">Edit</th>
        <th scope="col">Delete</th>

      </tr>
    </thead>
    <tbody>
        @foreach ($menus as $menu)
        <tr>
            <td>{{ $loop->index+1 }}</td>
            <td >{{ $menu->name }}</td>
            <td >{{ $menu->price }}</td>
            <td ><img src="{{ asset('menueImages/'.$menu->image) }}" alt="" width="100px" height="100px" ></td>
            <td >{{ $menu->description }}</td>
            <td >{{ $menu->category->name }}</td>
            <td><a href="{{ route('menu.edit' , $menu->id) }}" class="btn btn-warning">Edit</a></td>
            {{-- <td><button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Delete </button></td> --}}
           <td> <a data-bs-toggle="modal" class="btn btn-danger" data-bs-target="#deletemenuModal_{{$menu->id}}"
                data-action="{{ route('menu.destroy', $menu->id) }}">Delete</a> </td>

          </tr>
        <!-- Delete menu Modal -->
        <div class="modal fade" id="deletemenuModal_{{$menu->id}}" data-backdrop="static" tabindex="-1" role="dialog"
            aria-labelledby="deletemenuModalLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="deletemenuModalLabel">Are You Sure</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <form action="{{ route('menu.destroy', $menu->id) }}" method="post">
                    <div class="modal-body">
                      @csrf
                      @method('DELETE')
                      <h5 class="text-center"> you want to delete   {{ $menu->name }}  ?</h5>
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

<div > {{ $menus->links("pagination::bootstrap-4") }}</div>



  </div>


  <!-- Modal -->

@endsection
