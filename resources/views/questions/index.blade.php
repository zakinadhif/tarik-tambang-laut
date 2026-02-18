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
                <th>Answer</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($questions as $question)
            <tr>
                <td>{{ $question->question }}</td>
                <td>{{ $question->answer }}</td>
                <td>
                    <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-secondary">Edit</a>

                    <form action="{{ route('questions.destroy', $question) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this question?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>