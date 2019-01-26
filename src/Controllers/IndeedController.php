<?php 
namespace JobCron\Controllers;

use JobCron\Services\Scraper;
use JobCron\Utilities\Mailer;

class IndeedController extends Controller 
{
    public function view() 
    {
        $urlOrFilePath = 'scraper.html';
        $scraper = new Scraper($urlOrFilePath);
        $items = $scraper->find('jobsearch-SerpJobCard');
        $links = [];
        $i = 1;

        foreach ($items as $node) {
            foreach($node->childNodes as $innerNode) {
                if (!empty($innerNode->tagName) && $innerNode->tagName === 'a') {
                    foreach($innerNode->attributes as $attribute) {
                        if (!empty($attribute->name) && $attribute->name == 'href') {
                            $links[$i]['link'] = "https://indeed.com/$attribute->value";
                        }
                    }
                    
                    $links[$i]['text'] = $innerNode->textContent;
                    $i++;
                }
            }
        }

        /**
         * @todo  create an EmailBuilder Utility class that will take in an formatted array
         * i.e. [ [link] => [ 'url' => 'http://google.com', 'text' => google] ]
         * and generate an html formatted email
         */
        Mailer::send(
            'jeremiah.wodke@gmail.com', 
            'JOBCRON: ' . __CLASS__ . ' Job Listings', 
            json_encode($links)
        );
    }
}