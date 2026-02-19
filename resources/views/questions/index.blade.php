@extends('questions.layout')

@section('title', 'Bank Soal')

@section('content')
    <section class="page-panel">
        <div class="top-bar">
            <div>
                <h1 class="page-title">Bank Soal</h1>
            </div>
            <div class="top-actions">
                <a href="{{ url('/game') }}" class="btn btn-neutral">Lihat Game</a>
                <a href="{{ route('questions.create') }}" class="btn btn-brand">Tambah Soal</a>
            </div>
        </div>

        @if(session('success'))
            <div class="alert-custom">{{ session('success') }}</div>
        @endif

        @if($questions->isEmpty())
            <div class="empty-state">
                <h2 class="empty-title">Belum ada soal</h2>
                <p class="empty-text">Tambahkan soal pertama agar langsung bisa dipakai di game.</p>
                <a href="{{ route('questions.create') }}" class="btn btn-brand">Tambah Soal Pertama</a>
            </div>
        @else
            <div class="table-shell">
                <table class="table question-table align-middle">
                    <thead>
                        <tr>
                            <th>Question</th>
                            <th>Answer</th>
                            <th class="text-nowrap">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($questions as $question)
                            <tr>
                                <td class="question-cell">{{ $question->question }}</td>
                                <td>
                                    <span class="answer-chip">{{ $question->answer }}</span>
                                </td>
                                <td>
                                    <div class="action-stack">
                                        <a href="{{ route('questions.edit', $question) }}" class="btn btn-sm btn-neutral">Edit</a>
                                        <form action="{{ route('questions.destroy', $question) }}" method="POST" onsubmit="return confirm('Delete this question?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-soft">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
