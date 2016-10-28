<?php

namespace App\Http\Middleware;

class DottyTracker
{
    public function handle($request, $next)
    {
        $dottyKeys = [
            'outid',
            'partner_id',
        ];

        $dotties = [];
        foreach ($dottyKeys as $key) {
            if ($request->get($key)) {
                $dotties[$key] = $request->get($key);
            }
        }

        Context::set('dotties', $dotties);

        return $next($request);
    }
}
