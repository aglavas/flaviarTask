@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Import products') }}</div>
                <div class="card-body">
                    <form method="POST" action="{{ route('post.product') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="file" class="col-sm-4 col-form-label text-md-right">{{ __('Choose excel file') }}</label>

                            <div class="col-md-6">
                                <input id="file" accept=".xls" type="file" class=".form-control-file" name="file" required autofocus>
                                @if (Session::has('success'))
                                    <div class="alert alert-success alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {!! Session::get('success') !!}
                                    </div>
                                @endif
                                @if (Session::has('error'))
                                    <div class="alert alert-danger alert-dismissable">
                                        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                        {!! Session::get('error') !!}
                                    </div>
                                @endif
                                @if ($errors->has('file'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('file') }}</strong>
                                    </span>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <div class="col-md-8 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Submit') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<br>

@if (count($products))
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
                <tr>
                    <td scope="col">Id</td>
                    <td scope="col">Product Id</td>
                    <td scope="col">Name</td>
                    <td scope="col">Volume</td>
                    <td scope="col">Abv</td>
                    <td scope="col">Actions</td>
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->volume }}</td>
                    <td>{{ $product->abv }}</td>
                    <td>
                        <a href="#" class="editButton btn btn-primary" role="button">Edit</a>
                        <a href="{{ route('get.product.vendors', $product)}}" class="btn btn-primary" role="button">Assign to vendor</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
    <div id="modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit product</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body mx-3">
                    <div class="md-form mb-4">
                        <i class="fa fa-envelope prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="modal-name">Name</label>
                        <input type="text" id="modal-name" class="form-control validate">
                    </div>
                    <div class="md-form mb-4">
                        <i class="fa fa-lock prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="modal-volume">Volume</label>
                        <input type="text" id="modal-volume" class="form-control validate">
                    </div>
                    <div class="md-form mb-4">
                        <i class="fa fa-lock prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="modal-abv">Abv</label>
                        <input type="text" id="modal-abv" class="form-control validate">
                    </div>
                </div>
                <div id="info">
                </div>
                <div class="modal-footer">
                    <button id="saveEdit" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="/js/product/import.js"></script>
@endif
@endsection
