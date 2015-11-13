<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Admin extends MY_Controller{
    /*
    * 生成或更新client
    */
    function create_client()
    {
        $server = $this->getOAuth2();
        $storage = $server->getStorage('client');

        $client_id = 'testclient';
        $client_secret = 'testpass';
        $redirect_uri = 'http://t.pigai.org/pigai_sdk/';
        $grant_types = 'client_credentials authorization_code';//client_credentials authorization_code password
        $scope = 'users_basic_r';
        $scope = $storage->getDefaultScope().' '.$scope;
        $user_id = 1;
        $bool = $storage->setClientDetails($client_id, $client_secret, $redirect_uri, $grant_types, $scope, $user_id);
        var_dump($bool);
    }
    /*
    * oauth_scope 设置作用域
    */
    function set_scope()
    {
        $sql = 'insert into oauth_scopes values ("pigai_basic_common", 1), ("users_basic_r", null), ("users_basic_w", null)';
    }
    /*
    * 注册user
    */
    function register_user()
    {
        $server = $this->getOAuth2();
        $storage = $server->getStorage('client');

        $username = '121023254@qq.com';
        $password = 'xiongfusong';
        $firstName = null;
        $lastName = null;
        $bool = $storage->setUser($username, $password, $firstName = null, $lastName = null);
        var_dump($bool);
    }
}
