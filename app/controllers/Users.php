<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
* @resource 用户资源
*/
class Users extends MY_Controller {
    function __construct()
    {
        parent::__construct();
        $request = OAuth2\Request::createFromGlobals();
        $server = $this->getOAuth2();

        //$server->getScopeUtil();
        switch($request->server('REQUEST_METHOD')){
            case 'POST':
            case 'PUT':
            case 'DELETE':
                $scopeRequired = '';
                break;
            default:
                $scopeRequired = '';
                break;
        }

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest($request, null, $scopeRequired)) {
            $response = $server->getResponse();
            //$server->getResponse()->setParameters(array('error'))->send();
            $params = $response->getParameters();
            if($params){
                $response->send();
                die;
            }
            $params = array(
                'error'=> 'parameter error',
                'error_description'=> 'The parameters not error!'
            );
            $response->setParameters($params);
            $response->send();
            die;
        }
    }
    //获取用户信息
    function friends()
    {
        //print_r($server->getAccessTokenData($request));//token data
        header('Content-Type: application/json; charset=utf-8');
        $friends = array('friends'=>array('John', 'Matt', 'Jane'));
        echo json_encode($friends);
    }
}
