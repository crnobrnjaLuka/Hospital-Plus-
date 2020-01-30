import React, { Component } from 'react';
import Create_visit from './Create_visit';

export default class Karton_osnovni_podaci extends Component {
    constructor(props) {
        super(props);
        this.state = {
            forma: false,
            istorija_bolesti: this.props.data.istorija_bolesti,
            alergija_lek: this.props.data.alergija_lek,
            visit: false,
            odgovor: null,
        }
        this.otvoriDugme = this.otvoriDugme.bind(this);
        this.nazad = this.nazad.bind(this);
        this.otvoriFormu = this.otvoriFormu.bind(this);
        this.istorija = React.createRef();
        this.alergije = React.createRef();
        this.istorijaState = this.istorijaState.bind(this);
        this.alergijaState = this.alergijaState.bind(this);
        this.callLaravel = this.callLaravel.bind(this);
        this.sendData = this.sendData.bind(this);
        this.showNewVisit = this.showNewVisit.bind(this);
    }

    otvoriDugme() {
        let link = event.target.getAttribute('data-link');
        window.open(link);
    }

    nazad() {
        this.props.prikaziKarton();
    }

    otvoriFormu() {
        this.setState({ forma: !this.state.forma });
    }

    istorijaState() {
        this.setState({ istorija_bolesti: this.istorija.current.value });
    }

    alergijaState() {
        this.setState({ alergija_lek: this.alergije.current.value });
    }

    callLaravel() {
        this.props.callLaravel();
    }

    sendData() {
        let niz = {
            istorija_bolesti: this.state.istorija_bolesti || this.props.data.istorija_bolesti,
            alergija_lek: this.state.alergija_lek || this.props.data.alergija_lek,
            id: this.props.data.id,
            json: true, //da kazemo serveru da vrati json odgovor
        }

        let opcije = {
            method: "POST",
            body: JSON.stringify(niz),
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                'Content-Type': 'application/json'   //BITNO!!!
            }
        }

        // console.log('niz',niz,'token', document.querySelector('input[name="_token"]').value);

        fetch('/lekar/updateChart', opcije)
            .then(resp => resp.json())
            .then(txt => {
                this.setState({ odgovor: txt });
                this.otvoriFormu();
                this.callLaravel();
            });
    }

    showNewVisit() {
        this.setState({ visit: !this.state.visit });
    }

    componentDidUpdate() {
        if (this.state.visit == false) {
            this.callLaravel();
        }
    }

    render() {
        if (this.state.forma) {
            return (
                <div className="formaReact">
                    <div className="formaKont">
                        <div className="izmeniNaslovi">
                            <div className="izmeniText">
                                <label>
                                    <p>Istorija bolesti:</p>
                                </label>
                                <textarea defaultValue={this.props.data.istorija_bolesti} ref={this.istorija} onChange={this.istorijaState} />
                            </div>
                            <div className="izmeniAlergija">
                                <label>
                                    <p>Alergija lek:</p>
                                </label>
                                <textarea defaultValue={this.props.data.alergija_lek} ref={this.alergije} onChange={this.alergijaState} />
                            </div>
                        </div>
                    </div>
                    <div className="izmeniButton">
                        <p>
                            <button className='linkDugme r_karton_osnovni_podaci_dugme' onClick={this.otvoriFormu}>Odustani</button>
                            <button className='linkDugme r_karton_osnovni_podaci_dugme' onClick={this.sendData}>Sačuvaj</button>
                        </p>
                    </div>
                    <div className="margin_top_25 w100">
                        <div className="r_error">{this.state.odgovor}</div>
                    </div>

                </div>
            )
        }

        if (this.state.visit) {
            return (
                <div>
                    <Create_visit id={this.props.data.id} lekar={this.props.data.lekar}
                        callLaravel={this.callLaravel} showNewVisit={this.showNewVisit}></Create_visit>
                </div>

            )
        }

        return (
            <div className="karton">
                <div className="flexRow">
                    <div className="pacijentInfo">
                        <div className="pacijentKarton">
                            <div className="col1">
                                <div>
                                    <p className="infoId">Id Kartona:</p>
                                </div>
                                <div className="infoImeNaslov">
                                    <p className="infoIme">{this.props.data.ime} {this.props.data.prezime}</p>
                                </div>
                                <div className="pacPod">
                                    <p className="ostalo">Datum Rodjenja:</p>
                                </div>
                                <div className="pacPod">
                                    <p className="ostalo">Pol:</p>
                                </div>
                                <div className="pacPod">
                                    <p className="ostalo">Alergija na lekove:</p>
                                </div>
                            </div>
                            <div className="col2">
                                <div className="colInfo">
                                    <p className="infoId">K-{this.props.data.id}</p>
                                </div>
                                <div className="colNaslov">
                                    <p className="infoIme"></p>
                                </div>
                                <div className="colOstalo">
                                    <p className="ostalo">{pf.dateToSerbianFormat(this.props.data.dat_rodjenja)}</p>
                                </div>
                                <div className="colOstalo">
                                    <p className="ostalo">{this.props.data.pol}</p>
                                </div>
                                <div className="colOstalo">
                                    <p className="ostalo">{this.props.data.alergija_lek}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div className="istorijaBolesti">
                        <div className="istorijaBolestiLabel">
                            <p>Istorija Bolesti:</p>
                        </div>
                        <div className="opisIstorijaBox">
                            <p className="opisIstorija">{this.props.data.istorija_bolesti}</p>
                        </div>
                    </div>
                    <div className="dodaj-posetu">
                        <div className="posetaMeni">
                            <   button className='linkDugme r_karton_osnovni_podaci_dugme' onClick={this.showNewVisit}>Dodaj posetu</button>
                        </div>
                        <div className="izmeni">
                            <button className='linkDugme r_karton_osnovni_podaci_dugme' onClick={this.otvoriFormu}>Izmeni</button>
                        </div>
                        <div className="nazadKont">
                            <div className="nazad">
                                <button className='r_karton_osnovni_podaci_dugme' onClick={this.nazad}>Nazad</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div className="margin_top_25 w100">
                    <div className="r_error">{this.state.odgovor}</div>
                </div>
            </div>
        )
    }
}