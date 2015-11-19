<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class MY_Controller extends CI_Controller
{
    private $OAuth2 = null;

    function __construct()
    {
        parent::__construct();
        $dsn      = 'mysql:dbname=oauth;host=192.168.1.64';
        $username = 'cikuu';
        $password = 'cikuutest!';

        // error reporting (this is a demo, after all!)
        //ini_set('display_errors',1);error_reporting(E_ALL);

        // Autoloading (composer is preferred, but for this example let's just do this)
        require_once(APPPATH.'third_party/OAuth2/Autoloader.php');
        OAuth2\Autoloader::register();


        // $dsn is the Data Source Name for your database, for exmaple "mysql:dbname=oauth;host=localhost"
        $storage = new OAuth2\Storage\Pdo(array('dsn' => $dsn, 'username' => $username, 'password' => $password));

        // Pass a storage object or array of storage objects to the OAuth2 server class
        //$server = new OAuth2\Server($storage);
        // create the server, and configure it to allow implicit
        $server = new OAuth2\Server($storage);
        $config = array(
            'allow_implicit' => true,
            'access_lifetime' => 7200,
            'require_exact_redirect_uri' => false
        );
        foreach($config as $n=>$v){
            $server->setConfig($n, $v);
        }

        // Add the "Client Credentials" grant type (it is the simplest of the grant types)
        $server->addGrantType(new OAuth2\GrantType\ClientCredentials($storage));

        // Add the "Authorization Code" grant type (this is where the oauth magic happens)
        $server->addGrantType(new OAuth2\GrantType\AuthorizationCode($storage));

        // Add the "User Credentials" grant type
        $server->addGrantType(new OAuth2\GrantType\UserCredentials($storage));

        $this->OAuth2 = $server;
    }
    function getOAuth2()
    {
        return $this->OAuth2;
    }
    function verifyResourceRequest($request, $response = null, $scopeRequired = null)
    {
        $server = $this->OAuth2;

        // Handle a request to a resource and authenticate the access token
        if (!$server->verifyResourceRequest($request, $response, $scopeRequired)) {
            $response = $server->getResponse();
            $params = $response->getParameters();
            if($params){
                $response->send();
            }else{
                $params = array(
                    'error'=> 'parameter error',
                    'error_description'=> 'The parameters not error!'
                );
                $response->setParameters($params);
                $response->send();
            }
        }
    }
}
