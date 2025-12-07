<?php

// Laravel が存在するなら helpers をロードしない
if (class_exists(\Illuminate\Foundation\Application::class)) {
    return;
}

// Laravel がなければ helpers をロードする（素のPHP用）
require __DIR__ . '/helpers.php';
