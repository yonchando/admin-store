<?php

return [
    'permissions' => [
        'r' => 'read',
        'c' => 'create',
        'u' => 'update',
        'd' => 'delete',
    ],

    'modules' => [
        'category' => ['c', 'r', 'u', 'd'],
        'product' => ['c', 'r', 'u', 'd'],
        'customer' => ['c', 'r', 'u', 'd'],
        'staff' => ['c', 'r', 'u', 'd'],
        'role' => ['c', 'r', 'u', 'd'],
        'module' => ['c', 'r', 'u', 'd'],
        'setting' => ['u'],
    ],
];
