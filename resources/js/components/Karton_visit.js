import React, { Component } from 'react';
import Karton_visit_treatmant from './Karton_visit_treatmant';

export default class Karton_visit extends Component {
    constructor(props) {
        super(props);
        this.state = {
            show_div: false,
            show_edit: false,
            dijagnoza: this.props.data.dijagnoza,
            terapija: this.props.data.terapija,
            odgovor: null,
        }

        this.otkrijDetalje = this.otkrijDetalje.bind(this);
        this.izmeni = this.izmeni.bind(this);
        this.dijagnozaArea = React.createRef();
        this.setDijagnoza = this.setDijagnoza.bind(this);
        this.terapijaArea = React.createRef();
        this.setTerapija = this.setTerapija.bind(this);
        this.sendData = this.sendData.bind(this);
        this.callLaravel = this.callLaravel.bind(this);

    }

    otkrijDetalje() {
        this.setState({ show_div: !this.state.show_div });
    }

    izmeni() {
        this.setState({ show_edit: !this.state.show_edit });
    }

    setDijagnoza() {
        this.setState({ dijagnoza: this.dijagnozaArea.current.value });
    }

    setTerapija() {
        this.setState({ terapija: this.terapijaArea.current.value });
    }

    callLaravel() {
        this.props.callLaravel();
    }

    // setOdgovor(txt)
    // {
    //     this.setState({odgovor:txt});
    // }

    sendData() {
        let niz = {
            prva_poseta: this.props.data.prva_poseta,
            tracers: this.props.id,
            dijagnoza: this.state.dijagnoza || this.props.data.dijagnoza,
            terapija: this.state.terapija || this.props.data.terapija,
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

        fetch('/lekar/updateVisit', opcije)
            .then(resp => resp.json())
            .then(txt => {
                this.setState({ odgovor: txt });
                this.izmeni();
                this.callLaravel();
            });
    }

    render() {
        let treatmants = this.props.data.lekovi.map(lek => <Karton_visit_treatmant key={lek.ind_tracer} id={lek.ind_tracer}
            data={lek} show_div={this.state.show_div} callLaravel={this.callLaravel} />)

        if (this.state.show_div && !this.state.show_edit) {
            return (
                <div className="r_visit_screen">

                    <div className="oneVisit">
                        <div className="flexRowRight"><button className="exit" onClick={this.otkrijDetalje}>X</button></div>

                        <div className="flexRowES">
                            <div> Datum: {pf.dateToSerbianFormat(this.props.data.datum)} </div>
                            <div> Tip: {(this.props.data.prva_poseta) ? "Prva poseta" : "Kontrolna poseta"} </div>
                            <div> Lekar: {this.props.data.id_lekar} </div>
                        </div>

                        <div className="dijagnozaBox">
                            <h4 className="r_naslov_c">Dijagnoza: </h4>
                            {this.props.data.dijagnoza}
                        </div>
                        <div className="terapijaBox">
                            <h4 className="r_naslov_c">Terapija: </h4>
                            {this.props.data.terapija}
                        </div>
                        <div className="flexRowRight"><button className="linkIzmeni" onClick={this.izmeni}></button></div>

                        {treatmants}
                        <div className="r_error">{this.state.odgovor}</div>
                    </div>

                </div>

            )
        }
        if (this.state.show_div && this.state.show_edit) {
            return (
                <div className="r_visit_screen">

                    <div className="oneVisit r_oneVisit">
                        <div className="flexRowRight"><button onClick={this.otkrijDetalje}>X</button></div>
                        <div className="flexRowES">
                            <div> Datum: {pf.dateToSerbianFormat(this.props.data.datum)} </div>
                            <div> Tip: {(this.props.data.prva_poseta) ? "Prva poseta" : "Kontrolna poseta"} </div>
                            <div> Lekar: {this.props.data.id_lekar} </div>
                        </div>

                        <div className="dijagnozaBoxKont">

                            <label>
                                <p>Dijagnoza:</p>

                                <textarea defaultValue={this.props.data.dijagnoza} ref={this.dijagnozaArea} onChange={this.setDijagnoza} />
                            </label>

                        </div>
                        <div className="terapijaBoxKont">

                            <label>
                                <p>Terapija:</p>

                                <textarea defaultValue={this.props.data.terapija} ref={this.terapijaArea} onChange={this.setTerapija} />
                            </label>

                        </div>
                        <div className="r_box_button">
                            <button onClick={this.izmeni}>Odustani</button>
                            <button onClick={this.sendData}>Sačuvaj</button>
                        </div>

                        <div className="r_error">{this.state.odgovor}</div>
                        {treatmants}
                    </div>
                </div>


            )
        }
        return (
            <div className="r_visit" onClick={this.otkrijDetalje}>
                <div className="grid_visit">
                    <div className="grid_5_50_300">
                        <div>{pf.dateToSerbianFormat(this.props.data.datum)} </div>
                        <div>{(this.props.data.prva_poseta) ? "Prva poseta" : "Kontrolna poseta"} </div>
                        <div>{this.props.data.id_lekar} </div>
                        <div className="r_naslov">{this.props.data.dijagnoza.slice(0, 32)}</div>
                        <div className="r_naslov">{this.props.data.terapija.slice(0, 32)}</div>
                    </div>
                    <div>
                        {treatmants}
                    </div>
                </div>
            </div>
        )
    }
}