<!DOCTYPE html>
<html>
<head>
    <title>Add Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Add New Question</h1>
    
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Answer</label>
            <input type="text" name="answer" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-success">Save Question</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>