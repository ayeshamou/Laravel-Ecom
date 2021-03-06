@extends('admin_panel')
@section('content')
<br>
<div class="row justify-content-center">
    <div class="col-md-10">
        <div class="card">
            <div class="card-header">
                <h2 align="center">Product Information</h2>
            </div>
            <div class="card-body">
                <form action="{{url('/admin/update-product/'.$product_info -> product_id) }}" method="POST" enctype = "multipart/form-data">
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="product_name" class="col-md-4 col-form-label text-md-right">Product Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="product_name" value = "{{ $product_info -> product_name }}" required>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="last_name" class="col-md-4 col-form-label text-md-right">Painter Name</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="painter_name" value = "{{ $product_info -> painter_name }}" required>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_price" class="col-md-4 col-form-label text-md-right">Price
                        </label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="product_price" value = "{{ $product_info -> product_price }}" required>
                        </div>
                    </div>
                    

                    <div class="form-group row">
                        <label for="category_name" class="col-md-4 col-form-label text-md-right">Category Name</label>
                        <div class="col-md-8">
                            <select class="form-control" name="category_id">
                            <option value="{{ $product_info -> category_id }}">{{ $product_info -> category_name }}</option>
                                @foreach($categories as $category)
                                <option value="{{ $category -> category_id}}">{{ $category -> category_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="product_description" class="col-md-4 col-form-label text-md-right">
                            Product Description</label>
                        <div class="col-md-8">
                            <textarea class="form-control" rows="3" name="product_description" required>{{ $product_info -> product_description }}</textarea>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="product_image" class="col-md-4 col-form-label text-md-right">Product Image
                        </label>
                        <div class="col-md-8">
                        <input class="input-file uniform_on" name="product_image" id="fileInput" type="file">
                        </div>
                    </div>

                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-success">
                            Update Product
                        </button>
                    </div>
            </div>
            </form>
        </div>
    </div>
</div>
@endsection