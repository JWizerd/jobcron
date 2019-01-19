<?php 

use Pecee\SimpleRouter\SimpleRouter;
use JobCron\Controller\PagesController;

/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('JobCron\Controllers');

SimpleRouter::get('/', 'PagesController@index');

// Start the routing
SimpleRouter::start();