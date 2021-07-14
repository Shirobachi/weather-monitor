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
    axios.get("/api/showMore/{{$id}}", {}).then((response) => {{}
    this.data = response.data.map((x) => x);
    label = Object.values(this.data[0]);
    temp = this.data[1];
    humidity = this.data[2];
    });
  </script>

<script src="{{ asset('js/showMore.js') }}"></script>


@endsection