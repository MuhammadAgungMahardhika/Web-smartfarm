<?php

namespace App\Http\Middleware;

use App\Models\Kandang;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class checkKandang
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // check pemilik
        $checkKandang = DB::table('kandang')->where('kandang.id_user', '=', Auth::user()->id)->get()->toArray();
        $result = count($checkKandang);

        if ($result > 0) {
            return $next($request);
        }
        // OR check peternak
        $checkKandang = DB::table('kandang')->where('kandang.id_peternak', '=', Auth::user()->id)->get()->toArray();
        $result2 = count($checkKandang);

        if ($result2 > 0) {
            return $next($request);
        }

        return response()->view('error/error-no-kandang');
    }
}
