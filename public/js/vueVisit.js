Vue.component('unos',
            {
                props:{
                    zadnji:
                    {
                       type:Object,
                        requred: false, 
                    } 
                },
                template:
                `
                    <div class="upis">
                        <label :for=zadnji.sbId>Sifra bolesti: <input type="text" class='sifra_bolesti' :id=zadnji.sbId :value=zadnji.sb @focus="ocistiInput"></label>
                        <label :for=zadnji.slId>Sifra leka: <input type="text" class='sifra_leka' :id=zadnji.slId :value=zadnji.sl @focus="ocistiInput"></label>
                        <label :for=zadnji.klId>Kolicina leka: <input type="number" class='kolicina_leka' :id=zadnji.klId :value=zadnji.kl @focus="ocistiInput"></label>
                        <button class="noviUnosDugme" @click='noviUnos' v-if='aktivno'>Novi unos</button>
                        <button class="obrisi" @click='obrisi' v-else='aktivno' >X</button>
                    </div>
                `,
                // `<div>{{ zadnji }}</div>`,
                data: function()
                {
                    return {
                        aktivno:true,
                    }
                },
                methods:
                {
                    noviUnos()
                    {
                        
                        this.$emit('unetoemit',{r:'novo'});
                        this.aktivno=false;
                    },
                    obrisi()
                    {
                        window.event.target.parentElement.remove();
                    },
                    ocistiInput(event)
                    {
                        event.target.value="";
                    }
                },
            })
            
            let vueForm1=new Vue(
                {
                    el:'.vueFormaVisit',
                    data:
                    {
                        niz_send:[],
                        redovi:[{sb:null,sl:null,kl:null,sbId:'sb0',slId:'sl0',klId:'kl0'}],
                        count:0,
                        dijagnoza:null,
                        terapija:null,
                        pacijent_id:document.querySelector('#pacijent').value,
                        lekar_id:document.querySelector('#lekar').value,
                        tip_pos: 1,
                        errors:[],
                        odgovor:"",
                        check_codes:false,
                        codes:{},
                    },
                    methods:{
                        uneto(r)
                        {
                            //count je koliko je tretmana uneto
                            this.count++;
                            //ono sto ovde radimo jeste da pokupimo zadnji upisani red
                            //tako da svaki novi red ima prpisano ono iz starog reda
                            let zadnji={};
                            zadnji.sb=[...document.querySelectorAll('.sifra_bolesti')].map(c=>c.value).reverse()[0];;
                            zadnji.sl=[...document.querySelectorAll('.sifra_leka')].map(c=>c.value).reverse()[0];;
                            zadnji.kl=[...document.querySelectorAll('.kolicina_leka')].map(c=>c.value).reverse()[0];;
                            zadnji.sbId='sb'+this.count;
                            zadnji.slId='sl'+this.count;
                            zadnji.klId='kl'+this.count;
                            //sledeca tri reda sluze da se zadrzi unos iz predhodnog reda, kada se upise novi red
                            //predpostavka: posto predhodni red menja dugme, vue ga rerenderuje koristeci data.redovi; posto se dalje red ne menja, 
                            //vue ga ne rerenderuje, i ostaje zapisano ono sto je korisnik izmenio, iako se to ne reflektuje u data
                            this.redovi[this.count-1].sb=zadnji.sb;
                            this.redovi[this.count-1].sl=zadnji.sl;
                            this.redovi[this.count-1].kl=zadnji.kl;
                            this.redovi.push(zadnji);                        
                        },
                        getCodes()
                        {
                            let opcije={
                                "method": "GET",
                            }
                
                            fetch("/lekar/getCodes", opcije)
                            .then(r=>r.json())
                            .then(r=>{
                                this.check_codes=true;
                                this.codes=r;
                            })
                            
                        },
                        submit()
                        {
                            //moraju da se resetuju nizovi
                            this.niz_send=[];
                            this.errors=[];
                            this.odgovor="";

                            //pravimo novi niz_send niz
                            let date=new Date();
                            let datum_posete=""+date.getFullYear()+"-"+(date.getMonth()+1)+"-"+(date.getDate());

                            let niz_sifra_bolesti=[...document.querySelectorAll('.sifra_bolesti')].map(c=>c.value);
                            let niz_sifra_leka=[...document.querySelectorAll('.sifra_leka')].map(c=>c.value);
                            let niz_kolicina_leka=[...document.querySelectorAll('.kolicina_leka')].map(c=>c.value);

                            // let niz_send=[];
                            let counter=niz_sifra_bolesti.length;

                            for(let i=0; i<counter; i++)
                            {
                                let pom={};
                                pom.datum=datum_posete;
                                pom.id_pacijent=this.pacijent_id;
                                pom.id_lekar=this.lekar_id;
                                pom.sifra_bolesti=niz_sifra_bolesti[i];
                                pom.sifra_leka=niz_sifra_leka[i];
                                pom.lek_prepisana_kol=niz_kolicina_leka[i];
                                pom.dijagnoza=this.dijagnoza;
                                pom.terapija=this.terapija;
                                pom.prva_poseta=this.tip_pos;
                                this.niz_send.push(pom);
                            }


                            this.errors=verifikuj(this.niz_send,this.check_codes,this.codes);

                            if(this.errors.length==0)
                            {
                                for(let dod of this.niz_send)
                                {
                                    let niz=
                                    {
                                        datum:dod.datum,
                                        id_pacijent:dod.id_pacijent,
                                        id_lekar:dod.id_lekar,
                                        sifra_bolesti:dod.sifra_bolesti,
                                        sifra_leka:dod.sifra_leka,
                                        lek_prepisana_kol:dod.lek_prepisana_kol,
                                        dijagnoza:dod.dijagnoza,
                                        terapija:dod.terapija,
                                        prva_poseta:dod.prva_poseta,
                                    }
                                    console.log('poslat niz', niz); 

                                    let opcije={
                                        method: "POST",
                                        body: JSON.stringify(niz),
                                        headers: {
                                            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
                                            'Content-Type': 'application/json'   //BITNO!!!
                                        }
                                    }
                                    
                                    fetch('/lekar/storeVisit',opcije)
                                        .then(resp=>resp.json())
                                        .then(txt=>{
                                            this.odgovor+=txt+" ";
                                            console.log(txt);
                                        });
                                }
                                   
                            }
                        }
                    },
                    mounted() 
                    {
                        this.getCodes();
                    },

                }
            )

            function verifikuj(niz,check,codes)
            {
                let errors=[];

                if(niz[0].datum==="" || niz[0].datum===null) errors.push('Datum nije upisan!');
                if(niz[0].id_pacijent==="" || niz[0].id_pacijent===null) errors.push('ID pacijenta nije upisan!');
                if(niz[0].id_lekar==="" || niz[0].id_lekar===null) errors.push('ID lekara nije upisan!');
                if(niz[0].dijagnoza==="" || niz[0].dijagnoza===null) errors.push('Dijagnoza nije upisana!');
                
                for(let pom of niz)
                {
                    if((pom.sifra_bolesti==="") && (pom.sifra_leka==="") && (pom.lek_prepisana_kol===""))
                    {
                  
                    }
                    else
                    {
                        if(pom.sifra_bolesti==="" || pom.sifra_bolesti===null) errors.push('Sifra bolesti nije upisana!');
                        if(pom.sifra_leka==="" || pom.sifra_leka===null) errors.push('Sifra leka nije upisana!');
                        if(pom.lek_prepisana_kola==="" || pom.lek_prepisana_kol===null) errors.push('Lek prepisana kolicina nije upisana!');
                        if(isNaN(pom.lek_prepisana_kol)) errors.push('Prepisana kolicina leka mora biti broj!');  
                        if(pom.lek_prepisana_kol<=0) errors.push('Prepisana kolicina leka mora biti veca od nule!');

                        if(check)
                        {
                            if(!codes.bolesti.some(obj=>obj.sifra_bolest===pom.sifra_bolesti)) errors.push('Sifra bolesti ne postoji u bazi!');
                            if(!codes.lekovi.some(obj=>obj.sifra_lek===pom.sifra_leka)) errors.push('Sifra leka ne postoji u bazi!');
                        }
                    }
                }

                return errors;
            }