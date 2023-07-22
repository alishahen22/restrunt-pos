@extends('management.index')


@section('function')
<i class="fa-solid fa-align-justify"></i> Edit Table
<hr>

<form method="POST" action="{{ route('table.update' ,$table->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="exampleInput">Table Name</label>
        <input name="name" type="text" value="{{ $table->name }}"  class="form-control bg-white my-3 @error('name') is-invalid @enderror" id="exampleInput" placeholder="Please Enter Category">
              @error('name')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>


    <button type="submit" class="btn btn-warning">Edit</button>
  </form>
@endsection
