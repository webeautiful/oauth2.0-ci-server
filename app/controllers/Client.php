<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Client extends CI_Controller{
    const auth_uri = 'http://ci-oauth2.pigai.org/';
    const resource_uri = 'http://ci-oauth2.pigai.org/';

    function index()
    {
        $redirect_uri = urlencode('http://ci-oauth2.pigai.org/');//最后的反斜杠必不可少
        $data = compact('redirect_uri');
        $this->load->view('demo/header.html');
        $this->load->view('demo/index', $data);
        $this->load->view('demo/footer.html');
    }
    function receive_authcode()
    {
        $code = $this->input->get('code');
        $state = $this->input->get('state');
        $error = $this->input->get('error');
        $error_description = $this->input->get('error_description');

        $redirect_uri = 'http://ci-oauth2.pigai.org/client/receive_authcode';
        $redirect_uri = urlencode($redirect_uri);
        $this->load->view('demo/header.html');
        if($error AND $error_description){
            $data = compact('error_description');
        }else{
            $data = compact('code', 'redirect_uri');
        }
        $this->load->view('demo/receive_authcode', $data);
        $this->load->view('demo/footer.html');
    }
    function request_token(){
        //1.authorization code 2.user_credentials 3.refresh_token
        $grant_type = $this->input->get('grant_type');
        switch($grant_type){
            case 'authorization_code':
                $code = $this->input->get('code');
                $redirect_uri = $this->input->get('redirect_uri');
                $token = $this->getValidAccessTokenByCode($code, $redirect_uri);
                break;
            case 'client_credentials':
                $token = $this->getValidAccessToken();
                break;
            case 'password'://user_credentials
                $this->load->library('MY_Curl', '', 'curl');
                $data = array(
                    'grant_type'=>'password',
                    'client_id'=>'demoapp',
                    'client_secret'=>'demopass',
                    'username'=>'demouser',
                    'password'=>'testpass'
                );
                $this->curl->post(self::auth_uri.'/oauth2/access_token', $data);
                $token = $this->curl->response;
                break;
            case 'refresh_token':
                break;
            default:
                die('others');
                break;
        }
        $data = compact('token');
        $this->load->view('demo/header.html');
        $this->load->view('demo/request_token', $data);
        $this->load->view('demo/footer.html');
    }

    function receive_implicit_token()
    {
        $this->load->view('demo/header.html');
        $this->load->view('demo/receive_implicit_token');
        $this->load->view('demo/footer.html');
    }
    function request_resource()
    {
        $access_token = $this->input->get('token');
        $resource_api = self::resource_uri.'users/friends?access_token='.$access_token;
        $res = $this->curl_getApi($resource_api);

        $data = compact('res', 'resource_api');
        $this->load->view('demo/header.html');
        $this->load->view('demo/request_resource', $data);
        $this->load->view('demo/footer.html');
    }

    //-----------curl获取access_token----------------//
    /**
     * Set Basic Authentication
     *
     * @access public
     * @param  $username
     * @param  $password
     */
    function setBasicAuthentication($ch, $username, $password)
    {
        curl_setopt ($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt ($ch, CURLOPT_USERPWD, $username . ':' . $password);
    }

    /*
    * 从接口获取json数据
    *
    * $api - 远程url
    * return - array
    */
    function curl_getApi($api, $httpAuth=array())
    {
        if (!function_exists('curl_init')) {
            throw new Exception('server not install curl');
        }
        $ch = curl_init($api);//初始化一个cURL对象
        $timeout = 5;
        if(isset($httpAuth['username']) AND isset($httpAuth['password'])){
            setBasicAuthentication($ch, $httpAuth['username'], $httpAuth['password']);
        }
        curl_setopt ($ch, CURLOPT_URL, $api);//设置你需要抓取的url
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);//设置cURL参数，要求结果保存到字符串中还是输出到屏幕上
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $fileContents = curl_exec($ch);//运行cURL，请求网页,返回结果集或false
        curl_close($ch);//关闭URL请求
        return json_decode($fileContents);
    }

    /*
    * 向接口POST数据
    *
    * $api - 远程url
    * $data - 如:$data = 'pNUMBER='. urlencode(1391234).'&MESSAGE='.urlencode('curl and php').'&SUBMIT=Send';
    */
    function curl_postApi($api,$data, $httpAuth=array())
    {
        if (!function_exists('curl_init')) {
            throw new Exception('server not install curl');
        }
        $curlPost = $data;
        $timeout = 5;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $api);
        //curl_setopt($ch, CURLOPT_HEADER, false);//是否显示header
        if(isset($httpAuth['username']) AND isset($httpAuth['password'])){
            $this->setBasicAuthentication($ch, $httpAuth['username'], $httpAuth['password']);
        }
        curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);//设置HTTP协议的POST方法
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);//设置POST的数据(可以为字符串或一维数组)
        $data = curl_exec($ch);
        curl_close($ch);
        return json_decode($data);
    }

    function setOpt()
    {
        $headr = array();
        $headr[] = 'Authorization: '.$douban_user_name.' '.$accesstoken;
        curl_setopt($crl, CURLOPT_HTTPHEADER,$headr);
    }

    /**
    *获取有效的access_token
    * @notice:1.新建空的access_token.txt文件，2.写入的内容格式:第一行为时间戳，第二行为有效的access_token
    *
    */
    function getValidAccessToken()
    {
        $dirname = __DIR__;
        $basename = 'access_token.txt';
        $filename = $dirname.'/'.$basename;

        $arr = file_exists($filename)? file($filename) : array();
        foreach($arr as $k=>$v){
            $arr[$k] = str_replace("\n",'',$v);
        }//替换换行符
        if($arr and $arr[0]){
            //有access_token，直接读取
            //判断token是否过期(提前15s)
            $diff = time()-$arr[0]+15;
            if($diff > $arr[2]){
                //更新access_token
                $accessToken = $this->updateAccessToken($filename);
                //echo "token已过期，已重新更新\n";
            }else{
                $accessToken = (object)array(
                    'access_token' => $arr[1],
                    'expires_in' => $arr[2],
                    'from_cache' => true,
                    'expires_rest' => $arr[2]-(time()-$arr[0])
                );
                //echo "直接从文件读取token\n";
            }
        }else{
            //无access_token,调微信接口生成新的,存入(/home/xfs/access_token.txt)
            $accessToken = $this->updateAccessToken($filename);
            //echo "首次生成token\n";
        }
        return $accessToken;
    }
    function getValidAccessTokenByCode($code, $redirect_uri)
    {
        //获取access_token
        //$api = 'http://oauth2.pigai.org/token.php?grant_type=client_credential';
        //$api = 'http://oauth2.pigai.org/token.php';
        $api = 'http://ci-oauth2.pigai.org/oauth2/access_token';
        $param = 'grant_type=authorization_code&code='.$code.'&redirect_uri='.urlencode($redirect_uri);
        $httpAuth = array(
            'username'=>'demoapp',
            'password'=>'demopass'
        );
        //$obj = curl_getApi($api, $httpAuth);
        $obj =$this->curl_postApi($api, $param, $httpAuth);
        if(!$obj) die('调用api超时');
        return $obj;
        if(isset($obj->access_token) AND isset($obj->expires_in)){
            $time = time();
            $accessToken = $obj->access_token;
            //TODO - expires_in 如何应对有效时间的调整?
            echo '过期时间:'.$obj->expires_in."\n";
        }else{
            //echo $obj->errcode.'错误:'.$obj->errmsg;
            echo $obj->error.'错误:'.$obj->error_description;
            echo "\n";exit;
        }
        return $accessToken;
    }
    //更新txt文件中access token
    function updateAccessToken($filename){
        //获取access_token
        //$api = 'http://oauth2.pigai.org/token.php?grant_type=client_credential';
        //$api = 'http://oauth2.pigai.org/token.php';
        $api = 'http://ci-oauth2.pigai.org/oauth2/access_token';
        $param = 'grant_type=client_credentials';
        $httpAuth = array(
            'username'=>'demoapp',
            'password'=>'demopass'
        );
        //$obj = curl_getApi($api, $httpAuth);
        $obj =$this->curl_postApi($api, $param, $httpAuth);
        if(!$obj) die('调用api超时');
        if(isset($obj->access_token) AND isset($obj->expires_in)){
            $time = time();
            $accessToken = $obj->access_token;
            //TODO - expires_in 如何应对有效时间的调整?
            //echo '过期时间:'.$obj->expires_in."\n";
            $writeIn = time()."\n".$accessToken."\n".$obj->expires_in;
            file_put_contents($filename,$writeIn);
        }
        return $obj;
    }
}
