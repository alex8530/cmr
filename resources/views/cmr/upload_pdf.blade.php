<!DOCTYPE html>
<html>
<head>
    <title>Upload PDF</title>
    <!-- Include Bootstrap CSS -->
    <link href="{{asset('frontend/css/bootstrap.v4.5.2.min.css')}}" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            background-color: #f1f1f1;
            font-family: 'Arial', sans-serif;
        }
        .container {
            max-width: 600px;
            padding: 2rem;
            background-color: #ffffff;
            box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.2);
            border-radius: 0.5rem;
            margin-top: 3rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }
        .container:hover {
            transform: scale(1.02);
            box-shadow: 0 0.75rem 2rem rgba(0, 0, 0, 0.3);
        }
        .container h2 {
            margin-bottom: 1.5rem;
            font-weight: 700;
            color: #343a40;
            text-transform: uppercase;
            letter-spacing: 1px;
            text-align: center;
            position: relative;
        }
        .container h2::after {
            content: '';
            width: 100px;
            height: 3px;
            background-color: #007bff;
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
        }
        .form-group {
            margin-bottom: 1.5rem;
        }
        .form-group label {
            font-weight: 600;
            color: #495057;
        }
        .form-control-file {
            border: 1px solid #ced4da;
            padding: 0.5rem;
            border-radius: 0.25rem;
            background-color: #f8f9fa;
            transition: background-color 0.3s, border-color 0.3s;
        }
        .form-control-file:hover, .form-control-file:focus {
            background-color: #e9ecef;
            border-color: #adb5bd;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            transition: background-color 0.2s, border-color 0.2s, box-shadow 0.2s;
            font-weight: 600;
            padding: 0.75rem 1.25rem;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
            box-shadow: 0 0.25rem 0.5rem rgba(0, 0, 0, 0.2);
        }
        .btn-block {
            margin-top: 1rem;
        }
        .btn-primary:active {
            background-color: #004085;
            border-color: #003366;
            box-shadow: inset 0 0.1rem 0.2rem rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container">
    <h2>Upload PDF</h2>
    <form action="{{ route('upload.pdf.post') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="form-group">
            <label for="pdf">Choose PDF file</label>
            <input type="file" class="form-control-file" id="pdf" name="pdf" accept="application/pdf" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Upload</button>
    </form>
</div>

<!-- Include Bootstrap JS and dependencies (optional but recommended) -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
