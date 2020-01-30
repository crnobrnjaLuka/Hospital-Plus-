import React, { Component } from 'react';
import Create_visit_treatmant from './Create_visit_treatmant';
import Error from './Error';


export default class Create_visit extends Component {
    constructor(props) {
        super(props);
        this.state = {
            count: 0,
            last_input:
            {
                sb: null,
                sl: null,
                kl: 0,
            },
            check: null,
            check_codes: false,
            errors: [],
            odgovor: null,
        }

        this.callLarvel = this.callLarvel.bind(this);
        this.increaseCount = this.increaseCount.bind(this);
        this.submit = this.submit.bind(this);
        this.getCodes = this.getCodes.bind(this);
        this.showNewVisit = this.showNewVisit.bind(this);
        this.zadnjiUpis = this.zadnjiUpis.bind(this);
    }

    callLarvel() {
        this.props.callLarvel();
    }

    increaseCount() {
        console.log('povecaj1');
        let c = this.state.count;
        c++;
        this.setState({ count: c });
    }

    showNewVisit() {
        this.props.showNewVisit();
    }

    submit() {
        this.pacijent_id = this.props.id;
        this.lekar_id = this.props.lekar;
        //moraju da se resetuju nizovi
        this.niz_send = [];
        this.errors = [];
        this.odgovor = "";

        //pravimo novi niz_send niz
        this.dijagnoza = document.querySelector('#r_dijagnoza').value;
        this.terapija = document.querySelector('#r_terapija').value;
        this.tip_pos = document.querySelector('#r_tipPosete').value;


        let date = new Date();
        let datum_posete = "" + date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + (date.getDate());

        let niz_sifra_bolesti = [...document.querySelectorAll('.r_sifra_bolesti')].map(c => c.value);
        let niz_sifra_leka = [...document.querySelectorAll('.r_sifra_leka')].map(c => c.value);
        let niz_kolicina_leka = [...document.querySelectorAll('.r_kolicina_leka')].map(c => c.value);

        let counter = niz_sifra_bolesti.length;

        for (let i = 0; i < counter; i++) {
            let pom = {};
            pom.datum = datum_posete;
            pom.id_pacijent = this.pacijent_id;
            pom.id_lekar = this.lekar_id;
            pom.sifra_bolesti = niz_sifra_bolesti[i];
            pom.sifra_leka = niz_sifra_leka[i];
            pom.lek_prepisana_kol = niz_kolicina_leka[i];
            pom.dijagnoza = this.dijagnoza;
            pom.terapija = this.terapija;
            pom.prva_poseta = this.tip_pos;
            this.niz_send.push(pom);
        }


        this.errors = this.verifikuj(this.niz_send, this.state.check_codes, this.state.codes);
        console.log('errors', this.errors);
        this.setState({ errors: this.errors });

        if (this.errors.length == 0) {
            for (let dod of this.niz_send) {
                let niz =
                {
                    datum: dod.datum,
                    id_pacijent: dod.id_pacijent,
                    id_lekar: dod.id_lekar,
                    sifra_bolesti: dod.sifra_bolesti,
                    sifra_leka: dod.sifra_leka,
                    lek_prepisana_kol: dod.lek_prepisana_kol,
                    dijagnoza: dod.dijagnoza,
                    terapija: dod.terapija,
                    prva_poseta: dod.prva_poseta,
                }
                console.log('poslat niz', niz);

                let opcije = {
                    method: "POST",
                    body: JSON.stringify(niz),
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                        'Content-Type': 'application/json'   //BITNO!!!
                    }
                }

                fetch('/lekar/storeVisit', opcije)
                    .then(resp => resp.json())
                    .then(txt => {
                        this.odgovor += txt + " ";
                        console.log(this.odgovor);
                        this.setState({ odgovor: this.odgovor });
                    });
            }

        }
    }

    render() {
        let treatments = [];
        for (let i = 0; i <= this.state.count; i++) {
            treatments.push(<Create_visit_treatmant key={i} increaseCount={this.increaseCount} zadnjiUpis={this.zadnjiUpis}
                sb={this.state.last_input.sb} sl={this.state.last_input.sl} kl={this.state.last_input.kl}></Create_visit_treatmant>);
        }

        let errorsPr = this.state.errors.map((e, i) => <Error error={e} key={'error' + i}></Error>)

        return (
            <div className="r_visit_screen">
                <div className="r_visit_form">
                    <div className="flexRowRight">
                        <button onClick={this.showNewVisit}>X</button>
                    </div>

                    <div className="vueFormaVisit">
                        <div className="donje">
                            <div className="poljaKont">
                                <div className="naziviPolja">
                                    <div className="posetaKont">
                                        <label>Tip posete:</label>
                                    </div>
                                    <div className="textBoxNaziv">
                                        <label>Dijagnoza:</label>
                                    </div>
                                    <div className="textBoxNaziv">
                                        <label>Terapija:</label>
                                    </div>
                                </div>
                                <div className="inputPolja">
                                    <div className="selectKont">
                                        <select id="r_tipPosete">
                                            <option value="1">Prva Poseta</option>
                                            <option value="0">Kontrolna Poseta</option>
                                        </select>
                                    </div>
                                    <div className="textBox">
                                        <textarea id="r_dijagnoza" cols="30" rows="10" ></textarea>
                                    </div>
                                    <div className="textBox">
                                        <textarea id="r_terapija" cols="30" rows="10" ></textarea>
                                    </div>
                                </div>
                            </div>
                            <div className="upisKont">
                                <div className="parentUpis">
                                    {treatments}
                                </div>
                            </div>
                            <div className="sacuvajKont">
                                <button className="submit srednjeDugme" onClick={this.submit}></button>
                            </div>
                            {/* <div className="flexRow">
                                <label>
                                    <select id="r_tipPosete">
                                        <option value="1">Prva Poseta</option>
                                        <option value="0">Kontrolna Poseta</option>
                                    </select>
                                </label>
                            </div>

                            <label >
                                <p>Dijagnoza:</p>
                                <textarea id="r_dijagnoza" cols="30" rows="10" ></textarea>
                            </label>

                            <label >
                                <p>Terapija:</p>
                                <textarea id="r_terapija" cols="30" rows="10" ></textarea>
                            </label>

                            <div className="parentUpis">
                                {treatments}
                            </div>

                            <button className="submit srednjeDugme" onClick={this.submit}>Posalji u bazu</button> */}
                        </div>

                    </div>
                    <div>{errorsPr}</div>
                    <div className='flexRow r_error'>{this.state.odgovor}</div>

                </div>
            </div>

        )
    }


    verifikuj(niz, check, codes) {
        let errors = [];

        if (niz[0].datum === "" || niz[0].datum === null) errors.push('Datum nije upisan!');
        if (niz[0].id_pacijent === "" || niz[0].id_pacijent === null) errors.push('ID pacijenta nije upisan!');
        if (niz[0].id_lekar === "" || niz[0].id_lekar === null) errors.push('ID lekara nije upisan!');
        if (niz[0].dijagnoza === "" || niz[0].dijagnoza === null) errors.push('Dijagnoza nije upisana!');

        for (let pom of niz) {
            if ((pom.sifra_bolesti === "") && (pom.sifra_leka === "") && (pom.lek_prepisana_kol === "")) {

            }
            else {
                if (pom.sifra_bolesti === "" || pom.sifra_bolesti === null) errors.push('Sifra bolesti nije upisana!');
                if (pom.sifra_leka === "" || pom.sifra_leka === null) errors.push('Sifra leka nije upisana!');
                if (pom.lek_prepisana_kola === "" || pom.lek_prepisana_kol === null) errors.push('Lek prepisana kolicina nije upisana!');
                if (isNaN(pom.lek_prepisana_kol)) errors.push('Prepisana kolicina leka mora biti broj!');
                if (pom.lek_prepisana_kol <= 0) errors.push('Prepisana kolicina leka mora biti veca od nule!');

                if (check) {
                    if (!codes.bolesti.some(obj => obj.sifra_bolest === pom.sifra_bolesti)) errors.push('Sifra bolesti ne postoji u bazi!');
                    if (!codes.lekovi.some(obj => obj.sifra_lek === pom.sifra_leka)) errors.push('Sifra leka ne postoji u bazi!');
                }
            }
        }

        return errors;
    }

    getCodes() {
        fetch("/lekar/getCodes")
            .then(r => r.json())
            .then(r => {
                this.setState(
                    {
                        check_codes: true,
                        codes: r,
                    }
                );
            })
    }

    componentDidMount() {
        this.getCodes();
    }

    zadnjiUpis() {
        let sb = [...document.querySelectorAll('.r_sifra_bolesti')].map(c => c.value).reverse()[0];
        let sl = [...document.querySelectorAll('.r_sifra_leka')].map(c => c.value).reverse()[0];
        let kl = [...document.querySelectorAll('.r_kolicina_leka')].map(c => c.value).reverse()[0];

        this.setState({
            last_input:
            {
                sb: sb,
                sl: sl,
                kl: kl,
            }
        });
    }
}