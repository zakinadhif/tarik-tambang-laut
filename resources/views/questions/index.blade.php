<!DOCTYPE html>
<html>
<head>
    <title>Questions List</title>
    <!-- Simple Bootstrap CDN for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
    <h1>Questions</h1>
    <a href="{{ route('questions.create') }}" class="btn btn-primary mb-3">Add New Question</a>
    
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Question</th>
                <th>Correct Option</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
            <tr>
                <td>{{ $question->question_text }}</td>
                <td>{{ $question->correct_option }}</td>
                <td>
                    <!-- Add edit/delete buttons here later -->
                    <span class="text-muted">Edit | Delete</span>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>