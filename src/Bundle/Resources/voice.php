<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 14:33
 */

$api[\Controllers\VoiceController::class] = function ($api) {
    return new \Controllers\VoiceController(
        $api[\Controllers\ScriptController::class],
        $api[\Persist\ProjectPersist::class],
        $api[\Retrieve\ProjectRetrieve::class]
    );
};