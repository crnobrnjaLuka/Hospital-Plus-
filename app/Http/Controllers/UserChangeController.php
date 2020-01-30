<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\UserModel;

class UserChangeController extends Controller
{
    //
    //vraca stranicu na kojoj svaki user moze da menja svoje podatke
    public function changeUser()
    {
        return view('auth.changeUser');
    }

    //izmena podataka od strane usera
    public function madeChangeUser(Request $request)
    {
        $request->validate([
            'id'=>'required',
            'name'=>'required',
            'email'=>'required',
        ]);

        $id=$request->id;
        $id_user=auth()->user()->id;
        if($id==$id_user)
        {
            $user=UserModel::findOrFail($id);

            $user->name=$request->name;
            $user->email=$request->email;

            $user->saveOrFail(); 
            return redirect('/home');
        }
        else
        {
            return back()->withErrors(['To niste vi!',$id,$id_user]);
        }
        
        
    }
}
