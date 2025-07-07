@extends('backend.layout.master')
@section('title', 'Stock Check-in')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Check-in</li>
    </ol>
@endsection

@section('content')
    <div class="content-wrapper">

        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Check-in</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Check-in</li>
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
                                <h3 class="card-title float-right">
                                    <a href="{{ route('stockin.create') }}" class="btn btn-info text-white">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                            </div>

                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price(Per Stock)</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stockcheckins as $item)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $item->product->name ?? '-' }}</td>
                                                <td class="text-center">{{ $item->quantity }}</td>
                                                <td class="text-center">{{ $item->price }}</td>
                                                <td class="text-center">{{ $item->total }}</td>
                                                <td class="text-center">
                                                    @if ($item->status == 'on')
                                                        <a href="{{ route('stockin.status', $item->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('stockin.status', $item->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a href="#" data-toggle="modal"
                                                        data-target="#editStockModal{{ $item->id }}"
                                                        class="btn btn-primary btn-sm"><i class="fa fa-edit"></i></a>
                                                    <div class="modal fade" id="editStockModal{{ $item->id }}"
                                                        tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div
                                                                    class="modal-header bg-primary text-white justify-content-center">
                                                                    <h5 class="modal-title">Edit Stock Check-in</h5>
                                                                </div>
                                                                <form action="{{ route('stockin.update', $item->id) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <label>Product</label>
                                                                                <select name="product_id"
                                                                                    class="form-control" required>
                                                                                    <option value="">-- Select Product
                                                                                        --</option>
                                                                                    @foreach ($products as $product)
                                                                                        <option value="{{ $product->id }}"
                                                                                            {{ $item->product_id == $product->id ? 'selected' : '' }}>
                                                                                            {{ $product->name }}
                                                                                        </option>
                                                                                    @endforeach
                                                                                </select>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <label>Quantity</label>
                                                                                <input type="number" name="quantity"
                                                                                    class="form-control"
                                                                                    value="{{ $item->quantity }}" required>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Price</label>
                                                                                    <input type="number" name="price"
                                                                                        class="form-control"
                                                                                        value="{{ $item->price }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12 mt-2">
                                                                                <div class="form-group">
                                                                                    <label>Status</label><br>
                                                                                    <input type="checkbox" name="status"
                                                                                        {{ $item->status == 'on' ? 'checked' : '' }}
                                                                                        data-bootstrap-switch
                                                                                        data-off-color="danger"
                                                                                        data-on-color="success">
                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="submit"
                                                                            class="btn btn-success">Update</button>
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="event.preventDefault();
                                                            if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                document.getElementById('destroy{{ $item->id }}').submit();
                                                            }">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $item->id }}" class="d-none"
                                                            action="{{ route('stockin.destroy', $item->id) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                        </form>
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Product</th>
                                            <th class="text-center">Quantity</th>
                                            <th class="text-center">Price(Per Stock)</th>
                                            <th class="text-center">Total</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
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
