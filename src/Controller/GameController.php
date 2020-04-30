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
use App\Model\APIManager;

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
        $homeManager = new APIManager();
        $tableauInfo = $homeManager->selectAllById($_SESSION['tableauId']);
        $stolenArtwork = $homeManager->selectAllById($_SESSION['tableauId']);
        $pays = $gameManager->selectPays($_SESSION['tableauPays']);
        $randomPays = array_rand($pays, 1);
        $slow = $_SESSION['tableauPays'];
        $startPays = ['name' => $_SESSION['tableauPays']];
        $indice = $gameManager->selectIndice($slow);
        $pays = [$pays[$randomPays],$startPays];
        shuffle($pays);
        list($indice) = $indice;
        if (isset($_POST['pays']) && $_POST['pays'] === $startPays['name']) {
            $_SESSION['page'] = 'third';
        }
        if (isset($_POST['pays']) && $_POST['pays'] !== $startPays['name']) {
            $error = 'Mauvaise Réponse !';
        }
        if (isset($_POST['page'])) {
            $_SESSION['page'] = $_POST['page'];
        }
        if (isset($_POST['toMenu'])) {
            $_SESSION = [];
            session_regenerate_id();
            session_destroy();
            header("Location: /Home/index");
        }
        if (isset($_SESSION['page'])) {
            return $this->twig->render('Game/' . $_SESSION['page'] . '.html.twig', ['session' => $session,
                'indice' => $indice, 'pays' => $pays, 'error'=> $error ?? null, 'artwork' => $tableauInfo ]);
        }
        return $this->twig->render('Game/index.html.twig', ['session' => $session, 'indice'=> $indice[0] ?? null,
            'pays' => $pays, 'stolenArtwork'=>$stolenArtwork ?? null ]);
    }
}
