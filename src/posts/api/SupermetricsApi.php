<?php


namespace posts\api;


class SupermetricsApi implements ApiInterface {
    /**
     * @var string
     */
    protected $host;
    /**
     * @var string[]
     */
    protected $authParams;
    protected $slToken = null;
    
    function __construct(string $host, string $clientId, string $clientEmail, string $clientName) {
        $this->host = $host;
        $this->authParams = [
            'client_id' => $clientId,
            'email' => $clientEmail,
            'name' => $clientName
        ];
    }
    
    /**
     * @throws \Exception
     */
    function authenticate() {
        $response = $this->sendRequest('/assignment/register', $this->authParams);
        $this->slToken = $response['sl_token'];
    }
    
    function fetchPosts(int $page): PostsResponse {
        return $this->executeRequest(function() use ($page) {
            $path = '/assignment/posts?';
            $path .= http_build_query([
                'page' => $page,
                'sl_token' => $this->slToken
            ]);
            $response = $this->sendRequest($path);
            return new PostsResponse($response['page'], $response['posts']);
        });
    }
    
    protected function executeRequest($requestFunction) {
        try {
            return $requestFunction();
        } catch (\Exception $e) {
            $this->authenticate();
        }
        return $requestFunction();
    }
    
    /**
     * @param $path
     * @param null $data
     * @return mixed|null
     * @throws \Exception
     */
    protected function sendRequest($path, $data = null) {
        $ch = curl_init();
        $url = $this->host . $path;
    
        curl_setopt($ch, CURLOPT_URL, $url);
        if ($data) {
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
        $response = json_decode(curl_exec($ch), true);
        $requestInfo = curl_getinfo($ch);
    
        curl_close ($ch);
        
        if ($requestInfo['http_code'] >= 400) {
            $error = $response['error']['description']
                ?? $response['error']['message']
                ?? 'Something went wrong with request: '. $url;
            throw new \Exception($error, $requestInfo['http_code']);
        }
        
        if ($response) {
            return $response['data'];
        }
        
        return null;
    }
}