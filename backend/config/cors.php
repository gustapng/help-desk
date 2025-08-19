<?php

return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout', 'register'],
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'], // Porta padrão do Vue Dev Server
    'allowed_origins_patterns' => [],
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age'           => 3600,
    'supports_credentials' => true,
];
