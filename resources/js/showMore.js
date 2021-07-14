
axios.get(url, {})
.then((response) => {{}
  this.data = response.data.map(x => x)
  label = Object.values(this.data[0])
  temp = this.data[1]
  humidity = this.data[2]
})

var tempData = document.getElementById("temp").getContext("2d");
setTimeout(() => {
    var chart = new Chart(tempData, {
        type: "line",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Temperature",
                    data: temp,
                    backgroundColor: "rgba(255, 0, 0, 0.2)",
                    borderColor: "rgba(255, 0, 0, 0.2)",
                    stepped: true,
                },
            ],
        },
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "Weathe at .. last 24 hours!",
            },
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function (value, index, values) {
                            return value + "°C";
                        },
                    },
                },
            },
        },
    });
}, 1000);

var humidityData = document.getElementById("humidity").getContext("2d");
setTimeout(() => {
    var chart = new Chart(humidityData, {
        type: "line",
        data: {
            labels: label,
            datasets: [
                {
                    label: "Humidity",
                    data: humidity,
                    backgroundColor: "rgba(0, 0, 255, 0.2)",
                    borderColor: "rgba(0, 0, 255, 0.2)",
                    stepped: true,
                },
            ],
        },
        plugins: {
            legend: {
                position: "top",
            },
            title: {
                display: true,
                text: "Weathe at .. last 24 hours!",
            },
        },
        options: {
            scales: {
                y: {
                    ticks: {
                        callback: function (value, index, values) {
                            return value + "%";
                        },
                    },
                },
            },
        },
    });
}, 1000);
