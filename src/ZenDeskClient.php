<?php

namespace NomorePackage\Zendeskclient;

//use App\Classes\User\Notifications\Slack;
use Exception;
use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Psr7\Response as GuzzleResponse;

class ZenDeskClient {
    private $domain;
    private $username;
    private $token;
    private $guzzle;

    /**
     * ZenDeskClient constructor.
     * @param bool $use_domain
     */
    public function __construct($use_domain = true) {

        $zendesk_test_status = env('ZENDESK_TEST_STATUS');

        if(!is_null($zendesk_test_status) && env('ZENDESK_TEST_STATUS') == 'on'){

            if($use_domain) $this->domain = env('ZENDESK_TEST_DOMAIN');
            else $this->domain = '';

            $this->username = env('ZENDESK_TEST_USERNAME');
            $this->token = env('ZENDESK_TEST_TOKEN');
        }else{
            if($use_domain) $this->domain = env('ZENDESK_DOMAIN');
            else $this->domain = '';

            $this->username = env('ZENDESK_USERNAME');
            $this->token = env('ZENDESK_TOKEN');
        }

        $this->guzzle = new Guzzle;
    }



    public function request($method, $endpoint, $content = []) {
        try {

            $url = $this->domain . $endpoint;
            $response = $this->guzzle->request(
                $method,
                $url,
                [
                    'json' => $content,
                    'auth' => [$this->username . '/token', $this->token],
                ]
            );

//            $this->logRateLimit($response->getHeaders());

            return $this->createResponse($response);

        } catch (Exception $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

    }

    protected function createResponse(GuzzleResponse $response) {
        return (array)json_decode($response->getBody()->__toString());
    }



//    protected function logRateLimit($headers) {
//
//
//        $rate_limit = $headers['X-Rate-Limit-Remaining'][0];
//
//        if(isset($headers['Retry-After'])) Slack::freshdeskRateLimitReset();
//
//        if(intval($rate_limit) < 10){
//            Slack::freshdeskRateLog(intval($rate_limit));
//        }
//    }

}