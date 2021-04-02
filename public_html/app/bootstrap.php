<?php

//load config
require 'config/config.php';
//load helpers
require 'helpers/url_helper.php';
//load session helpers
require 'helpers/session_helper.php';
//load utilities, contains functions for date/time etc.
require 'helpers/utilities.php';
//load the key master
require 'helpers/KeyMaster.php';


//auto load core libraries/classes
spl_autoload_register(function($className) {
    require_once 'libraries/'.$className.'.php';
});

