@extends('layouts.app-with-sidebar')

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
                        <div class="card-body text-center">
                            <h3 class="card-title" style="margin: 0;">{{ $event->time_start->format('d M Y') }}</h3>
                            <div>{{ $event->time_start->format('l') }}</div>

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
                        @if(Auth::user()->hasMentorProfile())
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Register</a>
                            </div>
                        @endif

                        @if(Auth::user()->hasNinjaProfile())
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Register</a>
                            </div>
                        @endif

                        @if(Auth::user()->hasParentProfile())
                            <div class="card-footer">
                                <a href="#" class="btn btn-primary">Register your child(ren)</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    @auth
        @if(\Auth::user()->hasMentorProfile())
            <hr/>

            <div class="card">
                <div class="card-header">
                    Attendees
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Age</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($event->registrations as $registration)
                                <tr>
                                    <td>{{ $registration->user->name }}</td>
                                    <td>{{ $registration->user->ninjaProfile->age }}</td>
                                    <td>
                                        @if($registration->checked_in_at)
                                            <span class="badge badge-success">Checked in</span>
                                        @else
                                            <span class="badge badge-danger">Not checked in</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    @endauth
@endsection
