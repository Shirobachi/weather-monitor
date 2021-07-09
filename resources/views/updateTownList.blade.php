@extends('common')

@section('title', 'Log in!')

@section('content')

  <div class="row">
    <div class="offset-md-3 col-md-6 col-10 offset-1 mt-5">

    @if($info ?? '')
      <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
        <strong>{{$info['title'] ?? ''}}</strong> {{$info['desc'] ?? ''}}
      </div>
    @endif

      <div id="Vue">
        <div class="input-group mb-3">
          <span class="input-group-text" id="inputGroup-sizing-lg">Search: </span>
          <input type="text" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" v-model="input">
          <button form="form" type="submit" class="btn btn-outline-primary">Save!</button>
        </div>

        <form id="form" method="post" action="{{url('updateCities')}}">
          <div class="input-group">
          @csrf
            <span class="input-group-addon" v-for="c in cities" v-show="c.match || c.check">
              <label class="pe-4">
                <input type="checkbox" name="cities[]" :value="c.APIID" v-model="c.check"> @{{c.name}} [@{{c.id}}]
              </label>
            </span>
          </div>
        </form>

      </div>

    </div>
  </div>


  <script>
    const App = {
      data() {
        return {
          urlAPI: "/api/towns",
          cities: [],
          input: ''
        }
      },
      created() {
        axios.get(this.urlAPI, {})
          .then((response) => {
            this.cities = response.data.map(x => x)
            for (const town of this.cities) {
              town.check = false;
              town.match = true;
            }
          })
          this.processSearch = _.debounce(this.updateSearch, 200)
      },
      methods: {
        updateSearch(){
          if (this.input == '')
            for (const town of this.cities)
              town.match = true
            else
              for (const town of this.cities)
                if(town.name.toLowerCase().normalize('NFKD').replace(/[^\w]/g, '').indexOf(this.input.toLowerCase().normalize('NFKD').replace(/[^\w]/g, ''))!=-1)
                  town.match = true
                else
                  town.match = false
        }
      },
      watch: {
        input(){
          this.processSearch()
        }
      }
    }; Vue.createApp(App).mount('#Vue')

  </script>

@endsection