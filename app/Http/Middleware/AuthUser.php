<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;

class AuthUser {
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  \Closure $next
	 * @return mixed
	 */
	public function handle($request, Closure $next) {
		$constant = Config::get('constants.DEFAULT_DATA');
		if (Session::get('user_id') != '' && (Session::get('role_name') == $constant['super_admin'] || Session::get('role_name') == $constant['admin']
				|| Session::get('role_name') == $constant['teacher'] || Session::get('role_name') == $constant['dataentry'])
		) {
			return $next($request);
		} else {
			return redirect('secure/login');
		}

	}
}
