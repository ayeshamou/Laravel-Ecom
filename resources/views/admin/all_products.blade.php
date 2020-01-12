@extends('admin_panel')
@section('content')
<table class="table mt-4">
    <thead class="table-dark">
        <tr>
            <th>
               Name
            </th>
            <th>
               Painter Name
            </th>
            <th>
               Price
            </th>
            <th>
                Description
            </th>
            <th>
               Image
            </th>
            <th>
                Actions
            </th>
        </tr>
    </thead>
    <tbody>
        @foreach($all_products as $product)
        <tr>
            <td>{{ $product -> product_name }}</td>
            <td>{{ $product -> painter_name }}</td>
            <td>{{ $product -> product_price }}</td>
            <td>{{ $product -> product_description }}</td>
            
            <td><img src="{{ URL :: to($product -> product_image) }}" style="width : 80px; height : 80px;">
            </td>
            <td>
                <a class="btn btn-danger" href="{{URL :: to('/admin/delete-product/'.$product -> product_id)}}">
                    <i class="fas fa-trash-alt"></i>
                </a>
                <a href="{{URL :: to('/admin/edit-product/'.$product -> product_id)}}" class="btn btn-info">
                    <i class="fa fa-edit"></i>
                </a>
            </td>
            
        </tr>
        
        @endforeach
       
    </tbody>
</table>
        {{ $all_products->links('vendor.pagination.bootstrap-4') }}
@endsection