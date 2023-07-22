@extends('management.index')


@section('function')
<i class="fa-solid fa-hamburger"></i> Create Table
<hr>

<form method="POST" action="{{ route('table.store') }}" >
    @csrf
    <div class="form-group">
      <label for="exampleInput">Table Name</label>
      <input name="name" type="text" value="{{ old('name') }}"  class="form-control bg-white my-3 @error('name') is-invalid @enderror" id="exampleInput" placeholder="Table">
            @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="btn btn-primary">Save</button>
  </form>
@endsection
