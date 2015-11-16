<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends MY_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
        $this->load->library('MY_Curl', '', 'curl');
        $data = array(
            'id' => '1',
            'content' => 'Hello world!',
            'date' => date('Y-m-d H:i:s'),
        );
        $this->curl->post('https://httpbin.org/post', $data);
        $res = $this->curl->response->form;
        var_dump($res->content);
		$this->load->view('welcome_message');
	}
}
