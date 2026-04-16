<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Ticket;

 class TicketController extends Controller
{
    public function all(){
        $tickets=Ticket::all();
        return view('/ticket',["ticket"=>$tickets]);
    }

    // public function add(Request $request){

    //     $request->validate([
    //         "description"=>"required",
    //         "statu"=>"required",
    //         "date_tiket"=>"required"
    //     ]);

    //     Ticket::create([
    //     "description"=>$request->description,
    //     "statu"=>$request->statu,
    //     "date_tiket"=>$request->date_tiket,
    //     ]);      
    // }

}
