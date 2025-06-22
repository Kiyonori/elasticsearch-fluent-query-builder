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
