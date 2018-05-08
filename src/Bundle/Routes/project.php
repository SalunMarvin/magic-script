<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 05/05/18
 * Time: 18:20
 */

$api->get(
    '/projects',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
        $projectController = $api[\Controllers\ProjectController::class];

        return $projectController->getAllProjects($request);
    });

$api->post(
    '/generate-script-and-audio',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
        $projectController = $api[\Controllers\ProjectController::class];

        return $projectController->requestScriptToVoiceBunny($request);
    });


$api->get(
    '/ping/{referenceCode}',
    function (\Symfony\Component\HttpFoundation\Request $request, $referenceCode
    ) use ($api) {
        $projectController = $api[\Controllers\ProjectController::class];

        return $projectController->ping($request, $referenceCode);
    });

$api->get(
    '/',
    function (\Symfony\Component\HttpFoundation\Request $request
    ) use ($api) {
        $projectController = $api[\Controllers\ProjectController::class];

        return $projectController->renderHTML();
    });