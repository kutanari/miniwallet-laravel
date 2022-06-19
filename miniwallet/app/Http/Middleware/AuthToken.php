<?php

namespace App\Http\Middleware;

use App\Models\Account;
use Closure;
use Illuminate\Http\Request;

class AuthToken
{
    const TOKEN_HEADER_PREFIX = 'Token';
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('Authorization');
        if (! $token) {
            return response()->json([
                'message' => 'Missing Authorization header',
                'status' => 'fail',
            ], 401);
        }

        preg_match(sprintf('/^%s (.*)$/', self::TOKEN_HEADER_PREFIX), $token, $matches);
        $token_hash = $matches[1] ?? null;
        $account = Account::where('token', $token_hash)->first();
        if (! $account) {
            return response()->json([
                'message' => 'Invalid token',
                'status' => 'fail',
            ], 401);
        }

        return $next($request);
    }
}
