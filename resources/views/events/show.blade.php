@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h3>{{ $event->title }}</h3>
            <hr/>

            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">When?</div>
                        <div class="card-body">
                            <h5 class="card-title">{{ $event->time_start->format('d.m.Y') }}</h5>

                            <span>{{ $event->time_start->format('H:i') }} - {{ $event->time_end->format('H:i')}}</span>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card">
                        <div class="card-header">Tickets</div>
                        <div class="card-body">
                            <div class="progress">
                                <div class="progress-bar bg-success" role="progressbar"
                                     style="width: {{ $event->registrations->count() / $event->capacity * 100 }}%"
                                     aria-valuenow="{{ $event->registrations->count() / $event->capacity * 100 }}"
                                     aria-valuemin="0" aria-valuemax="100">
                                    {{ $event->registrations->count() }}/{{$event->capacity}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
