<?php

return [
    'permissions' => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ],

    'modules' => [
        'dashboard' => ['c', 'r', 'u', 'd'],
        'category' => ['c', 'r', 'u', 'd'],
        'product' => ['c', 'r', 'u', 'd'],
        'customer' => ['c', 'r', 'u', 'd'],
        'staff' => ['c', 'r', 'u', 'd'],
        'role' => ['c', 'r', 'u', 'd'],
        'module' => ['c', 'r', 'u', 'd'],
        'setting' => ['u'],
    ],
];
