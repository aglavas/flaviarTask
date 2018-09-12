$('document').ready(function() {
    $(".editButton").on("click", function(){
        var id = $(this).closest('tr').find('th').map(function() {
            return $(this).text();
        });
        var rowArray = $(this).closest('tr').find('td').map(function() {
            return $(this).text();
        });
        openEditModal(rowArray, id);
    });

    function openEditModal(rowArray, id) {
        $('#modal-name').val(rowArray[1]);
        $('#modal-volume').val(rowArray[2]);
        $('#modal-abv').val(rowArray[3]);
        $('#modal').modal('show');


        $( "#saveEdit" ).bind( "click", function() {
            $.ajax({
                url: '/admin/products/' + id[0] ,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: {
                    'name': $('#modal-name').val(),
                    'volume': $('#modal-volume').val(),
                    'abv': $('#modal-abv').val()
                },
                success: function(data) {
                    var div = '<div class="alert alert-success alert-dismissable">'
                        + '<h1>' + 'Success' + '</h1>' + '<p>' + data.message + '</p>' + '</div>';
                    $('#info')
                        .append(div);

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
});
