<?php 
namespace JobCron\Services;

use JobCron\Utilities\Mailer;
use JobCron\Services\Scraper;

class IndeedScraper extends Scraper
{
    /**
     * @param css class of links in DOM to scrape. once found and formatted
     * send an email notification
     * 
     * scrape format the links into html and mail it
     * @return mailgun api response
     */
    public function scrapeAndSend($linkClass) 
    {
        $links = $this->scrapeLinks($linkClass);

        Mailer::send(
            'jeremiah.wodke@gmail.com', 
            'JOBCRON: ' . __CLASS__ . ' Job Listings', 
            $this->htmlLinks($links)
        );
    }
}