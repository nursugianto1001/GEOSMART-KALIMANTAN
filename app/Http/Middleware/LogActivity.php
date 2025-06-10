<?php
// app/Http/Middleware/LogActivity.php

namespace App\Http\Middleware;

use App\Models\ActivityLog;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class LogActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (Auth::check() && in_array($request->method(), ['POST', 'PUT', 'PATCH', 'DELETE'])) {
            try {
                ActivityLog::create([
                    'user_id' => Auth::id(),
                    'action' => $this->getActionFromRoute($request),
                    'model_type' => $this->getModelFromRoute($request),
                    'model_id' => $this->getModelId($request),
                    'new_values' => $request->except(['password', 'password_confirmation', '_token', '_method']),
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'created_at' => now(),
                ]);
            } catch (\Exception $e) {
                \Log::error('Failed to log activity: ' . $e->getMessage());
            }
        }

        return $response;
    }

    private function getActionFromRoute(Request $request): string
    {
        $routeName = $request->route()?->getName() ?? '';
        $method = $request->method();
        
        if (str_contains($routeName, '.store') || $method === 'POST') return 'create';
        if (str_contains($routeName, '.update') || in_array($method, ['PUT', 'PATCH'])) return 'update';
        if (str_contains($routeName, '.destroy') || $method === 'DELETE') return 'delete';
        
        return strtolower($method);
    }

    private function getModelFromRoute(Request $request): string
    {
        $routeName = $request->route()?->getName() ?? '';
        
        if (str_contains($routeName, 'users')) return 'User';
        if (str_contains($routeName, 'surveys') || str_contains($routeName, 'families')) return 'PoorFamily';
        if (str_contains($routeName, 'profile')) return 'Profile';
        
        return 'Unknown';
    }

    private function getModelId(Request $request): int
    {
        $route = $request->route();
        if ($route) {
            $parameters = $route->parameters();
            
            foreach ($parameters as $key => $value) {
                if (is_numeric($value)) {
                    return (int) $value;
                }
                if (is_object($value) && method_exists($value, 'getKey')) {
                    return $value->getKey();
                }
            }
        }
        
        return 0;
    }
}
