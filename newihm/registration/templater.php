<?php

require_once 'vendor/autoload.php';

class PHP_Engine {
    public function render($template, $arguments) {
        extract($arguments);
        ob_start();

        include "views/{$template}.html";

        $result = ob_get_contents();
        ob_end_clean();

        return $result;
    }
}

function templater() {
    return new PHP_Engine();
}