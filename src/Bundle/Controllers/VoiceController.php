<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 17:26
 */

namespace Controllers;

use Common\AbstractController;
use Entity\Project;
use Persist\ProjectPersist;
use Symfony\Component\HttpFoundation\Request;
use Unirest;

/**
 * Class VoiceController
 * @package Controllers
 */
class VoiceController extends AbstractController
{
    /**
     * @var ScriptController
     */
    private $scriptController;

    /**
     * @var ProjectPersist
     */
    private $projectPersist;

    /**
     * VoiceController constructor.
     * @param ScriptController $scriptController
     * @param ProjectPersist $projectPersist
     */
    public function __construct(
        ScriptController $scriptController,
        ProjectPersist $projectPersist
    ) {
        $this->scriptController = $scriptController;
        $this->projectPersist = $projectPersist;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function requestScriptToVoiceBunny(Request $request)
    {
        /**
         * Will call the Script Controller to generate a new Script
         */
        $script = $this->scriptController->buildScriptStructure();

        /**
         * Will call the request to the VoiceBunny API
         */
        $voiceReturn = $this->makeRequest($script);

        /** @var Project $project */
        $project = new Project();

        /**
         * Creates new Project in Database
         */
        $project->setTitle($script['title']);
        $project->setScript($script['script']);
        $project->setVoiceBunnyId(($voiceReturn->body->project->id));

        $this->projectPersist->process($project);

        /**
         * Create API response
         */
        return $this->createResponse('success', $voiceReturn->body->project);
    }


    /**
     * @param $script
     * @return Unirest\Response
     * @throws Unirest\Exception
     */
    public function makeRequest($script) {
        /**
         * Required data to request Voice Bunny's API
         */
        $voicebunnyUser = '131901';
        $voicebunnyToken = 'ccf481787204842808cea84fa3193e87';

        $headers = array(
            'Content-Type' => 'application/json',
        );

        $arguments = array(
            'title' => $script['title'],
            'script' => $script['script'],
            'test' => 1
        );

        $body = Unirest\Request\Body::Json($arguments);

        $response = Unirest\Request::post(
            'https://api.voicebunny.com/projects/addSpeedy',
            $headers,
            $body,
            $voicebunnyUser,
            $voicebunnyToken
        );

        return $response;
    }
}