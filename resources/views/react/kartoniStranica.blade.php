@extends('layouts.index')

@section('content')
@csrf

{{-- <div id="showVisit" class="showVisit disapear">
        <div class="flexRowRight"><button id="disapearVisit">X</button></div>

        <div class="vueFormaVisit">
            
            <div class="donje">
                <div class="flexRow">
                    <label for="tipPosete">
                        <select name="tip_pos" id="tipPosete" v-model='tip_pos'>
                            <option value="1">Prva Poseta</option>
                            <option value="0">Kontrolna Poseta</option>
                        </select>
                    </label> 
                </div>
                
                <label for="dijagnoza">Dijagnoza <br><textarea id="dijagnoza" cols="30" rows="10" v-model='dijagnoza'></textarea></label><br>
                <label for="terapija">Terapija <br><textarea id="terapija" cols="30" rows="10" v-model='terapija'></textarea></label><br>
    
                <div class="parentUpis">
                            <div v-for='red in redovi'>
                                <unos :zadnji=red @unetoemit='uneto'></unos>
                    
                    </div>
                </div>
    
                <button class="submit" @click='submit'>Posalji u bazu</button>
            </div>
    
            <div  v-show="errors.length>0">
                <p v-for="error in errors">@{{ error }}</p>
</div>

<div v-show="odgovor!=null">@{{ odgovor }}</div>
</div>

<script src="{{ asset('/js/vueVisit2.js') }}" defer></script>

</div> --}}


<div id="kartoniStranica"></div>
<script src="/js/app.js"></script>
@endsection