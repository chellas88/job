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
        'en/languser',
        'en/languser/*',
        'en/admin/user/*',
        'en/service',
        'en/service/*',
        'en/getLocation',
        'en/saveDescriptions'
    ];
}
