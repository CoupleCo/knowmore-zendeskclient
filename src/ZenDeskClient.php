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

    public function __construct() {
        $this->domain = env('ZENDESK_DOMAIN');
//        $this->subdomain = config('zendesk.subdomain');
        $this->username = env('ZENDESK_USERNAME');
        $this->token = env('ZENDESK_TOKEN');
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