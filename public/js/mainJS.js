//filter tabela
        
try {
    if(document.querySelector('#filter')!=null)
    {
        document.querySelector('#filter').addEventListener('keyup',function(e)
        {
            pf.filterWordTable(document.querySelector('#filter').value.toLowerCase(),'disapear');
        })
    }
    
} catch (error) {
    console.log("filter tabela "+error);
}

//dugme za brisanje
//neophodno je ubaciti div sa klasom .prazan

try 
{
    if(document.querySelectorAll('.obrisi')!=null && document.querySelector('.prazan')!=null)
    {
        obrisiSaKarticom(); 
    }
} 
catch (error) 
{
    console.log('brisanje sa karticom '+error);
}


function obrisiSaKarticom()
{
    let butoniObrisi=[...document.querySelectorAll('.obrisi')];
    butoniObrisi.map(b=>b.addEventListener('click', function()
    {
        let link=b.getAttribute('data-link');
        obrisiPrekoLinka(link);
            
    })) 
}

function obrisiPrekoLinka(link)
{
    let div=document.createElement('div');
    div.className='kartica';
    div.innerHTML="<h3>Da li ste sigurni?</h3>";

    let div2=document.createElement('div');
    div2.className='flexRow';

    let rand=Math.floor(Math.random()*91)+10;
    div2.append('Upišite sledeci broj: ',rand);

    let div21=document.createElement('div');
    div21.className='flexRow';

    input=document.createElement('input');
    div21.append(input);

    let div3=document.createElement('div');
    div3.className='flexRow';

    let butY=document.createElement('button');
    butY.innerHTML="Da";
    butY.addEventListener('click',function(e)
    {
        if(input.value==rand)
        {
            window.open(link,'_self'); 
        }
        e.target.parentElement.parentElement.remove();
    })
    div3.appendChild(butY);

    let butN=document.createElement('button');
    butN.innerHTML="Ne";
    butN.addEventListener('click',function(e)
    {
        e.target.parentElement.parentElement.remove();
    })
    div3.appendChild(butN);

    div.append(div2,div21,div3);
    document.querySelector('.prazan').appendChild(div);
}

//dugme koje otvara link
try 
{
    if(document.querySelectorAll('.linkDugme')!=null)
    {
        let dugmici=[...document.querySelectorAll('.linkDugme')];
        dugmici.map(c=>c.addEventListener('click',function(e)
        {
            let link=e.target.getAttribute("data-link");
            console.log(link);
            window.open(link,'_self');
        }))
    }
} 
catch (error) 
{
    console.log('zakazi servis '+error);
}


//menjanje datuma u inputu
try {

    if(document.querySelector('#label1')!=null && document.querySelector('#label2')!=null && document.querySelector('#dateRodjEditChart')!=null && document.querySelector('#dateRodj2EditChart')!=null)
    {
        let dateStartLabel=document.querySelector('#label1');
        let dateStartLabel2=document.querySelector('#label2');
        let dateStartInput=document.querySelector('#dateRodjEditChart');
        let dateStartInput2=document.querySelector('#dateRodj2EditChart');

        function changeVisibilityStart()
        {
            dateStartLabel.classList.toggle('disapear');
            dateStartLabel2.classList.toggle('disapear');
        }

        //dogadjaji
        dateStartInput.addEventListener('change',function()
        {
            changeVisibilityStart();
            dateStartInput2.value=pf.dateToSerbianFormat(dateStartInput.value);
        })

        dateStartInput2.addEventListener('click',function()
        {
            changeVisibilityStart();
            dateStartInput.value="";
            dateStartInput.focus();
        })

        //dodatak, automatsko pozivanje
        changeVisibilityStart();
        dateStartInput2.value=pf.dateToSerbianFormat(dateStartInput.value);
        } 
    } 

catch (error) {
    console.log(error);
}

//pravljenje jedne posete lekaru
try {
    if(document.querySelectorAll('.openVisit')!=null)
    {
        let parent=document.querySelector('.prazan');
        let buttons=[...document.querySelectorAll('.openVisit')];
        buttons.map(c=>c.addEventListener('click',function(event)
        {
            let url=c.getAttribute('data-link');
            // console.log(url);
            fetch(url)
            .then(r=>r.json())
            .then(function(t)
            {
                console.log(t);
                let pp;
                let screen=pf.makeElement('div',{className:"screen"});
                    let detail=pf.makeElement('div',{className:"oneVisit"});
                        let div1=pf.makeElement('div',{className:"flexRowES"});
                        let datum=pf.makeElement('div',{className:"partVisit",text:'datum: '+pf.dateToSerbianFormat(t.datum)});
                        (t.prva_poseta)? pp="Prva poseta":pp="Kontrolna poseta";
                        let poseta=pf.makeElement('div',{className:"partVisit",text:pp});
                        let lekarIme=pf.makeElement('div',{className:"partVisit",text:t.id_lekar});
                        div1.append(datum,poseta,lekarIme);
                        let div2=pf.makeElement('div');
                        let naslov1=pf.makeElement('h3',{text:"Dijagnoza:"});
                        let divDijagnoza=pf.makeElement('div',{className:"partVisit dijagnoza",text:t.dijagnoza});
                        div2.append(naslov1,divDijagnoza);
                        let div3=pf.makeElement('div');
                        let naslov2=pf.makeElement('h3',{text:"Terapija:"});
                        let divTerapija=pf.makeElement('div',{className:"partVisit terapija",text:t.terapija});
                        div3.append(naslov2,divTerapija);
                        let div6=pf.makeElement('div',{className:'flexRow'});
                        let b_editVisit=pf.makeElement('button',{text:"Izmeni",className:"linkDugme"});
                        b_editVisit.addEventListener('click',function()
                        {
                            window.open('/lekar/editVisit/'+t.id_tracker,'_self');
                        });
                        div6.append(b_editVisit);
                        let div4=pf.makeElement('div');
                        for(let lek of t.lekovi)
                        {
                            let lekD=pf.makeElement('div',{className:'oneLecenje flexRowES'});
                                let bolest=pf.makeElement('div',{className:'partVisit', text:"Bolest: "+lek.name_bolest});
                                let lekIme=pf.makeElement('div',{className:'partVisit', text:"Lek: "+lek.name_lek});
                                let lekKol=pf.makeElement('div',{className:'partVisit', text:"Prepisano: "+lek.lek_prepisana_kol});

                                let div7=pf.makeElement('div',{className:"threeButtons"});

                                let b_editTreatmant=pf.makeElement('button',{className:"linkDugme maloDugme",text:"I"});
                                b_editTreatmant.addEventListener('click',function()
                                {
                                    window.open('/lekar/editTreatmant/'+lek.ind_tracer,'_self');
                                });

                                let b_createTreatmant=pf.makeElement('button',{className:"linkDugme maloDugme",text:"+"});
                                b_createTreatmant.addEventListener('click',function()
                                {
                                    window.open('/lekar/createTreatmant/'+lek.ind_tracer,'_self');
                                });

                                let b_destroyVisit=pf.makeElement('button',{className:"obrisi maloDugme",text:"X"});
                                b_destroyVisit.addEventListener('click',function()
                                {
                                    obrisiPrekoLinka('/lekar/destroyVisit/'+lek.ind_tracer);
                                });

                                div7.append(b_editTreatmant,b_createTreatmant,b_destroyVisit);

                            lekD.append(bolest,lekIme,lekKol,div7);
                            div4.append(lekD);
                        }

                        let div5=pf.makeElement('div',{className:"flexRow"});
                        let b=pf.makeElement('button',{text:'Izadji',className:'cancel'});
                        b.addEventListener('click',function(event)
                        {
                            event.target.parentElement.parentElement.parentElement.remove();
                        });
                        div5.append(b);
                    detail.append(div1,div2,div3,div6,div4,div5);
                screen.append(detail);
                parent.append(screen);
                pf.moveDiv(detail);
            })
        }))
    }
} catch (error) {
    console.log(error);
}

