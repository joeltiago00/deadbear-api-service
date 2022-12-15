<?php
/*
    Is necessary register on composer.json in "files" inside autoload area,
    and after that run composer dump-autoload to register the new files of functions.

    To call function only call for your name, example 'exampleHelper()'.
 */
if (!function_exists('exampleHelper')) {
    function exampleHelper(): void
    {
        //Do something...
        dd('helper ok');
    }
}
