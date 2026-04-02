<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ticket;

 class Controller_tiket extends Controller
{
    public function all(){
        $tickets=Ticket::all();
        return view('/ticket',["ticket"=>$tickets]);
    }

    public function add(Request $request){

        $request->validate([
            "description"=>"required"
        ]);

        Ticket::create([
        "description"=>$request->description,
        ]);
    }

}
