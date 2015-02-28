<?php
/**
 * This file is generated automatically by ConfigurationSystem.
 * Do not change it manually in production, unless you know what you're doing and can take responsibilities for the consequences of changes you make.
 */

namespace Config;

class Redis{

    public $storage = array(
        'mobile' => array (
  'db' => 1,
  'nodes' => 
  array (
    0 => 
    array (
      'master' => '127.0.0.1:6379',
      'slave' => '127.0.0.1:6379',
    ),
  ),
)
    );

    public $cache = array(
        'mobile' => array (
  'db' => 1,
  'nodes' => 
  array (
    0 => 
    array (
      'master' => '127.0.0.1:6379',
      'slave' => '127.0.0.1:6379',
    ),
  ),
)
    );

}