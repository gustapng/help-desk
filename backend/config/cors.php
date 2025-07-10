<?php
// backend/config/cors.phpp
return [

    'paths' => ['api/*', 'sanctum/csrf-cookie', 'login', 'logout'],
    'allowed_origins' => ['http://localhost:5173', 'http://127.0.0.1:5173'], // Porta padrão do Vue Dev Server
    'allowed_methods' => ['*'],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => true, // ESSENCIAL para autenticação com Sanctum e cookies

];
