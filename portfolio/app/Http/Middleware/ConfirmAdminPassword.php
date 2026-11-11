<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class ConfirmAdminPassword
{
    /**
     * Requires the logged-in admin's password on every delete request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->isMethod('DELETE')) {
            $password = (string) $request->input('admin_password', '');

            if ($password === '' || ! Hash::check($password, $request->user()->password)) {
                return back()->withErrors(['admin_password' => 'Incorrect admin password. Nothing was deleted.']);
            }
        }

        return $next($request);
    }
}
