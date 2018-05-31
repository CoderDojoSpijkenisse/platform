@extends('layouts.app')

@section('content')
    <div class="card">
        <div class="card-header">Lessons</div>

        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif

            @foreach($lessons as $lesson)
                <h4>{{ $lesson->title }}</h4>
                <span style="color: lightgray;">Type: {{ $lesson->type }}
                    - Level: {{ $lesson->level }}</span>

                <p>
                    {{ $lesson->description }}
                </p>

                <strong>Prerequisites</strong>
                <p>
                    {{ $lesson->prerequisites }}
                </p>

                @if (!$loop->last)
                    <hr/>
                @endif
            @endforeach
        </div>
    </div>
@endsection
