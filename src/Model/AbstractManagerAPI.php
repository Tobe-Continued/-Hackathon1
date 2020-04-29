<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 20:52
 * PHP version 7
 */
namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

/**
 * Abstract class handling default manager.
 */
abstract class AbstractManagerAPI
{
    /**
     * @var HttpClient
     */
    protected $client; //variable de connexion

    /**
     * @var ResponseInterface
     */
    protected $response;
    /**
     * @var array
     */
    protected $error;


    /**
     * Initializes Manager Abstract class.
     */
    public function __construct()
    {
        $this->client = HttpClient::create();
    }

    /**
     * Get all row from database.
     *
     * @param string $country
     * @return array
     */
    public function selectAll(string $country = 'France'): array
    {
        try {
            $response = $this->client->
            request('GET', METRO_API_HOST . '/public/collection/v1/search?geoLocation=' . $country . '&q=*');
            $statusCode = $response->getStatusCode(); // get Response status code 200
            if ($statusCode === 200) {
                return $response->toArray();
                // convert the response (here in JSON) to an PHP array
            }
        } catch (ClientExceptionInterface $e) {
            $this->error[] = $e;
        } catch (DecodingExceptionInterface $e) {
            $this->error[] = $e;
        } catch (RedirectionExceptionInterface $e) {
            $this->error[] = $e;
        } catch (ServerExceptionInterface $e) {
            $this->error[] = $e;
        } catch (TransportExceptionInterface $e) {
            $this->error[] = $e;
        }
        return $this->error;
    }

    /**
     * Get all row from database.
     *
     * @param int $id
     * @return array
     */
    public function selectAllById(int $id): array
    {
        try {
            $response = $this->client->request('GET', METRO_API_HOST . '/public/collection/v1/objects/' . $id);
            $statusCode = $response->getStatusCode(); // get Response status code 200
            if ($statusCode === 200) {
                return $response->toArray();
                // convert the response (here in JSON) to an PHP array
            }
        } catch (ClientExceptionInterface $e) {
            $this->error[] = $e;
        } catch (DecodingExceptionInterface $e) {
            $this->error[] = $e;
        } catch (RedirectionExceptionInterface $e) {
            $this->error[] = $e;
        } catch (ServerExceptionInterface $e) {
            $this->error[] = $e;
        } catch (TransportExceptionInterface $e) {
            $this->error[] = $e;
        }
        return $this->error;
    }
}
