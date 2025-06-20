<?php

namespace App\Http\Controllers;

use App\Models\Log;

class LogController extends Controller
{
    public static function createLog($userId, $domain, $context)
    {
        Log::create([
            'user_id' => $userId,
            'domaine' => $domain,
            'context' => $context,
        ]);
    }

    public function index()
    {
        return view('logs.index', ['logs' => Log::latest()->paginate(10)]);
    }
}
