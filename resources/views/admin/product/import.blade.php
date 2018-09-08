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
                </tr>
            </thead>
            <tbody>
            @foreach($products as $product)
                <tr class='clickable-row' data-href='/admin/products/{{$product->product_id}}'>
                    <th scope="row">{{ $product->id }}</th>
                    <td>{{ $product->product_id }}</td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->volume }}</td>
                    <td>{{ $product->abv }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
@endsection
