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
            <div class="container-fluid mb-4">
                <form action="{{ route('user.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('patch')
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <button class="btn btn-primary">Update User <i class="bi bi-check"></i></button>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="name">Name <span class="text-danger">*</span></label>
                                                <input class="form-control" type="text" name="name" required
                                                    value="{{  Auth::user()->name }}">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="email">Email <span class="text-danger">*</span></label>
                                                <input class="form-control" type="email" name="email" required
                                                    value="{{  Auth::user()->email }}">
                                            </div>
                                        </div>
                                    </div>
                                    <small>( Note: Leave Password and Confirmation field empty if you dont want to change
                                        it. )</small>
                                    <div class="form-row">
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label>Password</label>
                                                <div class="input-group mb-3" id="show_hide_password">
                                                    <input type="password" class="form-control" placeholder="Password"
                                                        aria-label="password" name="password"
                                                        aria-describedby="button-addon2">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-addon2"><i class="fa fa-eye-slash"
                                                                aria-hidden="true"></i></button>
                                                    </div>

                                                </div>
                                                @error('password')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password <span
                                                        class="text-danger">*</span></label>
                                                <div class="input-group" id="show_hide_confirm_password">
                                                    <input class="form-control" name="password_confirmation"
                                                        type="password">
                                                    <div class="input-group-append">
                                                        <button class="btn btn-outline-secondary" type="button"
                                                            id="button-addon2"><i class="fa fa-eye-slash"
                                                                aria-hidden="true"></i></button>
                                                    </div>
                                                </div>
                                                @error('password_confirmation')
                                                    <p style="color: red">{{ $message }}</p>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="form-group">
                                            <label class="form-label12">Status</label>
                                            <br>
                                            <input type="checkbox" name="status" checked data-bootstrap-switch
                                                data-off-color="danger" data-on-color="success">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="image">Profile Image <span class="text-danger">*</span></label>
                                        <img style="width: 100px;height: 100px;"
                                            class="d-block mx-auto img-thumbnail img-fluid rounded-circle mb-2"
                                            src="{{ asset('upload/images/users/' .  Auth::user()->image) }}" alt="Profile Image">
                                        <label for="image">Image </label>

                                        <input type="file" id="file-ip-1" accept="image/*"
                                            class="form-control-file border" value="{{ old('image') }}"
                                            onchange="showPreview1(event);" name="image">
                                        @error('image')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                        <div class="preview mt-2">
                                            <img src="" id="file-ip-1-preview" width="200px">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $("#show_hide_password button").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_password input').attr("type") == "text") {
                    $('#show_hide_password input').attr('type', 'password');
                    $('#show_hide_password i').addClass("fa-eye-slash");
                    $('#show_hide_password i').removeClass("fa-eye");
                } else if ($('#show_hide_password input').attr("type") == "password") {
                    $('#show_hide_password input').attr('type', 'text');
                    $('#show_hide_password i').removeClass("fa-eye-slash");
                    $('#show_hide_password i').addClass("fa-eye");
                }
            });
            $("#show_hide_confirm_password button").on('click', function(event) {
                event.preventDefault();
                if ($('#show_hide_confirm_password input').attr("type") == "text") {
                    $('#show_hide_confirm_password input').attr('type', 'password');
                    $('#show_hide_confirm_password i').addClass("fa-eye-slash");
                    $('#show_hide_confirm_password i').removeClass("fa-eye");
                } else if ($('#show_hide_confirm_password input').attr("type") == "password") {
                    $('#show_hide_confirm_password input').attr('type', 'text');
                    $('#show_hide_confirm_password i').removeClass("fa-eye-slash");
                    $('#show_hide_confirm_password i').addClass("fa-eye");
                }
            });

        });
    </script>
    <!-- image preview -->
    <script type="text/javascript">
        function showPreview1(event) {
            if (event.target.files.length > 0) {
                var src = URL.createObjectURL(event.target.files[0]);
                var preview = document.getElementById("file-ip-1-preview");
                preview.src = src;
                preview.style.display = "block";
            }
        }
    </script>
@endsection
