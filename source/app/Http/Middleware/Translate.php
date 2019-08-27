<?php

namespace App\Http\Middleware;

use Closure, JavaScript, App, File;

class Translate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        JavaScript::put([
            'translations' => $this->translations()
        ]);

        return $next($request);
    }

    /**
     * Get the translations.
     *
     * @return \Illuminate\Support\Collection
     */
    protected function translations()
    {
        $files = File::files(resource_path('lang/' . App::getLocale()));

        return collect($files)->flatMap(function ($file) {
            return [
                ($translation = $file->getBasename('.php')) => trans($translation),
            ];
        });
    }
}
