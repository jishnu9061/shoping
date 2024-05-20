<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Listing</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <style>
        .cart {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1000;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
            padding: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .cart i {
            color: #333;
        }

        .cart-counter {
            background-color: #007bff;
            color: #fff;
            border-radius: 50%;
            padding: 4px 8px;
            font-size: 12px;
        }
    </style>

</head>

<body>
    <div class="container mt-5">
        <div class="form-group">
            <label for="categoryId">Select Category:</label>
            <select class="form-control" name="category_id" id="categoryId">
                <option value="">All Categories</option>
                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        <div class="row">
            <div class="col-md-12 product-listing">
                @include('partials.product-list', ['products' => $products])
            </div>
        </div>

        <div class="cart">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-counter">0</span>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function filterProducts(categoryId) {
                $.ajax({
                    url: '{{ route('filter-products') }}',
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        category_id: categoryId
                    },
                    success: function(response) {
                        if (response.success) {
                            $('.product-listing').html(response.data);
                        } else {
                            alert('Failed to load products.');
                        }
                    },
                    error: function() {
                        alert('Failed to load products.');
                    }
                });
            }

            filterProducts('');

            $('#categoryId').change(function() {
                var categoryId = $(this).val();
                filterProducts(categoryId);
            });

            $('.product-listing').on('click', '.add-to-cart', function() {
                var currentCount = parseInt($('.cart-counter').text());
                $('.cart-counter').text(currentCount + 1);
            });
        });
    </script>
</body>

</html>
