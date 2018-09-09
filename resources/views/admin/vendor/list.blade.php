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
                        <input type="text" id="modal-name" class="form-control validate">
                        <label data-error="wrong" data-success="right" for="modal-name">Name</label>
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
    <script>
        $('document').ready(function() {

            $(".editButton").on("click", function(){
                var rowArray = $(this).closest('tr').find('td').map(function() {
                    return $(this).text();
                });
                openEditModal(rowArray);
            });

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
    </script>
@endif
@endsection
