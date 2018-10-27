@extends('layout')

@section('content')
    <div class="jumbotron">
        <h1>Running pace calculator</h1>
        <p>To calculate running pace enter distance you want to run and the goal time.</p>
        <hr>
        <form method='POST' action="{{URL::Route('CalculatePace')}}">
            {{ csrf_field() }}
            <div class="mb-3 row">
                <div class="col-sm-8">
                    <label for="distance">Enter distance</label>
                    <input name='distance'
                           id='distance'
                           class="form-control @if ($errors->has('distance')) is-invalid @endif"
                           type='number'
                           value='{{ old('distance') }}'
                           required>
                    @if(isset($errors) && $errors->has('distance'))
                        @component('components.input-validation', ['error' => $errors->first('distance')])@endcomponent
                    @endif
                </div>
                <div class="col-sm-3 col-sm-offset-1 unit-radio">
                    @foreach (['mile', 'kilometer'] as $unit)
                        <div class="custom-control custom-radio">
                            <input type="radio"
                                   class="custom-control-input @if (isset($errors) && $errors->has('unit')) is-invalid @endif"
                                   id="{{$unit}}"
                                   name="unit"
                                   value='{{$unit}}'
                                   {{-- Use default value to handle default selecting mile on first loading page --}}
                                   @if (old('unit', 'mile') == $unit)
                                   checked
                                   @endif
                                   required>
                            <label class="custom-control-label"
                                   for="{{$unit}}">
                                @if ($unit == 'mile')
                                    Mile(s)
                                @else
                                    Kilometer(s)
                                @endif
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="mb-3 row">
                <div class="col-sm-6">
                    <label for="hours">Hours</label>
                    <input name='hours'
                           id='hours'
                           class="form-control @if (isset($errors) && $errors->has('hours')) is-invalid @endif "
                           value='{{ old('hours') ?? 0 }}'
                           type='number'>
                    @if (isset($errors) && $errors->first('hours'))
                        @component('components.input-validation', ['error' => $errors->first('hours')])@endcomponent
                    @endif
                </div>
                <div class="col-sm-6">
                    <label for="minutes">Minutes</label>
                    <select class="custom-select @if (isset($errors) && $errors->has('minutes')) is-invalid @endif"
                            id='minutes'
                            name='minutes'>
                        @for ($i = 0; $i < 60; $i++)
                            <option
                                value='{{$i}}'
                                @if( old('minutes') == $i) selected @endif>
                                {{$i}}
                            </option>
                        @endfor
                    </select>
                    @if (isset($errors) && $errors->first('minutes'))
                        @component('components.input-validation', ['error' => $errors->first('minutes')])@endcomponent
                    @endif
                </div>
            </div>
            <input type='submit' value='Calculate' class='btn btn-primary mb-3'>
        </form>
        @if (session('results'))
            <div class="result">
                <div class="alert alert-primary" role="alert">
                     {{ session('results') }}
                </div>
            </div>
        @endif
    </div>
@endsection
