@extends('common')

@section('title', 'Dashboard!')

@section('content')

  <div class="row">
    <div class="offset-md-3 col-md-6 col-10 offset-1 mt-5">

      @if($info ?? '')
        <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
          <strong>{{$info['title'] ?? ''}}</strong> {!! $info['desc'] ?? '' !!}
        </div>
      @endif

      <div id="Vue">
        <a href="{{url('updateCities')}}">
          <button id="toggleAll" class="btn btn-outline-info mb-2 input-block-level form-control" type="button">Update following towns!</button>
        </a>

        <div class="row">
            <div class="col-12 col-md-6 ps-3 py-3" v-for="t in towns">
              <h1>@{{t.townName}}</h1>
              <div v-if="t.temp">
                <div>Temperature - @{{t.temp}}°C</div>
                <div>Humidity - @{{t.humidity}}%</div>
                <a :href="t.URL">
                  <button type="button" class="btn btn-outline-primary mt-2">See more</button>
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
    const App = {
      data() {
        return {
          urlAPI: "/api/weatherNow/{{session()->get('userID')}}",
          towns: []
        }
      },
      created() {
        axios.get(this.urlAPI, {})
          .then((response) => {{}
            this.towns = response.data.map(x => x) 
            for (const town of this.towns){
              town.URL = "/showMore/" + town.APIID
            }
          })
        },
      methods: {},
    }; Vue.createApp(App).mount('#Vue')

  </script>

@endsection