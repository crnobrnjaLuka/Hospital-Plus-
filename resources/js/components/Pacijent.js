import React, { Component } from 'react';

export default class Pacijent extends Component {
    constructor(props) {
        super(props);
        this.prikaziKarton = this.prikaziKarton.bind(this);
    }

    prikaziKarton() {
        this.props.upisiIDstate(this.props.id);
    }

    render() {
        return (
            <div className="r_pacijent" onClick={this.prikaziKarton}>
                <div>K-{this.props.id} </div>
                <div>{this.props.ime} </div>
                <div>{this.props.prezime} </div>
                <div>{this.props.datumRodjenja}</div>
                <div>{this.props.lekarIme} </div>
            </div>
        );
    }
}