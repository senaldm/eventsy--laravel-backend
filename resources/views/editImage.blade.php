<!DOCTYPE html>
<html>

<head>
    <title>Edit Image</title>
</head>

<body>
    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif

        <h2>Edit Image</h2>

        <!-- You can add an image editing form here, e.g., for resizing, cropping, filtering, etc. -->
        <!-- You should also provide a way to submit the edited image. -->

        <!-- <a href="{{ route('upload.form') }}">Back to Upload</a> -->
    </div>
</body>

</html>