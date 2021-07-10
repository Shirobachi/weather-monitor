@extends('common')

@section('title', 'Dashboard!')

@section('content')

  <div class="row">
    <div class="offset-md-1 col-md-10 col-10 offset-1 mt-5">

      @if($info ?? '')
        <div class="alert alert-{{$info['type'] ?? 'success'}} alert-dismissible fade show" role="alert">
          <strong>{{$info['title'] ?? ''}}</strong> {!! $info['desc'] ?? '' !!}
        </div>
      @endif

      <div class="row">
        <a href="{{url('dashboard')}}">
          <button id="toggleAll" class="btn btn-outline-success mb-2 input-block-level form-control" type="button">Dashboard!</button>
        </a>

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
  
  axios.get('/api/showMore/{{$id}}', {})
          .then((response) => {{}
            this.data = response.data.map(x => x)
            label = Object.values(this.data[0])
            temp = this.data[1]
            humidity = this.data[2]
          })

var tempData = document.getElementById('temp').getContext('2d');
setTimeout(() => {  
  var chart = new Chart(tempData, {
      type: 'line',
      data: {
          labels: label,
          datasets: [{
              label: 'Temperature',
              data: temp,
              backgroundColor: 'rgba(255, 0, 0, 0.2)',
              borderColor: 'rgba(255, 0, 0, 0.2)',
              stepped: true
            }
        ]
      },
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Weathe at .. last 24 hours!'
        }
      }
  });
}, 1000);

var humidityData = document.getElementById('humidity').getContext('2d');
setTimeout(() => {  
  var chart = new Chart(humidityData, {
      type: 'line',
      data: {
          labels: label,
          datasets: [{
              label: 'Temperature',
              data: humidity,
              backgroundColor: 'rgba(0, 0, 255, 0.2)',
              borderColor: 'rgba(0, 0, 255, 0.2)',
              stepped: true
            }
        ]
      },
      plugins: {
        legend: {
          position: 'top',
        },
        title: {
          display: true,
          text: 'Weathe at .. last 24 hours!'
        }
      }
  });
}, 1000);


</script>


@endsection