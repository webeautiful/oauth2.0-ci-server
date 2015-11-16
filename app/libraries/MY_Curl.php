<?php
defined('BASEPATH') OR exit('No direct script access allowed');
require_once(APPPATH.'third_party/Curl/Autoloader.php');
Curl\Autoloader::register();

class MY_Curl extends Curl\Curl {
}
