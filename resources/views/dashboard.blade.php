@extends('common')

@section('title', 'Dashboard!')

@section('content')

  <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet" />

  <div class="row">
    <div class="offset-md-3 col-md-6 col-10 offset-1 mt-5">

      @if($info ?? '')
        <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
          <strong>{{$info['title'] ?? ''}}</strong> {!! $info['desc'] ?? '' !!}
        </div>
      @endif

      <div id="Vue">
        <form autocomplete="off" action="/addTown" method="POST" v-if="towns.length < 10">
          @csrf
          <span class="autocomplete input-group mb-3">
            <input id="towns" class="form-control" type="text" name="town" placeholder="Start writing the town to add" required>
            <input type="submit" class="btn btn-outline-primary" value="Add town!">
          </span>
        </form>

        <div class="row">
            <div class="col-12 col-md-6 ps-3 py-3" v-for="t in towns">
              <h1>@{{t.townName}}</h1>
              <div v-if="t.temp">
                <div>Temperature - @{{t.temp}}°C</div>
                <div>Humidity - @{{t.humidity}}%</div>
                <a :href="t.URL">
                  <button type="button" class="btn btn-outline-primary mt-2">See more</button>
                </a>
                <a :href="t.removeURL">
                  <button type="button" class="btn btn-outline-danger mt-2">Remove</button>
                </a>
              </div>
              <div v-else>
                This data is not available yet ;/
              </div>
            </div>
        </div>
      
      </div> <!-- .Vue -->
    </div>
  </div>


  <script>
    let urlAPI = "/api/weatherNow/{{session()->get('userID')}}"
  </script>

  <script src="{{ asset('js/dashboard.js') }}"></script>

@endsection