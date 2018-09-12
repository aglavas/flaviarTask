@extends('layouts.app')

@section('content')
    <div class="container">
        @if (count($productDetails))
            @foreach($productDetails as $product)
                <a class="btn btn-primary" data-toggle="collapse" href="#collapseTable{{$product->id}}" role="button" aria-expanded="false" aria-controls="collapseExample">
                    {{$product->name}}
                </a>
                <br>
                <br>
                @if (count($product->vendors))
                    <div class="table-container collapse" id="collapseTable{{$product->id}}">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td scope="col">Vendor name</td>
                                <td scope="col">Vendor stock</td>
                                <td scope="col">Vendor price</td>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($product->vendors as $vendorDetails)
                                <tr>
                                    <td>{{ $vendorDetails->name }}</td>
                                    <td>{{ $vendorDetails->pivot->stock }}</td>
                                    <td>{{ $vendorDetails->price }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        @if(isset($product->min))
                            <b>Min price is</b> {{$product->min}}
                        @endif
                        @if(isset($product->max))
                            <b>Max price is</b> {{$product->max}}
                        @endif
                        @if(isset($product->avg))
                            <b>Average price is</b> {{$product->avg}}
                        @endif

                    </div>
                @else
                    <div class="table-container collapse" id="collapseTable{{$product->id}}">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <td scope="col">Vendor name</td>
                                <td scope="col">Vendor stock</td>
                                <td scope="col">Vendor price</td>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>-</td>
                                <td>-</td>
                                <td>-</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection
