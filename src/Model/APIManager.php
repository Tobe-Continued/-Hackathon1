<?php
/**
 * Created by PhpStorm.
 * User: sylvain
 * Date: 07/03/18
 * Time: 18:20
 * PHP version 7
 */

namespace App\Model;

use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;

/**
 *
 */
class APIManager
{
    protected $error;

    protected $content;

    public function connect(string $method, string $req, string $arg = null): array
    {
        $client = HttpClient::create();
        try {
            $response = $client->request($method, METRO_API_HOST . $req);
            $statusCode = $response->getStatusCode();
            if ($statusCode === 200) {
                if (isset($arg)) {
                    $data = $response->getContent();
                    $result = json_decode($data);
                    $decoder = $result->$arg;
                    return $decoder;
                } else {
                    $data = $response->toArray();
                    return $data;
                }
            }
        } catch (TransportExceptionInterface $e) {
            $this->error[] = $e;
        } catch (ClientExceptionInterface $e) {
            $this->error[] = $e;
        } catch (RedirectionExceptionInterface $e) {
            $this->error[] = $e;
        } catch (ServerExceptionInterface $e) {
            $this->error[] = $e;
        } catch (DecodingExceptionInterface $e) {
            $this->error[] = $e;
        }
        return $this->error;
    }

    public function selectAllByCountry(string $country)
    {
        $base = "/public/collection/v1/search?geoLocation=";
        return $this->connect('GET', $base . $country . '&departmentIds=11&q=*', 'objectIDs');
    }

    public function selectAllById(int $id)
    {
        return $this->connect('GET', '/public/collection/v1/objects/' . $id);
    }

    public function selectOneArtworkByCountry(string $country)
    {
        $base = "/public/collection/v1/search?geoLocation=";
        $result =  $this->connect('GET', $base . $country . '&departmentIds=11&q=*', 'objectIDs');
        shuffle($result);
        return $result[1];
    }
}
