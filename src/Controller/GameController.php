<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\HomeManager;
use App\Model\GameManagerAPI;

class GameController extends AbstractController
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
        if (isset($_SESSION['page'])) {
            return $this->twig->render('Game/' . $_SESSION['page'] . '.html.twig');
        }
        return $this->twig->render('Game/index.html.twig');
    }
}
