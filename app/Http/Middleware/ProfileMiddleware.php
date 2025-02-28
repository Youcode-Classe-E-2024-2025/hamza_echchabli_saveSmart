<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ProfileMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();
        $profileId = $request->route('id'); // Get the ID from the route

        // Ensure user is authenticated and trying to access their own profile
        if (!$user || $user->id != $profileId) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
