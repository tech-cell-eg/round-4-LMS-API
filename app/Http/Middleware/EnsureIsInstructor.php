<?php

namespace App\Http\Middleware;

use App\Models\Instructor;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureIsInstructor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

      
        if (! $user || !($user instanceof Instructor)) {
        
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Access denied. You must be an instructor.',
                ], 403);
            }

            // لو الطلب من Web
            return redirect()->route('instructor.login');
        }

        return $next($request);
    }
}
