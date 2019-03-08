@extends('layouts.app')

@section('content')
@if (count($vendors))
    <div class="container">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <td scope="col">Id</td>
                <td scope="col">Name</td>
                <td scope="col">Actions</td>
            </tr>
            </thead>
            <tbody>
            @foreach($vendors as $vendor)
                <tr class='clickable-row'>
                    <td scope="row">{{ $vendor->id }}</td>
                    <td>{{ $vendor->name }}</td>
                    <td>
                        <a href="#" class="editButton btn btn-primary" role="button">Edit</a>
                        <a href="#" class="editProductsInfoButton btn btn-primary" role="button">Edit product information</a>
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
                    <h5 class="modal-title">Edit vendor</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <i class="fa fa-envelope prefix grey-text"></i>
                        <label data-error="wrong" data-success="right" for="modal-name">Name</label>
                        <input type="text" id="modal-name" class="form-control validate">
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
    {{--ProductInfo modal--}}
    <div id="productInfoModal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Product Informations</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <meta name="csrf-token" content="{{ csrf_token() }}">
                <div class="modal-body mx-3">
                    <div class="md-form mb-5">
                        <label data-error="wrong" data-success="right" for="productsDropdown">Products</label>
                        <select class="mdb-select" multiple id="productsDropdown">
                            @foreach($products as $product)
                                <option value="{{$product->id}}">{{$product->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div id="modalDynamicContent">
                </div>
                <div id="editProductInfo">
                </div>
                <div class="modal-footer">
                    <button id="productInfoSave" type="button" class="btn btn-primary">Save changes</button>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        var products = {};

        @foreach($products as $product)
            products[{{$product->id}}] = '{{$product->name}}';
        @endforeach
    </script>
@endif
@endsection
