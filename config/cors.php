<?php

return [
    'paths' => ['api/*', 'crypto/*'], // Asegúrate de incluir los endpoints que usas
    'allowed_methods' => ['*'],
    'allowed_origins' => ['*'], // Permitir desde cualquier origen (puedes restringirlo a tu dominio)
    'allowed_origins_patterns' => [],
    'allowed_headers' => ['*'],
    'exposed_headers' => [],
    'max_age' => 0,
    'supports_credentials' => false,
];
