<?php namespace qilara\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

    protected $except = [
        'procurement/updateItem/*',
    ];
	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
        $skip = array(
            'dashboard/procurement/updateItem/*',
            'dashboard/procurement/addItem/*',
            'dashboard/procurement/removeItem/*',
        );

        foreach ($skip as $key => $route) {
            //skip csrf check on route
            if($request->is($route)){
                //return parent::addCookieToResponse($request, $next($request));
                return $next($request);
            }
        }

        return parent::handle($request, $next);
	}

}
