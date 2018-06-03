@extends('layouts.app-with-sidebar')

@section('content')
    <div class="card">
        <div class="card-body">
            <h1>My Presence</h1>
            <hr/>

            <div class="row">
                <div class="col-md-6">
                    <h4>Next dojo</h4>

                    <p>
                        {{ $nextDojo->title }}
                    </p>

                    <p>
                        Date: {{ $nextDojo->time_start->format('d-m-Y') }}<br/>
                        Time: {{ $nextDojo->time_start->format('H:i') }}
                    </p>

                    {!! Form::open(['url' => route('event-registrations.store')]) !!}
                    @if($nextDojo->mentors->pluck('user_id')->contains(\Auth::user()->id))
                        <p>During this dojo you are <span class="badge badge-success">present</span></p>
                        <button class="btn btn-danger btn-block" name="presence" value="false">I can't be there anymore</button>
                    @else
                        <p>During this dojo you are <span class="badge badge-danger">absent</span></p>
                        <button class="btn btn-success btn-block" name="presence" value="true">I will be there!</button>
                    @endif
                    {!! Form::close() !!}

                    <hr/>
                    <h5>Helping out</h5>
                    @unless($nextDojo->mentors->isEmpty())
                    <ul>
                        @foreach($nextDojo->mentors as $mentorRegistrations)
                            <li>{{ $mentorRegistrations->user->name }}</li>
                        @endforeach
                    </ul>
                    @else
                    <em>Nobody signed up yet, please help us out! :-)</em>
                    @endunless
                </div>
                <div class="col-md-6">
                    <h4>Upcoming dojos</h4>

                    <ul>
                        @foreach($upcomingDojos as $dojo)
                            <li>{{$dojo->time_start->format('d-m-Y')}}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection