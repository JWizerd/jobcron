<?php 

namespace JobCron\Controllers;

use JobCron\Services\IndeedScraper;
use \Exception;

class JobsController extends Controller 
{
    public function indeed() 
    {
        $scraper = new IndeedScraper('scraper.html');

        try {
            $scraper->scrapeAndSend('jobtitle');
        } catch (Exception $e) {
            Logger::write($e, 'critical', false, true);
        }
    }
}