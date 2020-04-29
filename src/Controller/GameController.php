<?php
/**
 * Created by PhpStorm.
 * User: aurelwcs
 * Date: 08/04/19
 * Time: 18:40
 */

namespace App\Controller;

use App\Model\GameManager;
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
        session_start();
        $session = $_SESSION;
        $gameManager = new GameManager();
        $indices = $gameManager->selectIndice();
        $randomIndice = array_rand($indices, 1);
        $indice = $indices[$randomIndice];
        if (isset($_POST['page'])) {
            $_SESSION['page'] = $_POST['page'];
        }
        if (isset($_SESSION['page'])) {
            return $this->twig->render('Game/' . $_SESSION['page'] . '.html.twig', ['session' => $session,
                'indice' => $indice ]);
        }
        return $this->twig->render('Game/index.html.twig', ['session' => $session, 'indice'=> $indice ]);
    }
}
