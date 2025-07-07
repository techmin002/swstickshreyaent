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
                                        data-target="#createCustomerModal">
                                        <i class="fa fa-plus"></i> Create
                                    </a>
                                </h3>
                                {{-- Create Modal --}}
                                <div class="modal fade" id="createCustomerModal" tabindex="-1" role="dialog">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary text-white justify-content-center">
                                                <h5 class="modal-title">Add Customer</h5>
                                            </div>
                                            <form action="{{ route('customer.store') }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Name</label>
                                                                <input type="text" name="name" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Phone</label>
                                                                <input type="text" name="phone" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Email</label>
                                                                <input type="email" name="email" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Address</label>
                                                                <input type="text" name="address" class="form-control"
                                                                    required>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Description</label>
                                                                <textarea name="description" class="form-control"></textarea>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label>Image</label>
                                                                <input type="file" name="image" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <label class="form-label12">Publish</label>
                                                            <br>
                                                            <input type="checkbox" name="status" checked
                                                                data-bootstrap-switch data-off-color="danger"
                                                                data-on-color="success">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-success">Save</button>
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">Cancel</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                {{-- End Create Modal --}}

                            </div>
                            <div class="card-body">
                                <table id="example1" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Image</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $customer)
                                            <tr>
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-center">{{ $customer->name }}</td>
                                                <td class="text-center">{{ $customer->phone }}</td>
                                                <td class="text-center">{{ $customer->email }}</td>
                                                <td class="text-center">{{ $customer->address }}</td>
                                                <td class="text-center">{{ $customer->description }}</td>
                                                <td class="text-center">
                                                    @if ($customer->image)
                                                        <img src="{{ asset('upload/images/customer/' . $customer->image) }}"
                                                            alt="Customer Image" class="img-thumbnail"
                                                            style="max-width: 70px;">
                                                    @else
                                                        N/A
                                                    @endif
                                                </td>
                                                <td class="text-center">
                                                    @if ($customer->status == 'on')
                                                        <a href="{{ route('customer.status', $customer->id) }}"
                                                            class="btn btn-success btn-sm">On</a>
                                                    @else
                                                        <a href="{{ route('customer.status', $customer->id) }}"
                                                            class="btn btn-danger btn-sm">Off</a>
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-primary btn-sm" data-toggle="modal"
                                                        data-target="#editCustomerModal{{ $customer->id }}">
                                                        <i class="fa fa-edit"></i>
                                                    </a>

                                                    <!-- Edit Modal -->
                                                    <div class="modal fade" id="editCustomerModal{{ $customer->id }}"
                                                        tabindex="-1" role="dialog">
                                                        <div class="modal-dialog modal-lg" role="document">
                                                            <div class="modal-content">
                                                                <div
                                                                    class="modal-header bg-primary text-white justify-content-center">
                                                                    <h5 class="modal-title">Edit Customer</h5>
                                                                </div>
                                                                <form
                                                                    action="{{ route('customer.update', $customer->id) }}"
                                                                    method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Name</label>
                                                                                    <input type="text" name="name"
                                                                                        class="form-control"
                                                                                        value="{{ $customer->name }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Phone</label>
                                                                                    <input type="text" name="phone"
                                                                                        class="form-control"
                                                                                        value="{{ $customer->phone }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Email</label>
                                                                                    <input type="email" name="email"
                                                                                        class="form-control"
                                                                                        value="{{ $customer->email }}">
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Address</label>
                                                                                    <input type="text" name="address"
                                                                                        class="form-control"
                                                                                        value="{{ $customer->address }}"
                                                                                        required>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Description</label>
                                                                                    <textarea name="description" class="form-control">{{ $customer->description }}</textarea>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-6">
                                                                                <div class="form-group">
                                                                                    <label>Image</label>
                                                                                    <input type="file" name="image"
                                                                                        class="form-control">

                                                                                    @if ($customer->image)
                                                                                        <img src="{{ asset('upload/images/customer/' . $customer->image) }}"
                                                                                            alt="Customer Image"
                                                                                            class="img-thumbnail mt-2"
                                                                                            style="max-width: 120px;">
                                                                                    @endif
                                                                                </div>
                                                                            </div>
                                                                            <!-- Publish -->
                                                                            <div class="mt-3 col-md-12">
                                                                                <label class="form-label12">Publish</label>
                                                                                <br>
                                                                                <input type="checkbox" name="status"
                                                                                    {{ $customer->status == 'on' ? 'checked' : '' }}
                                                                                    data-bootstrap-switch
                                                                                    data-off-color="danger"
                                                                                    data-on-color="success">
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer justify-content-start">
                                                                        <button type="submit"
                                                                            class="btn btn-success">Update</button>
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Cancel</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!-- End Edit Modal -->


                                                    <form id="deleteForm{{ $customer->id }}" method="POST"
                                                        action="{{ route('customer.destroy', $customer->id) }}"
                                                        style="display: inline-block">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure? It will delete the data permanently!')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">S.N</th>
                                            <th class="text-center">Name</th>
                                            <th class="text-center">Phone</th>
                                            <th class="text-center">Email</th>
                                            <th class="text-center">Address</th>
                                            <th class="text-center">Description</th>
                                            <th class="text-center">Image</th>
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
