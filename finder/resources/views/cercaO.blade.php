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

                    {{ __('offerte!!!') }}{{ ', '.Auth::user()->name }}
                    <tr>
                    <button type="submit" onclick="window.location='/api/users'">click</button>

                    <tr>



                </div>
            </div>
        </div>
    </div>
</div>



@endsection
