@extends('layouts.index')

@section('content')
<link rel="stylesheet" href="{{ url('/css/osobljeStyle.css') }}">

{{-- @php
    var_dump($users);
@endphp --}}
@auth
        <div class="margin_20 flexColumn">

            <div class="bolestiNaslov">
                <h1>Spisak korisnika</h1>
            </div>

            @foreach ($errors->all() as $error)
                <p class="r_error">{{ $error }}</p>
            @endforeach

            <label for="filter">
                <input type="text" id="filter" class='kartonInput' placeholder="Pretraži...">
            </label>
        </div>
@endauth

<table>
    <tr>
        <th>Ime</th>
        <th>Email</th>
        <th>Uloga</th>
        <th>Promeni</th>
        <th>Otpusti</th>
        
    </tr>

    @foreach ($users as $user)
        @if ($user->role==1)
        {!! 
            "<tr>" .
    
                "<td>" .
                    $user->name
                    . "</td>".
    
                    "<td>" .
                    $user->email
                    . "</td>".
    
                    "<td>" .
                    "Osoblje"
                    . "</td>"
                    ."<td><button class='linkDugme srednjeDugme linkIzmeni' data-link='/admin/roleChange/".$user->id."'></button></td>"

                    ."<td><button class='obrisi srednjeDugme' data-link='/admin/delete/$user->id'></button></td>"
                    
             . "</tr>";
            !!}
        @elseif ($user->role==2)
        {!! 
            "<tr>" .
    
                "<td>" .
                    $user->name
                    . "</td>".
    
                    "<td>" .
                    $user->email
                    . "</td>".
    
                    "<td>" .
                    "Lekar"
                    . "</td>"
                    ."<td><button class='linkDugme srednjeDugme linkIzmeni' data-link='/admin/roleChange/".$user->id."'></button></td>"

                    ."<td><button class='obrisi srednjeDugme' data-link='/admin/delete/$user->id'></button></td>"
                    
             . "</tr>";
            !!}
        @elseif($user->role==3)
            {!! 
                "<tr>" .
        
                    "<td>" .
                        $user->name
                        . "</td>".
        
                        "<td>" .
                        $user->email
                        . "</td>".
        
                        "<td>" .
                        "Administrator"
                        . "</td>"
        
                        ."<td></td>"
        
                        
                        ."<td></td>"
                        
                . "</tr>";
                !!}
        @else
        {!! 
            "<tr>" .
    
                "<td>" .
                    $user->name
                    . "</td>".
    
                    "<td>" .
                    $user->email
                    . "</td>".
    
                    "<td>" .
                    $user->role
                    . "</td>"
                    ."<td><button class='linkDugme srednjeDugme linkIzmeni' data-link='/admin/roleChange/".$user->id."'></button></td>"

                    ."<td><button class='obrisi srednjeDugme' data-link='/admin/delete/$user->id'></button></td>"
                    
             . "</tr>";
            !!}
        @endif
        
    @endforeach
</table>

@endsection