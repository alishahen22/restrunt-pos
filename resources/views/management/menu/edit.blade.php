@extends('management.index')


@section('function')
<i class="fa-solid fa-align-justify"></i> Edit Menu
<hr>

<form method="POST" action="{{ route('menu.update' ,$menu->id) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="form-group">
        <label for="exampleInput">Menue Name</label>
        <input name="name" type="text" value="{{ $menu->name }}"  class="form-control bg-white my-3 @error('name') is-invalid @enderror" id="exampleInput" placeholder="Please Enter Category">
              @error('name')
              <div class="alert alert-danger">{{ $message }}</div>
          @enderror
      </div>
      <label for="price">price</label>

      <div class="input-group my-3">
          <span class="input-group-text " id="basic-addon1">$</span>

          <input type="text" id="price" value="{{$menu->price }}" name="price" class="form-control bg-white  @error('price') is-invalid @enderror"  aria-label="Username" aria-describedby="basic-addon1">

        </div>
        @error('price')
        <div class="alert alert-danger">{{ $message }}</div>
    @enderror

        <label for="inputGroupFile02">image</label>
  <div class="input-group my-3">
      <input type="file" value="{{ old('img') }}" name="img" class="form-control bg-white" id="inputGroupFile01">
      <label class="input-group-text" for="inputGroupFile01">Upload</label>

    </div>
    @error('img')
      <div class="alert alert-danger">{{ $message }}</div>
  @enderror
    <div class="form-group">
      <label for="exampleInput">Description</label>
      <input name="description" type="text" value="{{$menu->description }}" class="form-control bg-white my-3  @error('description') is-invalid @enderror" id="exampleInput" placeholder="Description..">
            @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
    </div>
    <label for="">Category</label>
  <div  class="form-group my-3">
    <select name="category"  class="form-select bg-white" aria-label="Default select example">
      <option selected>Open this select menu</option>
      @foreach ($categories as $category)
      <option  value="{{ $category->id }}" {{$menu->category_id == $category->id ? "selected" : "" }}>{{ $category->name }}</option>
      @endforeach
    </select>
    @error('category')
    <div class="alert alert-danger">{{ $message }}</div>
  @enderror
  </div>

    <button type="submit" class="btn btn-warning">Edit</button>
  </form>
@endsection
