$('document').ready(function() {

    var dropDownState = [];
    var activeIds = [];
    var currentVendorId = null;

    $("#productInfoSave").on("click", function(){
        var selectedProductIds = $("#productsDropdown").val();
        var costs = {};
        var stocks = {};

        var values = $("#modalDynamicContent :input");

        for (var i = 0; i < values.length; i++) {

            var id = '';
            var elementId = '';

            if(/productCost-/.test(values[i].attributes.name.value))
            {
                id = values[i].attributes.name.value.replace(/productCost-/,'');
                elementId = values[i].attributes.id.value;
                costs[id] = $("#" + elementId).val();
            }

            if(/productStock-/.test(values[i].attributes.name.value))
            {
                id = values[i].attributes.name.value.replace(/productStock-/,'');
                elementId = values[i].attributes.id.value;
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

        if(productIds.length === 0)
        {
            $('#modalDynamicContent').empty();
        }
        else if(productIds.length === 1)
        {
            $('#modalDynamicContent').empty();
            activeIds.length = 0;
            activeIds.push(productIds[0]);
            content = content + editProductsModalFactory(productIds[0]);
        }
        else
        {
            var diff = '';

            if(productIds.length > activeIds.length)
            {
                diff = productIds.filter(function(a) {
                    return !activeIds.includes(a);
                });

                for (var i = 0; i < diff.length; i++) {
                    activeIds.push(diff[i]);
                    content = content + editProductsModalFactory(diff[i]);
                }

            }else if(productIds.length < activeIds.length) {

                diff = activeIds.filter(function(a) {
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
