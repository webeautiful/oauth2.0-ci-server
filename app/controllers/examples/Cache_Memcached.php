<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Cache_Memcached extends CI_Controller{
    function index()
    {
        $this->load->driver('cache');

        if ( ! $foo = $this->cache->memcached->get('foo'))
        {
            echo 'Saving to the cache!<br />';
            $foo = 'foobarbaz!';

            // Save into the cache for 5 minutes
            $this->cache->memcached->save('foo', $foo, 300);
        }

        echo $foo;
    }
}
