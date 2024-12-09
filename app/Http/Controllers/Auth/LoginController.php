<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class LoginController extends Controller
{

    protected function authenticated(Request $request, $user)
    {
        // Check if the user has the 'employee' role
        if ($user->role === 'employee') {
            return redirect('/employee/profile/' . $user->employee_id);
        }

        // Default redirect for other roles
        return redirect('/home');
    }
}
