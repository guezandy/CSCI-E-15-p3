@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Running pace calculator</h1>
        <p>To calculate running pace enter distance you want to run and the goal time.</p>
        <hr>
        <form method='POST' action="{{URL::Route('CalculatePace')}}">
            <input type='submit' value='Calculate' class='btn btn-primary mb-3'>
        </form>
        @if (isset($results))
        <div class="result">
            <div class="alert alert-primary" role="alert">
                Your goal pace is:
                {{$results}}
            </div>
        </div>
        @endif
    </div>
@endsection
