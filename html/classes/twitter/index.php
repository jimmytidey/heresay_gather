<?php
ini_set('display_errors', 1);
require_once( __DIR__ . '/TwitterAPIExchange.php');

/** Set access tokens here - see: https://dev.twitter.com/apps/ **/


            
class twitterInterface { 
    public function __construct() {
        $settings = array(
            'oauth_access_token' => "794979-WBBi7sVREBKyMLm1T8Wg6WTWbqRp2NjmuG12nM",
            'oauth_access_token_secret' => "wHH9zHv9BHjPnyypkvFrSFmKmMFjueBDa7iAgZqxnA",
            'consumer_key' => "nDLL7hl1iHxEJ4gvb7EPyw",
            'consumer_secret' => "zC7Rzh7z36zPufjGX39Mg49vfLegOQY6uMOgX70QXQ"
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


