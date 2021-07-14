/******/ (() => { // webpackBootstrap
/******/ 	var __webpack_modules__ = ({

/***/ "./resources/js/showMore.js":
/*!**********************************!*\
  !*** ./resources/js/showMore.js ***!
  \**********************************/
/***/ (function() {

var _this = this;

axios.get(url, {}).then(function (response) {
  {}
  _this.data = response.data.map(function (x) {
    return x;
  });
  label = Object.values(_this.data[0]);
  temp = _this.data[1];
  humidity = _this.data[2];
});
var tempData = document.getElementById("temp").getContext("2d");
setTimeout(function () {
  var chart = new Chart(tempData, {
    type: "line",
    data: {
      labels: label,
      datasets: [{
        label: "Temperature",
        data: temp,
        backgroundColor: "rgba(255, 0, 0, 0.2)",
        borderColor: "rgba(255, 0, 0, 0.2)",
        stepped: true
      }]
    },
    plugins: {
      legend: {
        position: "top"
      },
      title: {
        display: true,
        text: "Weathe at .. last 24 hours!"
      }
    },
    options: {
      scales: {
        y: {
          ticks: {
            callback: function callback(value, index, values) {
              return value + "°C";
            }
          }
        }
      }
    }
  });
}, 1000);
var humidityData = document.getElementById("humidity").getContext("2d");
setTimeout(function () {
  var chart = new Chart(humidityData, {
    type: "line",
    data: {
      labels: label,
      datasets: [{
        label: "Humidity",
        data: humidity,
        backgroundColor: "rgba(0, 0, 255, 0.2)",
        borderColor: "rgba(0, 0, 255, 0.2)",
        stepped: true
      }]
    },
    plugins: {
      legend: {
        position: "top"
      },
      title: {
        display: true,
        text: "Weathe at .. last 24 hours!"
      }
    },
    options: {
      scales: {
        y: {
          ticks: {
            callback: function callback(value, index, values) {
              return value + "%";
            }
          }
        }
      }
    }
  });
}, 1000);

/***/ })

/******/ 	});
/************************************************************************/
/******/ 	
/******/ 	// startup
/******/ 	// Load entry module and return exports
/******/ 	// This entry module is referenced by other modules so it can't be inlined
/******/ 	var __webpack_exports__ = {};
/******/ 	__webpack_modules__["./resources/js/showMore.js"]();
/******/ 	
/******/ })()
;