let vueApi=new Vue({
    el:'.vueApi',
    data:
    {
        zone:null,
        datum:null,
        time:null,
        timeInterval:null, //nije neophodno odmah inicijalizovati
        name:null,
        temp:null,
        pressure:null,
        humidity:null,
        weatherInterval:null, //nije neophodno odmah inicijalizovati
        grad:"Europe/Belgrade/rs",
        fetTime:"Europe/Belgrade",
        fetWet:"Belgrade,rs",
    },
    methods:
    {
        pozoviTime()
        {  
            let opcije={
                "method": "GET",
            }

            fetch("http://worldtimeapi.org/api/timezone/"+this.fetTime, opcije)
            .then(rsp=>rsp.json())
            .then(response => {
                // console.log(response);
                this.zone=response.timezone;
                this.datum=pf.dateToSerbianFormat(response.datetime.substring(0,10));
                this.time=response.datetime.substring(11,16); //11,19 za sekunde
            })
            .catch(err => {
                console.log(err);
            });
        },
        continueCallTime()
        {
            let that=this;
            that.timeInterval=setInterval(that.pozoviTime,15000);
        },
        pozoviWeather()
        {
            let opcije={
                "method": "GET",
            }

            fetch("http://api.openweathermap.org/data/2.5/weather?q="+this.fetWet+"&APPID=17f779dd77988c24551bd27df2f061ae", opcije)
            .then(rsp=>rsp.json())
            .then(response => {
                // console.log(response);
                this.temp=(response.main.temp-272.15).toFixed(0);
                this.name=response.name;
                this.pressure=response.main.pressure;
                this.humidity=response.main.humidity;
            })
            .catch(err => {
                console.log(err);
            });
        },
        continiueCallWeather()
        {
            let that=this;
            that.weatherInterval=setInterval(that.pozoviWeather,30*60*1000);
        },
        setFetch()
        {
            clearInterval(this.timeInterval);
            clearInterval(this.weatherInterval);
            let nizOdSelektora=this.grad.split('/');
            this.fetTime=nizOdSelektora[0]+"/"+nizOdSelektora[1];
            this.fetWet=nizOdSelektora[1]+","+nizOdSelektora[2];
            this.pozoviTime();
            this.continueCallTime();
            this.pozoviWeather();
            this.continiueCallWeather();
        }
    },
    mounted()
    {
        this.pozoviTime();
        this.continueCallTime();
        this.pozoviWeather();
        this.continiueCallWeather();
    },
    beforeDestroy() 
    {
        clearInterval(this.timeInterval);
        clearInterval(this.weatherInterval);
    },
})