<?php

namespace JobCron\Services;

use JobCron\Utilities\Logger;

use \DOMDocument;
use \DomXPath;
use \DOMNodeList;
use \Exception;

class Scraper {

    private $document;

    /**
     * given a file path or link parse the response and instantiate a DOMDocument
     * @param the link of file path
     */
    public function __construct(string $document) 
    {
        $this->setDocument($document);
    }

    /**
     * @param [type] $document file path or url
     */
    private function setDocument(string $path)
    {
        try {
            $document = new DOMDocument();

            // LIBXML_COMPACT Activate small nodes allocation optimization. 
            // This may speed up your application without needing to change the code.
            @$document->loadHTMLFile($path, LIBXML_COMPACT);

            // Removes unnecessary white space for faster parsing
            $document->preserveWhiteSpace = false; 

            if (empty($document)) {
                throw new Exception('there was an error loading the document in Scraper');
            } else {
                $this->document = $document;    
            }


        } catch(Exception $e) {
            Logger::write($e->getMessage(), 'critical', true, true);
        }
    }

    /**
     * using DomXPath which is traversal class for Dom Documents
     * we can parse the document and return any classes that relate
     * to the given parameters we've supplied
     * 
     * @param  $selector selector name i.e .class #id
     * @param  $tag the html tag
     * @param  $type class or id
     * 
     * @return DOMNodeList object containing colletion information dom nodes
     */
    public function find(string $selector, string $tag = '*', string $type = 'class') : DOMNodeList
    {
        $finder = new DomXPath($this->document);
        $queryString = sprintf(
            "/html/body//%s[contains(@%s, '%s')]",
            $tag,
            $type,
            $selector
        );

        return $finder->query($queryString);
    }

    /**
     * scrape website and return job links
     * 
     * @param $urlOrFilePath location of webpage
     * 
     * @return array an array of links and their title attributes
     */
    public function scrapeLinks($linkClass) : array 
    {
        $items = $this->find($linkClass);
        $links = [];
        $i = 1;

        $links = array_filter((array)$items, function($node) {
            return $node->tagName === 'a';
        });

        foreach ($items as $node) {
            if ($node->tagName === 'a') {
                foreach($node->attributes as $attribute) {
                    if (!empty($attribute->name) && $attribute->name == 'href') {
                        $links[$i]['text'] = $node->textContent;
                        $links[$i]['link'] = "https://indeed.com$attribute->value";
                    }

                    $i++;
                }
            }
        }

        return $links;
    }

    /**
     * create an html formatted strings from the scraped links
     * @param  array  $links an multi dimensional array of formatted links
     * @return html string for mailer
     */
    protected function htmlLinks(array $links) : string
    {
        /**
         * @todo  create an EmailBuilder Utility class that will take in an formatted array
         * i.e. [ [link] => [ 'url' => 'http://google.com', 'text' => google] ]
         * and generate an html formatted email. this function is out of the responsibility
         * of the scraper class.
         */
        
        $htmlLinks = array_map(
            function($link) { 
                if (!empty($link['link'] && !empty($link['text']))) {
                    return '<h3><a href=' . $link["link"] . '>' . $link["text"] . '</a></h3><hr>';
                }
            },
            $links
        );

        array_unshift($htmlLinks, '<html><body>');
        array_push($htmlLinks, '<body></html>');
        
        return implode('', $htmlLinks);   
    }
}