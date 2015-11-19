<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cache_Memcached extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->driver('cache');
    }
    function test()
    {
        if ( ! $foo = $this->cache->memcached->get('foo'))
        {
            echo 'Saving to the cache!<br />';
            $foo = 'foobarbaz!';

            // Save into the cache for 5 minutes
            $this->cache->memcached->save('foo', $foo, 300);
        }

        echo $foo;
    }
    function statistics()
    {
        $client_id = $this->input->get('client_id');
        $client_id = $client_id? trim($client_id) : '';
    }
}
