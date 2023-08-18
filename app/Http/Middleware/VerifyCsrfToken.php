<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as Middleware;

class VerifyCsrfToken extends Middleware
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array<int, string>
     */
    protected $except = [
        //
    ];



// app/Http/Middleware/VerifyCsrfToken.php

protected function addCookieToResponse($request, $response)
{
    $response = parent::addCookieToResponse($request, $response);

    return tap($response, function ($response) {
        session()->regenerate();
    });
}

}
