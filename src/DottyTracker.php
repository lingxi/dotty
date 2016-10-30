<?php

namespace Lingxi\Dotty;

use Lingxi\Context\Context;

class DottyTracker
{
    public function handle($request, $next)
    {
        $dottyKeys = config('dotty.keys', []);

        $dotties = [];
        foreach ($dottyKeys as $key) {
            if ($request->get($key)) {
                $dotties[$key] = $request->get($key);
            }
        }

        $context = Context::create();
        $context->set('dotties', $dotties);

        return $next($request);
    }
}
