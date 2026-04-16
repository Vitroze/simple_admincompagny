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

}
