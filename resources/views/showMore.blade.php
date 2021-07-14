@extends('common')

@section('title', 'More informations!')

@section('content')

  <div class="row">
    <div class="offset-md-1 col-md-10 col-10 offset-1 mt-5">

      @if($info ?? '')
        <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
          <strong>{{$info['title'] ?? ''}}</strong> {!! $info['desc'] ?? '' !!}
        </div>
      @endif

      <div class="row">
        <div class="col-8 offset-2">
          <a href="{{url('dashboard')}}">
            <button class="btn btn-outline-success mb-2 input-block-level form-control" type="button">Dashboard!</button>
          </a>
        </div>

        <div class="col-xl-6 col-12">
          <canvas id="temp"></canvas>
        </div>
        <div class="col-xl-6 col-12">
          <canvas id="humidity"></canvas>
        </div>
      </div>

    </div>
  </div>

<script>
  let url = "/api/showMore/{{$id}}";
</script>
<script src="{{ asset('js/showMore.js') }}"></script>


@endsection