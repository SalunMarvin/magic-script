<?php
/**
 * Created by PhpStorm.
 * User: marvin
 * Date: 06/05/18
 * Time: 14:36
 */

namespace Controllers;

use Common\AbstractController;
use Unirest;

/**
 * Class ScriptController
 * @package Controllers
 */
class ScriptController extends AbstractController
{
    /**
     * @param $data
     * @return array
     */
    public function buildScriptStructure($data)
    {
        /**
         * Number of quotes that should be concat into one script
         */
        $numberOfQuotes = $data->numberOfQuotes;

        /**
         * Create Script Structure with Title and Script lines
         */
        $scriptStructure = array(
            'title' => 'Movie Quotes Script',
            'script' => ''
        );

        /**
         * Request Mashape API to get quotes
         */
        for ($count = 1; $count <= $numberOfQuotes; $count++) {
            $quote = $scriptStructure['script'] . $this->loadScriptQuotes() . ' ';
            $scriptStructure['script'] = $quote;
        }

        return $scriptStructure;
    }


    /**
     * @return mixed
     */
    public function loadScriptQuotes()
    {
        /**
         * Request Headers to Mashape Quotes API
         */
        $headers = array(
            'Accept' => 'application/json',
            'X-Mashape-Key' => 'NRl1vcxAGzmshCaMdRVE32vhPssxp1PsuIyjsnsGYnBqXeDHEY'
        );

        /**
         * Request URL params to Mashape Quotes API
         */
        $parameters = array(
            'cat' => 'movies',
            'count' => 1
        );

        /**
         * Get quotes from Mashape Quotes API
         */
        $response = Unirest\Request::get(
            'https://andruxnet-random-famous-quotes.p.mashape.com',
            $headers,
            $parameters
        );

        /**
         * Return only the quote
         */
        return $response->body->quote;
    }
}