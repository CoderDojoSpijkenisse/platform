@extends('layouts.app-with-sidebar')

@section('content')
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <h3>{{__('My children')}}</h3>
            <hr/>

            {!! Form::open(['url' => route('parent.registrations')]) !!}
            @foreach(Auth::user()->parentProfile->childrenOrderedByName()->get()->chunk(3) as $subsetOfThreeChildren)
                <div class="row"{!! $loop->last ?: ' style="margin-bottom: 20px;"' !!}>
                    @foreach($subsetOfThreeChildren as $child)
                        <div class="col-md-4">
                            <div class="card{!! $child->isRegisteredForUpcomingDojo() ? ' border-success text-success' : '' !!}">
                                <div class="card-body">
                                    <h5 class="card-title" style="margin-bottom: 5px;">{{ $child->user->name }}</h5>
                                    <h6 class="card-subtitle" style="font-size: 0.9em;">{{ __('Age') }}: {{ $child->age }}</h6>
                                </div>
                                <div class="card-footer">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox"{!! $child->isRegisteredForUpcomingDojo() ? ' checked' : '' !!} value="{{$child->user->id}}" name="registrations[]" id="child-{{$child->id}}">
                                        <label class="form-check-label" for="child-{{$child->id}}">
                                            Attend {{ $nextDojo->time_start->format('d M') }}
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach

            <hr/>

            <button type="submit" class="btn btn-primary">Update registrations</button>
            {!! Form::close() !!}
        </div>
    </div>
@endsection