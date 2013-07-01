<?php
ini_set('display_errors', 1);
require_once( __DIR__ . '/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/


            
class twitterInterface { 
    public function __construct() {
        $settings = array(
            'oauth_access_token' => "794979-IbAoLmMW5H0VONVInzocsG1vEyzCozofT3ZeZP4ke0",
            'oauth_access_token_secret' => "8yZNzpTR7CQyeSCkyQC2envvgXVirRb6Kaz6exs3s",
            'consumer_key' => "um0vAgcBaeGx2t317GUddw",
            'consumer_secret' => "m8luqTMNoWYPp86AbrY6mxFI9gLYTcks6mAcdCV0"
        );
        
        $this->settings = $settings; 
    }
        
    public function search($query){ 
        
        $twitter = new TwitterAPIExchange($this->settings);
        $url = 'https://api.twitter.com/1.1/search/tweets.json';
        
        $getfield = '?' . http_build_query($query);
        
        $requestMethod = 'GET';    
        
        $json = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        return json_decode($json);
    }
    
    
    public function userStatuses($query){
        
        
        $twitter = new TwitterAPIExchange($this->settings);
        $url = 'https://api.twitter.com/1.1/statuses/user_timeline.json';
        
        $getfield = '?' . http_build_query($query);
        
        print_r($getfield);
        
        $requestMethod = 'GET';    
        
        $json = $twitter->setGetfield($getfield)
                     ->buildOauth($url, $requestMethod)
                     ->performRequest();
        
        return json_decode($json);
    }
}             


