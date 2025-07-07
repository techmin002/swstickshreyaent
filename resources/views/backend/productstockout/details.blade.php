{{-- @extends('backend.layout.master')
@section('title', 'Stock Out Details')

@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <h1>Stock Out Details</h1>
        </section>

        <section class="content">
            <div class="card">
                <div class="card-header">
                    <strong>Customer:</strong> {{ $stockOut->customer->name ?? 'N/A' }} <br>
                    <strong>Date:</strong> {{ $stockOut->created_at->format('d M Y') }}
                </div>

                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($stockOut->products as $product)
                                <tr>
                                    <td>{{ $product->product->name ?? 'N/A' }}</td>
                                    <td>{{ $product->quantity }}</td>
                                    <td>{{ number_format($product->price, 2) }}</td>
                                    <td>{{ number_format($product->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Grand Total</th>
                                <th>{{ number_format($stockOut->total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                <div class="card-footer">
                    <a href="{{ route('stockout.index') }}" class="btn btn-secondary">Back</a>
                </div>
            </div>
        </section>
    </div>
@endsection --}}

@extends('backend.layout.master')
@section('title', 'Stock Out Details')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Out Details</li>
    </ol>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Out Details</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Out Details</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid mb-4">
                <form action="{{ route('stockin.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h3 class="mb-0">Stock Out Details</h3>
                                    <br>
                                    <h5><strong>Customer:</strong> {{ $stockOut->customer->name ?? 'N/A' }}</h5>
                                    <h5><strong>Date:</strong> {{ $stockOut->created_at->format('d M Y') }}</h5>
                                </div>
                                <div class="card-body">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr class="text-center">
                                                <th>S.N</th>
                                                <th>Product</th>
                                                <th>Quantity</th>
                                                <th>Price</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody class="text-center">
                                            @foreach ($stockOut->products as $product)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>{{ $product->product->name ?? 'N/A' }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td>{{ number_format($product->price, 2) }}</td>
                                                    <td>{{ number_format($product->total, 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="text-center">
                                            <tr>
                                                <th colspan="3" class="text-end">Grand Total</th>
                                                <th>{{ number_format($stockOut->total, 2) }}</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                                <div class="card-footer">
                                    <a href="{{ route('stockout.index') }}" class="btn btn-secondary">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection
@section('scripts')
    <script>
        @if (session('success'))
            alert(@json(session('success')));
        @endif
    </script>
@endsection
