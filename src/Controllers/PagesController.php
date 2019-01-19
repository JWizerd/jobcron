<?php 
namespace JobCron\Controllers;

class PagesController extends Controller 
{
    public static function index() 
    {
        require 'views/main.php';
    }
}