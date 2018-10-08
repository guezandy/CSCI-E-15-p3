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
                           class="form-control @if (isset($errors) && $errors->has('distance')) is-invalid @endif"
                           type='number'
                           value='{{ old('distance') }}'
                           required>
                    @if (isset($errors))
                        @if ($errors->first('distance'))
                            <div class="invalid-feedback">
                                {{$errors->first('distance')}}
                            </div>
                        @else
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        @endif
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
                                   @if (old('unit'))
                                        @if (old('unit') == $unit)
                                            checked
                                        @endif
                                   @else
                                        @if($unit == 'mile')
                                            checked
                                        @endif
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
                    @if (isset($errors))
                        @if ($errors->first('hours'))
                            <div class="invalid-feedback">
                                {{$errors->first('hours')}}
                            </div>
                        @else
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        @endif
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
                    @if (isset($errors))
                        @if ($errors->first('minutes'))
                            <div class="invalid-feedback">
                                {{$errors->first('minutes')}}
                            </div>
                        @else
                            <div class="valid-feedback">
                                Looks good!
                            </div>
                        @endif
                    @endif
                </div>
            </div>
            <input type='submit' value='Calculate' class='btn btn-primary mb-3'>
        </form>
        @if (session('results'))
            <div class="result">
                <div class="alert alert-primary" role="alert">
                    Your goal pace is:
                    {{ Session::get('results') }}
                    {{--TODO(andrewr) Figure out why this syntax doesn't work if the docs say to do it --}}
                    {{-- {{ session['results'] }}--}}
                </div>
            </div>
        @endif
</div>
@endsection
