
<!DOCTYPE html>
<html>
<head>
    <title>Film Catalog</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            background: #f5f7fa;
        }
        .container {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.07);
            padding: 32px 24px;
            margin-top: 32px;
            margin-bottom: 32px;
        }
        h1, h2, h3, h4, h5 {
            font-family: 'Segoe UI', Arial, sans-serif;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        @yield('content')
    </div>
</body>
</html>