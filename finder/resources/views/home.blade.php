@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}{{ ', '.Auth::user()->name }}
                    <tr>
                    <button type="submit" onclick="window.location='/cercaO'">cerca offerte</button>

                    </tr>
                    @if(Auth::user()->flag==0)
                        {!! Form::button('modifica profilo')!!}
                        <tr> {!!Form::button('notifiche')!!} </tr>

                    @elseif(Auth::user()->flag==1)
                    <button type="submit" onclick="window.location='/pubblicaO'">pubblica offerte</button>{!! Form::button('modifica profilo')!!}

                        {!! Form::button('candidature')!!}
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('offerte di oggi') }}</div>
                <div class="card-body">
                    @if(session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif



                    @php
                        $data= DB::select('select * from offerte');

                    @endphp
                    <ul>
                        @foreach($data as $offerta)
                            <li>
                                <a href="/api/offerte/{!!$offerta->id!!}" > {!!$offerta->titolo!!} </a>
                            </li>


                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
