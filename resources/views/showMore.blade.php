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

        @{{APIURL}}
        <br>
        data: @{{data}}

      </div> <!-- .Vue -->
    </div>
  </div>


  <script>
    const App = {
      data() {
        return {
          APIURL: "/api/showMore/{{$id}}",
          data: []
        }
      },
      created() {
        axios.get(this.APIURL, {})
          .then((response) => {{}
            this.data = response.data.map(x => x)
          })
        },
    }; Vue.createApp(App).mount('#Vue')

  </script>

@endsection