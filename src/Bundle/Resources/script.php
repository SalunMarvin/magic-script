<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 14:33
 */

$api[\Controllers\ScriptController::class] = function ($api) {
    return new \Controllers\ScriptController(
    );
};