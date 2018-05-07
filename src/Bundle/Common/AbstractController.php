<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 14:38
 */

namespace Common;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class AbstractController
{
    public function verifyRequest(Request $request)
    {
        $data = new \stdClass();

        $data->content = json_decode($request->getContent());

        return $data;
    }

    public function createResponse($status, $data = [])
    {
        $response = ['status' => $status, 'data' => $data];

        return new JsonResponse($response);
    }
}