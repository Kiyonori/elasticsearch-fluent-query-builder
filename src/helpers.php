<?php

(function () {
    if (function_exists('app')) {
        return;
    }

    function app(
        string $className,
        ...$parameters,
    ) {
        return new $className(...$parameters);
    }
})();

(function () {
    if (function_exists('config')) {
        return;
    }

    function config(
        string $key,
        mixed $default = null,
    ) {
        $keys           = explode('.', $key);
        $configFilePath = __DIR__ . "/../config/$keys[0]" . '.php';

        if ( ! file_exists($configFilePath)) {
            return $default;
        }

        $configFileContent = require $configFilePath;

        array_shift($keys);

        foreach ($keys as $segment) {
            if ( ! is_array($configFileContent)) {
                return $default;
            }

            if ( ! array_key_exists($segment, $configFileContent)) {
                return $default;
            }

            $configFileContent = $configFileContent[$segment];
        }

        return $configFileContent;
    }
})();
