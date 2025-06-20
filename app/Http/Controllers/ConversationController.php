<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ConversationController extends Controller
{
    public function Overview()
    {
        return view("chat.overview");
    }

    public function ConversationProToClient(){
        return view("chat.pro_chat");
    }
}
