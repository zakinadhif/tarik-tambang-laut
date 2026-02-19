@extends('questions.layout')

@section('title', 'Add Question')

@section('content')
    <section class="page-panel panel-narrow">
        <h1 class="page-title">Tambah Soal</h1>

        @if($errors->any())
            <div class="alert-danger-custom">
                <p class="error-title">Periksa input berikut:</p>
                <ul class="error-list">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('questions.store') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label for="question" class="form-label">Pertanyaan</label>
                <input
                    id="question"
                    type="text"
                    name="question"
                    class="form-control"
                    value="{{ old('question') }}"
                    placeholder="contoh: Would you lose?"
                    required
                >
            </div>
            <div class="mb-1">
                <label for="answer" class="form-label">Jawaban</label>
                <input
                    id="answer"
                    type="text"
                    name="answer"
                    class="form-control"
                    value="{{ old('answer') }}"
                    placeholder="contoh: Nah, I'd win"
                    required
                >
            </div>
            <div class="form-footer">
                <a href="{{ route('questions.index') }}" class="btn btn-neutral">Kembali</a>
                <button type="submit" class="btn btn-brand">Simpan Soal</button>
            </div>
        </form>
    </section>
@endsection
