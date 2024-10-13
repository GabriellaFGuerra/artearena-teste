<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function searchUsers(Request $request)
    {
        $query = $request->get('query', '');
        $users = User::where('name', 'like', '%' . $query . '%')->get();
        return response()->json($users);
    }
}
