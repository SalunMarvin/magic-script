<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 05/05/18
 * Time: 18:20
 */

$api->get(
    '/generate-script-and-audio',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
    /** @var \Controllers\VoiceController $voiceController */
    $voiceController = $api[\Controllers\VoiceController::class];

    return $voiceController->requestScriptToVoiceBunny($request);
});

$api->get(
    '/ping',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
        /** @var \Controllers\VoiceController $voiceController */
        $voiceController = $api[\Controllers\VoiceController::class];

        return $voiceController->getPingFromVoiceBunny($request);
    });


$api->get(
    '/',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
        /** @var \Controllers\VoiceController $voiceController */
        $voiceController = $api[\Controllers\VoiceController::class];

        return $voiceController->renderHTML($request);
    });