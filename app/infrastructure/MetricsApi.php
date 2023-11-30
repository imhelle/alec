<?php

namespace app\infrastructure;

use yii\httpclient\Client;

class MetricsApi implements MetricsApiInterface
{
    
    private $apiUrl;
    
    public function __construct($apiUrl)
    {
        $this->apiUrl = $apiUrl;
    }
    
    public function getIntraStudyMetricsByLifespans($data)
    {
//        var_dump($data); 
//        var_dump($this->apiUrl . '/metrics/overmortality/by-lifespans'); die;
        
        $client = new Client([
            'responseConfig' => ['format' => Client::FORMAT_JSON]
    ]);
        
//        $client->
//        var_dump($data);
//        var_dump($data); die;
        \Yii::$app->response->format = Client::FORMAT_JSON;
        $response = $client->post(
            $this->apiUrl . '/metrics/overmortality/by-lifespans'
            )->addHeaders(['content-type' => 'application/json'])->setContent($data)->send();
        
        return $response->data;
        
    }    
    
    public function getIntraStudyMetricsByGraph($data)
    {
        $client = new Client([
            'responseConfig' => ['format' => Client::FORMAT_JSON]
    ]);
        \Yii::$app->response->format = Client::FORMAT_JSON;
        $response = $client->post(
            $this->apiUrl . '/metrics/overmortality/by-graph'
            )->addHeaders(['content-type' => 'application/json'])->setContent($data)->send();
        
        return $response->data;
        
    }
}