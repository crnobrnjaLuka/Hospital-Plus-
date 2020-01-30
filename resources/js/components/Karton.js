import React, { Component } from 'react';
import Karton_osnovni_podaci from './Karton_osnovni_podaci.js';
import Karton_Visit from './Karton_Visit';


export default class Karton extends Component {
    constructor(props) {
        super(props);
        this.state = {
            filter: "",
        }
        this.prikaziKarton = this.prikaziKarton.bind(this);
        this.filterKarton = React.createRef();
        this.upisiFilter = this.upisiFilter.bind(this);
        this.callLaravel = this.callLaravel.bind(this);

    }

    prikaziKarton() {
        this.props.upisiIDstate("");
    }

    upisiFilter() {
        this.setState({ filter: this.filterKarton.current.value.toLowerCase() });
    }

    callLaravel() {
        this.props.callLaravel();
    }

    render() {
        let svePosete = this.props.data.posete
            .filter(poseta => poseta.datum.toLowerCase().includes(this.state.filter) || poseta.dijagnoza.toLowerCase().includes(this.state.filter)
                || poseta.terapija.toLowerCase().includes(this.state.filter) || poseta.id_lekar.toLowerCase().includes(this.state.filter))
            .map(poseta => <Karton_Visit key={poseta.id_tracker.join(',')} id={poseta.id_tracker.join(',')} data={poseta} callLaravel={this.callLaravel} />)
        return (
            <div className="r_karton">
                {/* <button onClick={this.prikaziKarton}>Nazad</button> */}
                <Karton_osnovni_podaci data={this.props.data.osnovni} prikaziKarton={this.prikaziKarton} callLaravel={this.callLaravel} />
                <div className="flexRow">
                    <h1>Prethodne posete</h1>
                    <div className="poseteKarton">
                        <input type="text" className="kartonInput" ref={this.filterKarton} onChange={this.upisiFilter} placeholder="Pretraži..." />
                        <div className="poseteInfo">
                            <div>Datum</div>
                            <div>Tip posete</div>
                            <div>Lekar</div>
                            <div>Dijagnoza</div>
                            <div>Terapija</div>
                            <div>Ime bolesti</div>
                            <div>Lek</div>
                            <div>Kolicina</div>
                        </div>
                    </div>
                </div>
                {svePosete}
            </div>
        )
    }
}