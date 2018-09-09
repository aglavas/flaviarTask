@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <ul class="navbar-nav mr-auto">
                        <li class="nav-item active">
                            Click on Products to import and view products
                        </li>
                        <li class="nav-item">
                            Click on Vendors to view and edit vendors
                        </li>
                        <li class="nav-item">
                            Click on Details to view and product additional details
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
