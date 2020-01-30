import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class API extends Component {
    constructor() {
        super();
        this.state = {
            zone: null,
            datum: null,
            time: null,
            timeInterval: null,
            name: null,
            temp: null,
            pressure: null,
            humidity: null,
            weatherInterval: null,
            region: "Europe",
            city: "Belgrade"
        }

        this.pozoviTime = this.pozoviTime.bind(this);
        this.pozoviWeather = this.pozoviWeather.bind(this);
        this.rukujSelektorom = this.rukujSelektorom.bind(this)
    }

    pozoviTime() {
        fetch("http://worldtimeapi.org/api/timezone/" + this.state.region + "/" + this.state.city)
            .then(rsp => rsp.json())
            .then(response => {
                // console.log(response);
                this.setState({
                    zone: response.timezone,
                    datum: pf.dateToSerbianFormat(response.datetime.substring(0, 10)),
                    time: response.datetime.substring(11, 16), //11,19 za sekunde
                })

            })
            .catch(err => {
                console.log(err);
            });
    }

    pozoviWeather() {
        fetch("http://api.openweathermap.org/data/2.5/weather?q=" + this.state.city + "&APPID=b214a5363d0244cc7a18d2586dc0314c")
            .then(rsp => rsp.json())
            .then(response => {
                // console.log(response);
                this.setState({
                    temp: (response.main.temp - 272.15).toFixed(0),
                    name: response.name,
                    pressure: response.main.pressure,
                    humidity: response.main.humidity,
                });

            })
            .catch(err => {
                console.log(err);
            });
    }


    componentDidMount() {
        this.pozoviTime();
        this.pozoviWeather();
        this.timer = setInterval(() => {
            this.pozoviTime();
            this.pozoviWeather()
        },
            20000)
    }

    componentDidUpdate(prevProps, prevState) {
        if (prevState.city !== this.state.city) {
            console.log(this.state, prevState)
            this.pozoviTime()
            this.pozoviWeather()
        }
    }

    componentWillUnmount() {
        clearInterval(this.timer);

    }

    rukujSelektorom(event) {
        let city = event.target.value
        let region = city === "Tokyo" ? "Asia" : "Europe"
        this.setState({
            region: region,
            city: city
        })
    }

    promeniSliku(city) {
        switch (city) {
            case "Belgrade":
                return <img src="/images/city.png" alt="city"></img>;
            case "Paris":
                return <img src="/images/paris.png" alt="city"></img>;
            case "Tokyo":
                return <img src="/images/tokyo.png" alt="city"></img>;
            case "London":
                return <img src="/images/London.png" alt="city"></img>;
            default:
                return <img src="/images/city.png" alt="city"></img>;
        }
    }

    render() {
        //destructuring
        const { zone, datum, time, name, temp, pressure, humidity } = this.state;
        return (
            <div className="reactApi">
                <div className="reactCity">
                    <p className="city">{this.promeniSliku(this.state.city)} {name}</p>
                    <p className="selectCity">Izaberi grad</p>
                    <select id="selectorGrad" onChange={this.rukujSelektorom}>
                        <option value="Belgrade">Beograd</option>
                        <option value="Paris">Paris</option>
                        <option value="London">London</option>
                        <option value="Tokyo">Tokio</option>
                    </select>
                </div>
                <div className="reactDate">
                    <div className="dateItems">
                        <img src="/images/time-zone.png" alt="time-zone"></img>
                        <span>{zone}</span>
                    </div>
                    <div className="dateItems">
                        <img src="/images/calendar.png" alt="calendar"></img>
                        <span>{datum}</span>
                    </div>
                    <div className="dateItems">
                        <img src="/images/clock.png" alt="clock"></img>
                        <span>{time}</span>
                    </div>
                </div>
                <div className="reactWeather">
                    <div className="temperature">
                        <img src="/images/thermometer.png" alt="temperature"></img>
                        <span>{temp} &#x2103;</span>
                    </div>
                    <div className="temperature">
                        <img src="/images/pressure.png" alt="pressure"></img>
                        <span>{pressure} mB</span>
                    </div>
                    <div className="temperature">
                        <img src="/images/humidity.png" alt="humidity"></img>
                        <span>{humidity} %</span>
                    </div>
                </div>
            </div>
        );
    }
}


export default API;

if (document.getElementById('vreme')) {
    ReactDOM.render(<API />, document.getElementById('vreme'));
}
