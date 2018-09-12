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
        $('document').ready(function() {

            var dropDownState = [];
            var activeIds = [];
            var currentVendorId = null;

            var products = {};

            @foreach($products as $product)
                products[{{$product->id}}] = '{{$product->name}}';
            @endforeach

            $("#productInfoSave").on("click", function(){
                var selectedProductIds = $("#productsDropdown").val();
                var costs = {};
                var stocks = {};

                var values = $("#modalDynamicContent :input");

                for (var i = 0; i < values.length; i++) {

                    if(/productCost-/.test(values[i].attributes.name.value))
                    {
                        var id = values[i].attributes.name.value.replace(/productCost-/,'');
                        var elementId = values[i].attributes.id.value;
                        costs[id] = $("#" + elementId).val();
                    }

                    if(/productStock-/.test(values[i].attributes.name.value))
                    {
                        var id = values[i].attributes.name.value.replace(/productStock-/,'');
                        var elementId = values[i].attributes.id.value;
                        stocks[id] = $("#" + elementId).val();
                    }
                }

                updateVendorProductsInfo(costs, stocks);
            });

            $(".editButton").on("click", function(){
                var rowArray = $(this).closest('tr').find('td').map(function() {
                    return $(this).text();
                });
                openEditModal(rowArray);
            });

            $(".editProductsInfoButton").on("click", function(){
                var rowArray = $(this).closest('tr').find('td').map(function() {
                    return $(this).text();
                });

                currentVendorId = rowArray[0];

                openEditProductsModal(rowArray);
            });

            $('#productsDropdown').click(function () {
                var productIds = $(this).val();
                editProductsModalFactoryWrapper(productIds);
            });


            function openEditProductsModal(rowArray)
            {
                    $.ajax({
                        url: '/admin/vendors/' + rowArray[0] + '/products' ,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(data) {
                            var dynamicContent = $('#modalDynamicContent');
                            dynamicContent.html('');
                            var content = '';
                            var productIds = [];

                            for (var i = 0; i < data.data.products.length; i++) {
                                dropDownState[data.data.products[i].id] = {
                                    price: data.data.products[i].price,
                                    stock: data.data.products[i].stock
                                };
                                productIds.push(data.data.products[i].id);
                                activeIds.push(data.data.products[i].id.toString());
                                content = content + editProductsModalFactory(data.data.products[i].id, data.data.products[i].price, data.data.products[i].stock);
                            }
                            dynamicContent.append(content);

                            $("#productsDropdown").val(productIds);

                            $('#productInfoModal').modal('show');
                        },
                        error: function(data) {
                            $('#editProductInfo').html('');
                            $.each(data.responseJSON.errors, function(key,value) {
                                $('#editProductInfo').append('<div class="alert alert-danger">'+value+'</div>');
                            });
                        },
                        type: 'get'
                    });
            }


            function updateVendorProductsInfo(cost, stock) {
                $.ajax({
                    url: '/admin/vendors/' + currentVendorId + '/products' ,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        'price': cost,
                        'stock': stock,
                        'productIds': activeIds.sort(function(a, b){return a - b})
                    },
                    success: function(data) {
                        var info = $('#editProductInfo').html('');
                        var div = '<div class="alert alert-success alert-dismissable">'
                            + '<h1>' + 'Success' + '</h1>' + '<p>' + data.message + '</p>' + '</div>';

                        info.append(div);
                        setTimeout(location.reload.bind(location), 600);
                    },
                    error: function(data) {
                        $('#editProductInfo').html('');
                        $.each(data.responseJSON.errors, function(key,value) {
                            $('#editProductInfo').append('<div class="alert alert-danger">'+value+'</div>');
                        });
                    },
                    type: 'PATCH'
                });
            }


            function openEditModal(rowArray) {
                $('#modal-name').val(rowArray[1]);
                $('#modal').modal('show');

                $( "#saveEdit" ).bind( "click", function() {
                    $.ajax({
                        url: '/admin/vendors/' + rowArray[0] ,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        data: {
                            'name': $('#modal-name').val()
                        },
                        success: function(data) {
                            var info = $('#info').html('');
                            var div = '<div class="alert alert-success alert-dismissable">'
                                + '<h1>' + 'Success' + '</h1>' + '<p>' + data.message + '</p>' + '</div>';

                            info.append(div);
                            setTimeout(location.reload.bind(location), 600);
                        },
                        error: function(data) {
                            $('#info').html('');
                            $.each(data.responseJSON.errors, function(key,value) {
                                $('#info').append('<div class="alert alert-danger">'+value+'</div>');
                            });
                        },
                        type: 'PATCH'
                    });
                });
            }

            function editProductsModalFactoryWrapper(productIds)
            {
                var dynamicContent = $('#modalDynamicContent');
                var content = '';

                if(productIds.length == 0)
                {
                    $('#modalDynamicContent').empty();
                }
                else if(productIds.length == 1)
                {
                    $('#modalDynamicContent').empty();
                    activeIds.length = 0;
                    activeIds.push(productIds[0]);
                    content = content + editProductsModalFactory(productIds[0]);
                }
                else
                {
                    if(productIds.length > activeIds.length)
                    {
                        var diff = productIds.filter(function(a) {
                            return !activeIds.includes(a);
                        });

                        for (var i = 0; i < diff.length; i++) {
                            activeIds.push(diff[i]);
                            content = content + editProductsModalFactory(diff[i]);
                        }

                    }else if(productIds.length < activeIds.length) {

                        var diff = activeIds.filter(function(a) {
                            return !productIds.includes(a);
                        });

                        for (var i = 0; i < diff.length; i++) {
                            var toRemove = diff[i];
                            $('#productInfo-' + toRemove).remove();
                            activeIds = activeIds.filter(function(e) { return e !== toRemove })
                        }
                    }
                }
                dynamicContent.append(content);
            }


            function editProductsModalFactory(productId, price, stock)
            {
                price = typeof price !== 'undefined' ? price : 0;
                stock = typeof stock !== 'undefined' ? stock : 0;
                var template = '';

                if(dropDownState[productId] !== undefined)
                {
                    price = dropDownState[productId].price;
                    stock = dropDownState[productId].stock;
                }

                template = template + '<div id="productInfo-'+productId+'">'+ products[productId] +'<div class="modal-body mx-3">\n' +
                    '                        <i class="fa fa-envelope prefix grey-text"></i>\n' +
                    '                        <label data-error="wrong" data-success="right" for="modal-name">Price</label>\n' +
                    '                        <input type="text" name="productCost-'+ productId +'" id="productCost-' + productId + '" class="form-control validate" value="'+ price +'">\n' +
                    '                </div>';

                template = template + '<div class="modal-body mx-3">\n' +
                    '                        <i class="fa fa-envelope prefix grey-text"></i>\n' +
                    '                        <label data-error="wrong" data-success="right" for="modal-name">Stock</label>\n' +
                    '                        <input type="text" name="productStock-'+ productId +'" id="productStock-'+ productId + '" value="'+ stock +'" class="form-control validate">\n' +
                    '                </div></div>';

                return template;
            }
        });
    </script>
@endif
@endsection
