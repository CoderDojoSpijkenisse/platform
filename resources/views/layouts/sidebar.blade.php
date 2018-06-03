@auth
    <div class="card d-none d-sm-block">
        <div class="card-body">
            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&rounded=true"
                 style="float: right;">
            <h5 class="card-title">{{ Auth::user()->name }}</h5>
            <p class="card-text">{{ Auth::user()->email }}</p>
        </div>
    </div>

    <hr/>
@endauth
@guest
    <hr class="d-sm-none"/>
@endguest

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
                <div class="progress-bar {{ $nextDojo->registrations->count() === $nextDojo->capacity ? 'bg-danger' : 'bg-success' }}" role="progressbar"
                     style="width: {{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}%"
                     aria-valuenow="{{ $nextDojo->registrations->count() / $nextDojo->capacity * 100 }}"
                     aria-valuemin="0" aria-valuemax="100">
                    {{ $nextDojo->registrations->count() === $nextDojo->capacity ? 'FULL' : '' }}
                </div>
            </div>
            @unless($nextDojo->capacity === $nextDojo->registrations->count())
            <div class="text-center" style="font-size: 0.8em;">
                {{ $nextDojo->capacity - $nextDojo->registrations->count() }} tickets left
            </div>
            @endunless
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

<hr class="d-none d-sm-block"/>

<div class="card d-none d-sm-block">
    <div class="card-header">
        Upcoming dojos
    </div>
    <div class="card-body">
        @foreach($upcomingDojos as $dojo)
            <div style="color: gray">
                <span>
                    <strong><a href="{{ route('events.show', ['id' => $dojo->id]) }}">{{ $dojo->title }}</a></strong><br/>
                    T {{ $dojo->time_start->format('d-m-Y H:i') }}
                </span>
            </div>
            @if(!$loop->last)
                <hr/>
            @endif
        @endforeach
    </div>
</div>