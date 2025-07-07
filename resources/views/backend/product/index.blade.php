@extends('backend.layout.master')
@section('title', 'Product')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Product</li>
    </ol>
@endsection
@section('content')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Product</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Product</li>
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
                        <!-- Card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title float-right">
                                    <a class="btn btn-info text-white" data-toggle="modal"
                                        data-target="#exampleModalCenter">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                                {{-- model --}}
                                <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-m" role="document">
                                        <div class="modal-content" style="border-radius: 8px;">
                                            <div class="modal-header justify-content-center"
                                                style="background-color: #0837a4; color: #fff;">
                                                <h1 class="modal-title fs-5" id="staticBackdropLabel">Add Product</h1>
                                            </div>
                                            <form action="{{ route('product.store') }}" method="post"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="container">
                                                        <div class="row gy-3">
                                                            <div class="mt-3 col-lg-12">
                                                                <label class="form-label12">Name</label>
                                                                <input class="form-control" placeholder="Enter Name"
                                                                    type="text" name="name">
                                                            </div>
                                                        </div>
                                                        <div class="mt-3 col-md-12">
                                                            <label class="form-label12">Publish</label>
                                                            <br>
                                                            <input type="checkbox" name="status" checked
                                                                data-bootstrap-switch data-off-color="danger"
                                                                data-on-color="success">
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer justify-content-start">
                                                    <button type="submit" name="submit" id="btnSubmit"
                                                        class="btn btn-success">Save Item</button>
                                                    <button type="button" data-dismiss="modal"
                                                        class="btn btn-danger">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Created_at</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $value)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $value->name }}</td>
                                                <td class="text-center">{{ $value->created_at }}</td>
                                                <td class="text-center">
                                                    @if ($value->status == 'on')
                                                        <a href="{{ route('product.status', $value->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('product.status', $value->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a data-toggle="modal" data-target="#editProduct{{ $value->id }}"
                                                        class="btn btn-primary btn-sm" data-toggle="tooltip" title="Edit">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                    {{-- Edit Model --}}
                                                    <div class="modal fade" id="editProduct{{ $value->id }}"
                                                        tabindex="-1" role="dialog"
                                                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-m" role="document">
                                                            <div class="modal-content" style="border-radius: 8px;">
                                                                <div class="modal-header justify-content-center"
                                                                    style="background-color: #0837a4; color: #fff;">
                                                                    <h1 class="modal-title fs-5" id="staticBackdropLabel">
                                                                        Edit Product</h1>
                                                                </div>

                                                                <form action="{{ route('product.update', $value->id) }}"
                                                                    method="post" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="container">
                                                                            <div class="row gy-3">
                                                                                <!-- Name Field -->
                                                                                <div class="mt-3 col-lg-12">
                                                                                    <label
                                                                                        class="form-label12">Name</label>
                                                                                    <input class="form-control"
                                                                                        placeholder="Enter Name"
                                                                                        type="text" name="name"
                                                                                        value="{{ $value->name }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>

                                                                            <!-- Publish -->
                                                                            <div class="mt-3 col-md-12">
                                                                                <label class="form-label12">Publish</label>
                                                                                <br>
                                                                                <input type="checkbox" name="status"
                                                                                    {{ $value->status == 'on' ? 'checked' : '' }}
                                                                                    data-bootstrap-switch
                                                                                    data-off-color="danger"
                                                                                    data-on-color="success">
                                                                            </div>
                                                                        </div>
                                                                    </div>

                                                                    <div class="modal-footer justify-content-start">
                                                                        <button type="submit" name="submit"
                                                                            id="btnSubmit" class="btn btn-success">Update
                                                                            Item</button>
                                                                        <button type="button" data-dismiss="modal"
                                                                            class="btn btn-danger">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- @include('product.edit') --}}
                                                    <button id="delete" class="btn btn-danger btn-sm"
                                                        data-toggle="tooltip" title="Delete"
                                                        onclick="event.preventDefault();
                                                            if (confirm('Are you sure? It will delete the data permanently!')) {
                                                                document.getElementById('destroy{{ $value->id }}').submit();
                                                            }">
                                                        <i class="fa fa-trash"></i>
                                                        <form id="destroy{{ $value->id }}" class="d-none"
                                                            action="{{ route('product.destroy', $value->id) }}"
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
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Created_at</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
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
