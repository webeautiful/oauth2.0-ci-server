<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Oauth2 extends MY_Controller {
    function authorize()
    {
        $server = $this->getOAuth2();
        $request = OAuth2\Request::createFromGlobals();
        $response = new OAuth2\Response();

        //echo $this->input->get('redirect_uri');exit;
        // validate the authorize request
        if (!$server->validateAuthorizeRequest($request, $response)) {
            $response->send();
            die;
        }
        // display an authorization form
        if (empty($_POST)) {
            $this->load->view('oauth2_authorize.html');
        }else{
            // print the authorization code if the user has authorized your client
            $is_authorized = ($_POST['authorized'] === '连接');
            $server->handleAuthorizeRequest($request, $response, $is_authorized);
            if ($is_authorized) {
                $location = $response->getHttpHeader('Location');
                $parseUrl = parse_url($location);
                // this is only here so that you get to see your code in the cURL request. Otherwise, we'd redirect back to the client
                switch($_GET['response_type']) {
                    case 'token':
                        //parse_str($parseUrl['fragment'], $param);
                        $response->send();
                        break;
                    case 'code':
                        //parse_str($parseUrl['query'], $param);
                        $response->send();
                        break;
                    default:
                        exit('error');
                        break;
                }
                //$code = substr($location, strpos($location, 'code=')+5, 40);
                header("Content-type: application/json");
                exit(json_encode($param));
            }
            //cancel authorization
            $response->send();
        }
    }

    function access_token()
    {
        $server = $this->getOAuth2();
        $request = OAuth2\Request::createFromGlobals();

        // Handle a request for an OAuth2.0 Access Token and send the response to the client
        $server->handleTokenRequest($request)->send();
        die;
        $return = array(
            'access_token'=> 'fdd5edf8d8b92890f6db932e07adaeabcfee6961',
            'expires_in'=> 7200,
            'uid'=> '当前授权用户的UID'
        );
        $return = array(
            'error'=>'HTTP METHOD is not suported for this request!',
            'error_code'=>10021,
            'request'=>'/oauth2/access_token'
        );
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($return);
    }
}
