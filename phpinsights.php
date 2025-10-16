<?php

declare(strict_types=1);

use PhpCsFixer\Fixer\Operator\BinaryOperatorSpacesFixer;

return [
    'preset' => 'default',

    'remove' => [
        BinaryOperatorSpacesFixer::class,
    ],

    'requirements' => [
        'min-quality' => 85,
        'min-complexity' => 90,
        'min-architecture' => 85,
        'min-style' => 90,
        'disable-security-check' => false,
    ],
];
