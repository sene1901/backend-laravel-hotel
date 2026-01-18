<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    protected function redirectTo($request)
    {
        // API ONLY — aucune redirection vers login
        abort(401, 'Non authentifié');
    }
}
