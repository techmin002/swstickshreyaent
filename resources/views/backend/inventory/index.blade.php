@extends('backend.layout.master')
@section('title', 'Inventory')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Inventory</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Inventory</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Inventory</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                {{-- <h3 class="card-title float-right">
                                    <a href="{{ route('checkin.create') }}" class="btn btn-info text-white">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3> --}}
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Opening Stock</th>
                                            <th class="text-center">Closing Stock</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($data as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->product->name ?? '-' }}</td>
                                                <td class="text-center">{{ $item->opening_stock }}</td>
                                                <td class="text-center">{{ $item->closing_stock }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 'on')
                                                        <p class="btn btn-success btn-sm">On</p>
                                                    @else
                                                        <p class="btn btn-danger btn-sm">Off</p>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Date</th>
                                            <th class="text-center">Status</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <script>
        $(function() {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@section('scripts')
    <script>
        @if (session('success'))
            alert(@json(session('success')));
        @endif
    </script>
@endsection
@endsection
