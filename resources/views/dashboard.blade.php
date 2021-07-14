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
    const App = {
      data() {
        return {
          urlAPI: "/api/weatherNow/{{session()->get('userID')}}",
          townsAPI: "/api/towns",
          towns: [],
          allTowns: [],
        }
      },
      created() {
        axios.get(this.urlAPI, {})
          .then((response) => {{}
            this.towns = response.data
            for (const town of this.towns){
              town.URL = "/showMore/" + town.APIID
              town.removeURL = "/remove/" + town.APIID
            }
          })

        axios.get(this.townsAPI, {})
          .then((response) => {{}
            this.allTowns = response.data

            autocomplete(document.getElementById("towns"), this.allTowns);
          })
        },
      methods: {},
    }; Vue.createApp(App).mount('#Vue')

  </script>

  <script>
    function autocomplete(inp, arr) {
    /*the autocomplete function takes two arguments,
    the text field element and an array of possible autocompleted values:*/
    var currentFocus;
    /*execute a function when someone writes in the text field:*/
    inp.addEventListener("input", function(e) {
        var a, b, i, val = this.value;
        /*close any already open lists of autocompleted values*/
        closeAllLists();
        if (!val) { return false;}
        currentFocus = -1;
        /*create a DIV element that will contain the items (values):*/
        a = document.createElement("DIV");
        a.setAttribute("id", this.id + "autocomplete-list");
        a.setAttribute("class", "autocomplete-items");
        /*append the DIV element as a child of the autocomplete container:*/
        this.parentNode.appendChild(a);
        /*for each item in the array...*/
        for (i = 0; i < arr.length; i++) {
          /*check if the item starts with the same letters as the text field value:*/
          if (arr[i].substr(0, val.length).toUpperCase() == val.toUpperCase()) {
            /*create a DIV element for each matching element:*/
            b = document.createElement("DIV");
            /*make the matching letters bold:*/
            b.innerHTML = "<strong>" + arr[i].substr(0, val.length) + "</strong>";
            b.innerHTML += arr[i].substr(val.length);
            /*insert a input field that will hold the current array item's value:*/
            b.innerHTML += "<input type='hidden' value='" + arr[i] + "'>";
            /*execute a function when someone clicks on the item value (DIV element):*/
                b.addEventListener("click", function(e) {
                /*insert the value for the autocomplete text field:*/
                inp.value = this.getElementsByTagName("input")[0].value;
                /*close the list of autocompleted values,
                (or any other open lists of autocompleted values:*/
                closeAllLists();
            });
            a.appendChild(b);
          }
        }
    });
    /*execute a function presses a key on the keyboard:*/
    inp.addEventListener("keydown", function(e) {
        var x = document.getElementById(this.id + "autocomplete-list");
        if (x) x = x.getElementsByTagName("div");
        if (e.keyCode == 40) {
          /*If the arrow DOWN key is pressed,
          increase the currentFocus variable:*/
          currentFocus++;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 38) { //up
          /*If the arrow UP key is pressed,
          decrease the currentFocus variable:*/
          currentFocus--;
          /*and and make the current item more visible:*/
          addActive(x);
        } else if (e.keyCode == 13) {
          /*If the ENTER key is pressed, prevent the form from being submitted,*/
          e.preventDefault();
          if (currentFocus > -1) {
            /*and simulate a click on the "active" item:*/
            if (x) x[currentFocus].click();
          }
        }
    });
    function addActive(x) {
      /*a function to classify an item as "active":*/
      if (!x) return false;
      /*start by removing the "active" class on all items:*/
      removeActive(x);
      if (currentFocus >= x.length) currentFocus = 0;
      if (currentFocus < 0) currentFocus = (x.length - 1);
      /*add class "autocomplete-active":*/
      x[currentFocus].classList.add("autocomplete-active");
    }
    function removeActive(x) {
      /*a function to remove the "active" class from all autocomplete items:*/
      for (var i = 0; i < x.length; i++) {
        x[i].classList.remove("autocomplete-active");
      }
    }
    function closeAllLists(elmnt) {
      /*close all autocomplete lists in the document,
      except the one passed as an argument:*/
      var x = document.getElementsByClassName("autocomplete-items");
      for (var i = 0; i < x.length; i++) {
        if (elmnt != x[i] && elmnt != inp) {
        x[i].parentNode.removeChild(x[i]);
      }
    }
  }
  /*execute a function when someone clicks in the document:*/
  document.addEventListener("click", function (e) {
      closeAllLists(e.target);
  });
  }

  </script>

@endsection