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
            <span class="input-group-addon" v-for="c in citiesMatched">
              <label class="pe-4">
                <input type="checkbox" name="cities[]" :value="c.id"> @{{c.name}}
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
          citiesMatched: [],
          input: ''
        }
      },
      created() {
        axios.get(this.urlAPI, {})
          .then((response) => {
            this.cities = response.data.map(x => x) 
            this.citiesMatched = this.cities 
          })
          this.processSearch = _.debounce(this.copyMatched, 200)
      },
      methods: {
        copyMatched(){
          if (this.input == '')
          this.citiesMatched = this.cities 
          else
          this.citiesMatched = this.cities.filter((city) => {
            return city.name.toLowerCase().normalize('NFKD').replace(/[^\w]/g, '').indexOf(this.input.toLowerCase().normalize('NFKD').replace(/[^\w]/g, ''))!=-1
          })
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