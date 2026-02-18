<!DOCTYPE html>
<html>
<head>
    <title>Edit Question</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Edit Question</h1>

    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('questions.update', $question) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label class="form-label">Question</label>
            <input type="text" name="question" class="form-control" value="{{ old('question', $question->question) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Answer</label>
            <input type="text" name="answer" class="form-control" value="{{ old('answer', $question->answer) }}" required>
        </div>
        <button type="submit" class="btn btn-success">Update Question</button>
        <a href="{{ route('questions.index') }}" class="btn btn-secondary">Back</a>
    </form>
</body>
</html>
