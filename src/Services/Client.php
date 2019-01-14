<?
/**
 * The Client is used for interacting with external web services. 
 * Each time the client is instantiated it requires a factory class
 * from which it builds it's configurations and interactions from there
 */

require 'vendor/autoload.php';

use GuzzleHttp\Client as Guzzle;
use GuzzleHttp\Promise as Promise;
use \Exception;
use Response;

class Client
{
    /**
     * headers provided to the external web service
     * @var array - an array of headers
     */
    protected $headers;

    /**
     * @var object - cached guzzle client
     */
    protected $client;

    /**
     * @var object - the resource the client will be interracting with
     */
    protected $api;

    public function __construct(Factory $apiFactory)
    {
        $this->api = apiFactory;
        $this->client = new Guzzle();
    }

    /**
     * The implementation of this method ensures that child classes 
     * and more importantly, instantiated classes do not have direct access
     * to credentials. This prevents security measures such as full object display
     * via printing, __string(), and echo properties that could reveal sensitive information.
     * 
     * @param  string $type - the credential corresponding to the service you're attempting to contact
     * 
     * @return return the nested array of creds if exists
     *
     * @todo  refactor into factory classes with a map of each api to it's corresponding credential
     */
    protected function getCredentials(string $service) : string
    {
        $creds = require '../credentials.php';

        try {
            if (array_key_exists($type, $creds)) {
                return $creds[$type];
            } 

            throw new Exception("Credentials for ${get_class($this)}");

        } catch (Exception $e) {
            /* @TODO implement monolog */
            return '';
        }
    }

    /**
     * A proxy function for Guzzle->request method. Used to handle 
     * all types of different HTTP requests 
     * 
     * @param  string $operation
     * @param  string $endpoint
     * @param  array  $payload 
     * 
     * @return object $response
     */
    public function request(string $operation, string $endpoint, array $payload = []) 
    {
        $endpoint = sprintf(
            '%s?%s',
            $this->api->getUrl(),
            urlencode($endpoint)
        );

        $response = new Response(
            $this->client->request(
            $operation,
            $endpoint,
            [
                'headers' => $this->api->headers,
                'json'    => $payload
            ]
        );
    }
};