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
use Normalizers\ProjectNormalizer;
use Persist\ProjectPersist;
use Retrieve\ProjectRetrieve;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Unirest;

/**
 * Class VoiceController
 * @package Controllers
 */
class ProjectController extends AbstractController
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
     * @var ProjectNormalizer
     */
    private $projectNormalizer;

    /**
     * ProjectController constructor.
     * @param ScriptController $scriptController
     * @param ProjectPersist $projectPersist
     * @param ProjectRetrieve $projectRetrieve
     * @param ProjectNormalizer $projectNormalizer
     */
    public function __construct(
        ScriptController $scriptController,
        ProjectPersist $projectPersist,
        ProjectRetrieve $projectRetrieve,
        ProjectNormalizer $projectNormalizer
    ) {
        $this->scriptController = $scriptController;
        $this->projectPersist = $projectPersist;
        $this->projectRetrieve = $projectRetrieve;
        $this->projectNormalizer = $projectNormalizer;
    }

    /**
     * @param $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function getAllProjects($request) {
        $this->verifyRequest($request);

        $projects = $this->projectRetrieve->retrieveAll();

        $normalizedProjects = $this->projectNormalizer->normalizeCollection($projects);

        return $this->createResponse('success', $normalizedProjects);
    }


    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws Unirest\Exception
     * @throws \Doctrine\ORM\ORMException
     */
    public function requestScriptToVoiceBunny(Request $request)
    {
        /**
         * Verify POST data and decode it to JSON
         */
        $data = $this->verifyRequest($request);

        /**
         * Will call the Script Controller to generate a new Script
         */
        $script = $this->scriptController->buildScriptStructure($data->content);

        /** @var Project $project */
        $project = new Project();

        /**
         * Set a Unique ID to the Project
         */
        $referenceCode = uniqid('', true);
        $project->setReferenceCode($referenceCode);

        /**
         * Will call the request to the VoiceBunny API
         */
        $voiceReturn = $this->makeRequest($script, $data->content, $referenceCode);

        /**
         * Creates new Project in Database
         */
        $project->setTitle($script['title']);
        $project->setScript($script['script']);
        $project->setVoiceBunnyId(($voiceReturn->body->project->id));
        $project->setReadDefault($voiceReturn->body->project->reads[0]->urls->part001->default);
        $project->setReadOriginal($voiceReturn->body->project->reads[0]->urls->part001->original);
        $project->setAudioIsReady($voiceReturn->body->project->reads[0]->status);

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
    public function makeRequest($script, $data, $referenceCode) {
        /**
         * Required data to request Voice Bunny's API
         */
        $voicebunnyUser = $data->voicebunnyUser;
        $voicebunnyToken = $data->voicebunnyToken;

        $headers = array(
            'Content-Type' => 'application/json',
        );

        $pingUrl = 'https://magic-script.herokuapp.com/ping/' . $referenceCode;

        $arguments = array(
            'title' => $script['title'],
            'script' => $script['script'],
            'test' => $data->test,
            'ping' => $pingUrl
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
     * @param $request
     * @param $referenceCode
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     * @throws \Doctrine\ORM\ORMException
     */
    public function ping($request, $referenceCode) {
        /** @var Project $project */
        $project = $this->projectRetrieve->retrieveByReferenceCode($referenceCode);

        /**
         * When VoiceBunny pings this Project it will update with audio ready
         */
        $project->setAudioIsReady('ready');

        $project = $this->projectPersist->process($project);

        return $this->createResponse('sucess', $project);
    }

    /**
     * @return Response
     */
    public function renderHTML() {
        /** @var Project $project */
        $project = $this->projectRetrieve->retrieveLast();

        $script = $project->getScript();
        $audio = $project->getReadDefault();
        $isReady = '<b>Audio not ready yet!</b>';

        if ($project->getAudioIsReady() === 'ready') {
            $isReady = '<audio controls>
                            <source src='. $audio .' type="audio/mpeg">
                        </audio>';
        }

        /**
         * Render simply HTML to show Script and Audio
         */
        return new Response(
            '<html>
                        <body><h1>Magic Script</h1>
                            <div>
                            <b>Script: '. $script . '</b>
                            </div>
                            <div>'
                            . $isReady .
                            '</div>
                        </body>
                    </html>'
        );
    }
}