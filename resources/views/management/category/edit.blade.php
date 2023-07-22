@extends('management.index')


@section('function')
<i class="fa-solid fa-align-justify"></i> Edit Category
<hr>

<form method="POST" action="{{ route('category.update' ,$category->id) }}">
    @csrf
    @method('PUT')
    <div class="form-group">
      <label for="exampleInput">Category Name</label>
      <input name="name" type="text" class="form-control bg-white my-3" id="exampleInput" value="{{ $category->name }}">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Update</button>
  </form>
@endsection
