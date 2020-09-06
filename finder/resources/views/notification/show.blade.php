@extends('layouts.app')
@section('content')

<div class="container">

show notification
<ul>
    @foreach ($notifications as $notification)
<li>{{$notification->type}}</li>
    @endforeach
</ul>


</div>


@endsection
