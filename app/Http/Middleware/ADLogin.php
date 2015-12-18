<?php namespace App\Http\Middleware;

use Closure;
use Session;
use Request;
use Redirect;

class ADLogin {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if (\Auth::user() == null) {
			return Redirect::to('/auth/login');
		}
		
		// Send them to the login screen if they don't have access
		if (\Auth::user()->access == 0) {
			return redirect()->route('noAccess');
		}
			
		return $next($request);
	}

}
