<?php
use App\Http\Middleware\RoleMiddleware;

return [
    'role' => RoleMiddleware::class,

    // Middleware lain bawaan Laravel
    'auth' => \App\Http\Middleware\Authenticate::class,
    // ...
];
