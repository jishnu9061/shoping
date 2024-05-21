<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/cropperjs@1.5.12/dist/cropper.min.js"></script>
</head>

<body>
    <form action="{{ route('store') }}" method="post" enctype="multipart/form-data">
        @csrf
        <h1>Add Product</h1>
        <div class="form-group">
            <label for="code">Code</label>
            <input type="text" class="form-control" id="code" name="code" placeholder="Enter Code" value="{{ old('code') }}">
        </div>
        @error('code')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" name="title" id="title" placeholder="Title" value="{{ old('title') }}">
        </div>
        @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="category_id">Parent Category</label>
            <select class="form-control" name="category_id" id="category_id" value="{{ old('category_id') }}">
                <option value="">Select Parent Category</option>
                @foreach ($categories as $id => $name)
                    <option value="{{ $id }}">{{ $name }}</option>
                @endforeach
            </select>
        </div>
        @error('category_id')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" name="description" id="description" rows="10" placeholder="Description">{{ old('description') }}</textarea>
        </div>
        @error('description')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" class="form-control" name="image" id="image" onchange="previewImage(event)">
            <img id="image-preview" src="#" alt="Preview" style="display: none; max-width: 150px; max-height: 150px;">
            @error('image')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <div>
                <img id="crop-image" src="#" alt="Image to crop" style="display: none; max-width: 100%;">
            </div>
            <button type="button" id="crop-button" class="btn btn-secondary" style="display: none;">Crop Image</button>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="text" class="form-control" name="price" id="price" placeholder="Price" value="{{ old('price') }}">
        </div>
        @error('price')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <br>
        <button type="submit" class="btn btn-primary">Save</button>
    </form>

    <script>
        CKEDITOR.replace('description');

        let cropper;
        let croppedCanvas;

        function previewImage(event) {
            var input = event.target;
            var reader = new FileReader();
            reader.onload = function() {
                var imgElement = document.getElementById('crop-image');
                imgElement.src = reader.result;
                imgElement.style.display = 'block';

                cropper = new Cropper(imgElement, {
                    aspectRatio: 1,
                    viewMode: 1,
                });

                document.getElementById('crop-button').style.display = 'inline-block';
            };
            reader.readAsDataURL(input.files[0]);
        }

        document.getElementById('crop-button').addEventListener('click', function() {
            croppedCanvas = cropper.getCroppedCanvas({
                width: 150,
                height: 150,
            });

            document.getElementById('image-preview').src = croppedCanvas.toDataURL();
            document.getElementById('image-preview').style.display = 'block';

            croppedCanvas.toBlob(function(blob) {
                let fileInput = document.getElementById('image');
                let file = new File([blob], fileInput.files[0].name, {
                    type: 'image/jpeg',
                    lastModified: Date.now()
                });
                let container = new DataTransfer();
                container.items.add(file);
                fileInput.files = container.files;
            });

            cropper.destroy();
            document.getElementById('crop-image').style.display = 'none';
            document.getElementById('crop-button').style.display = 'none';
        });
    </script>
</body>

</html>
