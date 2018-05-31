@auth
    <div class="card">
        <div class="card-body">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&rounded=true"
                 style="float: right;">
            <h5 class="card-title">{{ Auth::user()->name }}</h5>
            <p class="card-text">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <hr/>
@endauth

<div class="card">
    <div class="card-header">
        Next dojo
    </div>
    <div class="card-body">
        @if($nextDojo)
            <div>
                <h2>Next dojo</h2>
                <strong><a href="{{ route('events.show', ['id' => $nextDojo->id]) }}">{{ $nextDojo->title }}</a></strong><br/>
                {{ $nextDojo->time_start->format('d M Y / H:i') }}
                -{{ $nextDojo->time_end->format('H:i') }}
            </div>
            <div class="progress">
                <div class="progress-bar bg-success" role="progressbar"
                     style="width: {{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}%"
                     aria-valuenow="{{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}"
                     aria-valuemin="0" aria-valuemax="100"></div>
            </div>
            <div>
                <p>
                    <strong>Venue details:</strong><br/>
                    {{ $nextDojo->address_street }}<br/>
                    {{ $nextDojo->address_postal_code }} {{ $nextDojo->address_city }}
                </p>
            </div>
        @endif
    </div>
    @auth
        @if($nextDojo)
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
        @endif
    @endauth
</div>

<hr/>

<div class="card">
    <div class="card-header">
        Upcoming dojos
    </div>
    <div class="card-body">
        @foreach($upcomingEvents as $event)
            <div style="color: gray">
                <span>
                    <strong><a href="{{ route('events.show', ['id' => $event->id]) }}">{{ $event->title }}</a></strong><br/>
                    T {{ $event->time_start->format('d-m-Y H:i') }}
                </span>
                <div class="progress">
                    <div class="progress-bar" role="progressbar"
                         style="width: {{ $event->registrations->count() / $event->capacity * 100 }}%"
                         aria-valuenow="{{ $event->registrations->count() / $event->capacity * 100 }}"
                         aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            </div>
            @if(!$loop->last)
                <hr/>
            @endif
        @endforeach
    </div>
</div>