<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\APIManager;
use App\Model\HomeManager;

class HomeController extends AbstractController
{

    /**
     * Display home page
     *
     * @return string
     * @throws \Twig\Error\LoaderError
     * @throws \Twig\Error\RuntimeError
     * @throws \Twig\Error\SyntaxError
     */
    public function index()
    {
        session_start();
        $countryManager = new HomeManager();
        $homeManager = new APIManager();
        $country = $countryManager->selectOneRandomCountry();
        $randomizer = $homeManager->selectOneArtworkByCountry($country[0]['name']);
        $stolenArtwork = $homeManager->selectAllById($randomizer);

        return $this->twig->render('Home/index.html.twig', ['tableauVole' => $stolenArtwork]);
    }
}
