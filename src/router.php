<?php 

use Pecee\SimpleRouter\SimpleRouter;
use JobCron\Controller\PagesController;
use JobCron\Controller\IndeedController;

/**
 * The default namespace for route-callbacks, so we don't have to specify it each time.
 * Can be overwritten by using the namespace config option on your routes.
 */

SimpleRouter::setDefaultNamespace('JobCron\Controllers');

SimpleRouter::get('/', 'PagesController@index');
SimpleRouter::get('/indeed', 'JobsController@indeed');

// Start the routing
SimpleRouter::start();