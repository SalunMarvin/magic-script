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
use Retrieve\ProjectRetrieve;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
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
     * @var ProjectRetrieve
     */
    private $projectRetrieve;

    /**
     * VoiceController constructor.
     * @param ScriptController $scriptController
     * @param ProjectPersist $projectPersist
     * @param ProjectRetrieve $projectRetrieve
     */
    public function __construct(
        ScriptController $scriptController,
        ProjectPersist $projectPersist,
        ProjectRetrieve $projectRetrieve
    ) {
        $this->scriptController = $scriptController;
        $this->projectPersist = $projectPersist;
        $this->projectRetrieve = $projectRetrieve;
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
        $project->setReadDefault($voiceReturn->body->project->reads[0]->urls->part001->default);
        $project->setReadOriginal($voiceReturn->body->project->reads[0]->urls->part001->original);

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
            'test' => 1,
            'ping' => 'https://magic-script.herokuapp.com/ping'
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

    /**
     * @param Request $request
     * @throws \Doctrine\ORM\ORMException
     */
    public function getPingByVoiceBunny(Request $request) {
        /** @var Project $project */
        $project = $this->projectRetrieve->retrieveLast();

        $project->setTitle($request);

        $this->projectPersist->process($project);

        return $this->createResponse('success', []);
    }

    /**
     * @return Response
     */
    public function renderHTML() {
        /** @var Project $project */
        $project = $this->projectRetrieve->retrieveLast();

        $script = $project->getTitle();
        /**
         * Render simply HTML to show Script and Audio
         */
        return new Response(
            '<html>
                        <body><h1>Magic Script</h1>
                            <div>
                            <b>Script: '. $script . '</b>
                            </div>
                        </body>
                    </html>'
        );
    }
}