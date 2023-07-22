@extends('management.index')


@section('function')
<i class="fa-solid fa-align-justify"></i> Create Category
<hr>

<form method="POST" action="{{ route('category.store') }}">
    @csrf
    <div class="form-group">
      <label for="exampleInput">Category Name</label>
      <input name="name" type="text" class="form-control bg-white my-3" id="exampleInput" placeholder="Please Enter Category">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
