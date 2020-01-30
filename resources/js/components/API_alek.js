import React, { Component } from 'react';
import ReactDOM from 'react-dom';

class API extends Component
{
    constructor()
    {
        super();
        this.state={
            zone:null,
            datum:null,
            time:null,
            timeInterval:null,
            name:null,
            temp:null,
            pressure:null,
            humidity:null,
            weatherInterval:null,
            fetTime:"Europe/Belgrade",
            fetWet:"Belgrade,rs",
        }

        this.pozoviTime=this.pozoviTime.bind(this);
        this.continueCallTime=this.continueCallTime.bind(this);
        this.pozoviWeather=this.pozoviWeather.bind(this);
        this.continiueCallWeather=this.continiueCallWeather.bind(this);
        this.setFetch=this.setFetch.bind(this);
    }

    pozoviTime()
    {
        let opcije={
            "method": "GET",
        }

        fetch("http://worldtimeapi.org/api/timezone/"+this.state.fetTime, opcije)
        .then(rsp=>rsp.json())
        .then(response => {
            // console.log(response);
            this.setState({
                zone:response.timezone,
                datum:pf.dateToSerbianFormat(response.datetime.substring(0,10)),
                time:response.datetime.substring(11,16), //11,19 za sekunde
            })
            
        })
        .catch(err => {
            console.log(err);
        });
    }

    continueCallTime()
    {
        this.setState({timeInterval:setInterval(this.pozoviTime,5000)});
    }

    pozoviWeather()
    {
        let opcije={
            "method": "GET",
        }

        fetch("http://api.openweathermap.org/data/2.5/weather?q="+this.state.fetWet+"&APPID=17f779dd77988c24551bd27df2f061ae", opcije)
        .then(rsp=>rsp.json())
        .then(response => {
            // console.log(response);
            this.setState({
                temp:(response.main.temp-272.15).toFixed(0),
                name:response.name,
                pressure:response.main.pressure,
                humidity:response.main.humidity,
            });
            
        })
        .catch(err => {
            console.log(err);
        });
    }

    continiueCallWeather()
        {
            this.setState({weatherInterval:setInterval(this.pozoviWeather,1000*30*60)});
        }


    componentDidMount()
    {
        this.pozoviTime();
        this.continueCallTime();
        this.pozoviWeather();
        this.continiueCallWeather();
    }

    componentWillUnmount()
    {
        clearInterval(this.state.timeInterval);
        clearInterval(this.state.weatherInterval);
    }

    setFetch(event)
    {
        let nizOdSelektora=event.target.value.split('/');
        this.setState({
            fetTime:nizOdSelektora[0]+"/"+nizOdSelektora[1],
            fetWet:nizOdSelektora[1]+","+nizOdSelektora[2],
        });
    }

    componentDidUpdate(prevProps, prevState) {
        if (prevState.fetWet !== this.state.fetWet) {
            clearInterval(this.state.timeInterval);
            clearInterval(this.state.weatherInterval);
            this.pozoviTime();
            this.pozoviWeather();
            this.continueCallTime();
            this.continiueCallWeather();
        }
    }

    render()
    {
        //destructuring
        const {zone,datum,time,name,temp,pressure,humidity}=this.state;
        return(
                    <div className="reactApi">
                        <select  id="selectorGrad" onChange={this.setFetch}>
                            <option value="Europe/Belgrade/rs">Beograd</option>
                            <option value="Europe/Paris/fr">Paris</option>
                            <option value="Europe/London/uk">London</option>
                            <option value="Asia/Tokyo/jp">Tokio</option>
                        </select>
                    <div>
                        Zona: <p>{ zone }</p>
                        Datum: <p>{ datum }</p>
                        Vreme: <p>{ time }</p>
                    </div>

                    <div>
                        Grad: <p>{ name }</p>
                        Temperatura: <p>{ temp } C</p> 
                        Pritisak: <p>{ pressure }</p>
                        Vlaznost vazduha: <p>{ humidity } %</p>
                    </div>
            </div>
        );
    }
}


export default API;

if (document.getElementById('vreme')) {
    ReactDOM.render(<API />, document.getElementById('vreme'));
}
