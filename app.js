window.addEventListener("load", () => {
  let lon;
  let lat;
  let Temperature = $(".degree");
  let City = $(".city");
  let Country = $(".country");
  let TempDescription = $(".description");
  let Humidity = $(".humidity");
  let Visibility = $(".visibility");
  let button = $(".button");
  let input = $(".input_text");
  let allowed_location = false;
  let coordinates;
  let ref_dict = {
    Clear: "clear-day",
    Clouds: "cloudy",
    Thunderstorm: "thunder-rain",
    Rain: "rain",
    Drizzle: "rain",
    Snow: "snow",
    Mist: "fog",
    Fog: "fog",
  };
  let tempFahr = "";
  let tempCel = "";

  function setIcon(icon, iconID) {
    let skycons = new Skycons({ color: "white" });
    skycons.play();
    const curr_icon = ref_dict[iconID].replace(/-/g, "_").toUpperCase();
    console.log(curr_icon);
    return skycons.set(icon, Skycons[curr_icon]);
  }

  function locationFound(position) {
    lon = position.coords.longitude;
    lat = position.coords.latitude;

    const api = `https://api.openweathermap.org/data/2.5/weather?lat=${lat}&lon=${lon}&appid=b86478b498e1b8b19398c1e9324abf6e&units=metric`;

    fetch(api)
      .then((response) => {
        return response.json();
      })
      .then((data) => {
        console.log(data);
        console.log("location found");
        //Setting DOM Elements from API
        const { temp, humidity } = data.main;
        tempCel = temp;
        tempFahr = (temp * 9) / 5 + 32;
        Temperature.text(`${temp} °C`);
        City.text(data.name);
        Country.text(data.sys.country);
        TempDescription.text(data.weather[0].description);
        Humidity.text(`${humidity}%`);
        Visibility.text(`${data.visibility}m`);
        setIcon("weather_icon", data.weather[0].main);
      });
  }

  Temperature.click(() => {
    const curr = Temperature.text();
    const unit = curr.charAt(curr.length - 1);
    Temperature.text(unit === "C" ? `${tempFahr} °F` : `${tempCel} °C`);
  });

  function noLocationFound() {
    button.click(function () {
      const api = `https://api.openweathermap.org/data/2.5/weather?q=${input.val()}&appid=b86478b498e1b8b19398c1e9324abf6e&units=metric`;

      fetch(api)
        .then((response) => {
          return response.json();
        })
        .then((data) => {
          console.log(data);

          //Setting DOM Elements from API
          const { temp, humidity } = data.main;
          tempCel = temp;
          tempFahr = (temp * 9) / 5 + 32;
          Temperature.text(`${temp} °C`);
          City.text(data.name);
          Country.text(data.sys.country);
          TempDescription.text(data.weather[0].description);
          Humidity.text(`${humidity}%`);
          Visibility.text(`${data.visibility}m`);
          setIcon("weather_icon", data.weather[0].main);
        })
        .catch((err) => alert("Wrong city name!"));
    });

    // alert("Not allowed!");
  }

  navigator.geolocation.getCurrentPosition(locationFound, noLocationFound);
});
