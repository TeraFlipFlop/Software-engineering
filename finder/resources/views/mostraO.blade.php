@extends('layouts.app')
@section('content')

<div class="container">

show offerta
<ul>

<li>{{$offerta->titolo}}</li>
<li>{{$offerta->descr}}</li>
<li>{{$offerta->regione}}</li>
<li>{{$offerta->tipo_contratto}}</li>
<li>{{$offerta->settore}}</li>
<li>{{$offerta->titolo_studi}}</li>
<br>
<br>
Skills
<br>
@php
    $string='';
@endphp

@foreach ($offerta->skills as $string)
<li>{{$string}}</li>
@endforeach
</ul>


</div>


@endsection
