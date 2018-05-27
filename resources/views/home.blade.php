@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
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
                            <span style="color: lightgray;">Type: {{ $lesson->type }} - Level: {{ $lesson->level }}</span>

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
            </div>
            <div class="col-md-4">
                @auth
                    <div class="card">
                        <div class="card-body">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&rounded=true" style="float: right;">
                            <h5 class="card-title">{{ Auth::user()->name }}</h5>
                            <p class="card-text">{{ Auth::user()->email }}</p>
                        </div>
                        <div class="card-footer">
                            <a href="#" class="btn btn-primary">Order tickets</a>
                            <a href="#" class="btn btn-link">See tickets</a>
                        </div>
                    </div>

                    <hr/>
                @endauth

                <div class="card">
                    <div class="card-header">
                        Upcoming dojos
                    </div>
                    <div class="card-body">
                        @if($nextDojo)
                            <div>
                                <h2>Next dojo</h2>
                                <strong>{{ $nextDojo->title }}</strong><br/>
                                {{ $nextDojo->time_start->format('d M Y / H:i') }}-{{ $nextDojo->time_end->format('H:i') }}
                            </div>
                            <div class="progress">
                                <div class="progress-bar-success" role="progressbar" style="width: {{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}%" aria-valuenow="{{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <div>
                                <p>
                                    <strong>Venue details:</strong><br/>
                                    {{ $nextDojo->address_street }}<br/>
                                    {{ $nextDojo->address_postal_code }} {{ $nextDojo->address_city }}
                                </p>
                            </div>
                        @endif

                        <hr/>

                        @foreach($upcomingEvents as $event)
                            <div style="color: gray">
                                <span>
                                    <strong>{{ $event->title }}</strong><br/>
                                    T {{ $event->time_start->format('d-m-Y H:i') }}
                                </span>
                                <div class="progress">
                                    <div class="progress-bar" role="progressbar" style="width: {{ $event->registrations->count() / $event->capacity * 100 }}%" aria-valuenow="{{ $event->registrations->count() / $event->capacity * 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                            </div>
                            @if(!$loop->last)
                                <hr/>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
