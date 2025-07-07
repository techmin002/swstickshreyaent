@extends('backend.layout.master')
@section('title', 'Stock Out')
@section('breadcrumb')
    <ol class="breadcrumb border-0 m-0">
        <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
        <li class="breadcrumb-item active">Stock Out</li>
    </ol>
@endsection
@section('content')
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Stock Out</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                            <li class="breadcrumb-item active">Stock Out</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <div class="container-fluid mb-4">
                <form action="{{ route('stockout.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-primary text-white">
                                    <h5 class="mb-0">Stock Out</h5>
                                </div>
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label><strong>Select Customer</strong></label>
                                                <select name="customer_id" class="form-control" required>
                                                    <option value="">-- Select Customer --</option>
                                                    @foreach ($customers as $customer)
                                                        <option value="{{ $customer->id }}">
                                                            {{ $customer->name }} ({{ $customer->phone }})
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div id="productContainer"></div>
                                    <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="addProductRow">
                                        <i class="fa fa-plus"></i> Add Product
                                    </button>

                                    <div class="form-group mt-3">
                                        <label><strong>Total</strong></label>
                                        <input type="text" name="total" id="grandTotal" class="form-control" readonly
                                            value="0.00">
                                    </div>
                                </div>

                                <div class="card-footer text-left">
                                    <button type="submit" class="btn btn-success">Save</button>
                                    <a href="{{ route('stockout.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
    <script>
        const stockData = @json($stockCheckIns);
        let rowIndex = 0;

        function createRow(index) {
            let options = `<option value="">Select Product</option>`;
            stockData.forEach(stock => {
                options += `<option value="${stock.product_id}" data-price="${stock.price}">
                    ${stock.product_name}
                </option>`;
            });

            return `
                <div class="row mb-2 product-row">
                    <div class="col-md-3">
                        <select name="products[${index}][product_id]" class="form-control product-select" required>
                            ${options}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <input type="number" name="products[${index}][quantity]" class="form-control quantity-input" value="1" min="1" required>
                    </div>
                    <div class="col-md-2">
                        <input type="text" name="products[${index}][price]" class="form-control price-input" readonly>
                    </div>
                    <div class="col-md-2">
                        <input type="text" class="form-control total-input" readonly>
                    </div>
                    <div class="col-md-1 d-flex align-items-center">
                        <button type="button" class="btn btn-outline-danger btn-sm remove-row"><i class="fa fa-times"></i></button>
                    </div>
                </div>
            `;
        }

        function recalculateTotals() {
            let total = 0;
            document.querySelectorAll(".product-row").forEach(row => {
                const qty = parseFloat(row.querySelector(".quantity-input").value) || 0;
                const price = parseFloat(row.querySelector(".price-input").value) || 0;
                const rowTotal = qty * price;
                row.querySelector(".total-input").value = rowTotal.toFixed(2);
                total += rowTotal;
            });
            document.getElementById("grandTotal").value = total.toFixed(2);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const container = document.getElementById("productContainer");
            const addBtn = document.getElementById("addProductRow");

            container.innerHTML = createRow(rowIndex++);

            addBtn.addEventListener("click", function() {
                container.insertAdjacentHTML("beforeend", createRow(rowIndex++));
            });

            document.addEventListener("change", function(e) {
                if (e.target.classList.contains("product-select")) {
                    const selected = e.target.selectedOptions[0];
                    const price = selected.getAttribute("data-price") || 0;
                    const row = e.target.closest(".product-row");

                    row.querySelector(".price-input").value = parseFloat(price).toFixed(2);
                    recalculateTotals();
                }

                if (e.target.classList.contains("quantity-input")) {
                    recalculateTotals();
                }
            });

            document.addEventListener("input", function(e) {
                if (e.target.classList.contains("quantity-input")) {
                    recalculateTotals();
                }
            });

            document.addEventListener("click", function(e) {
                if (e.target.closest(".remove-row")) {
                    e.target.closest(".product-row").remove();
                    recalculateTotals();
                }
            });
        });
    </script>
@endsection
@section('scripts')
    <script>
        @if (session('success'))
            alert(@json(session('success')));
        @endif

        @if ($errors->has('error'))
            alert(@json($errors->first('error')));
        @endif
    </script>
@endsection
