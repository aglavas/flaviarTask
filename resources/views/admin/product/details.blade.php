@extends('layouts.app')

@section('content')
    <div class="container">
        <form method="POST" action="{{ route('post.product.vendors', $product) }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group row">
                <label for="vendor" class="col-sm-4 col-form-label text-md-right">{{ __('Vendor') }}</label>
                <div class="col-md-6">
                    <select name="vendor_id" id="vendor">
                        @foreach($vendors as $vendor )
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="form-group row">
                <label for="stock" class="col-sm-4 col-form-label text-md-right">{{ __('Stock qty') }}</label>
                <div class="col-md-6">
                    <input type="text" name="stock">
                </div>
            </div>
            <div class="form-group row">
                <label for="price" class="col-sm-4 col-form-label text-md-right">{{ __('Price') }}</label>
                <input type="text" name="price">
                {{--<input type="text" name="product_id" value="{{$product->id}}" hidden>--}}
            </div>
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @if (Session::has('success'))
                <div class="alert alert-success alert-dismissable">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                    {!! Session::get('success') !!}
                </div>
            @endif
            <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Submit') }}
                    </button>
                </div>
                <div class="col-md-8 offset-md-4">
                    <a href="/admin/products" class="btn btn-primary" role="button">Back</a>
                </div>
            </div>
        </form>
    </div>
@endsection
