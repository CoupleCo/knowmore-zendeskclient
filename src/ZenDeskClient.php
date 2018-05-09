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


        $zendesk_test_status = config('zendesk.test.status');

        if(!is_null($zendesk_test_status) && $zendesk_test_status == 'on'){

            if($use_domain) $this->domain = config('zendesk.test.domain');
            else $this->domain = '';

            $this->username = config('zendesk.test.username');
            $this->token = config('zendesk.test.token');
        }else{

            if($use_domain) $this->domain = config('zendesk.live.domain');
            else $this->domain = '';

            $this->username = config('zendesk.live.username');
            $this->token = config('zendesk.live.token');
        }

        $this->guzzle = new Guzzle;
    }

    /**
     * @param       $method
     * @param       $endpoint
     * @param array $content
     * @return array
     */
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