<?php
namespace App\Model;

/**
 *
 */
class GameManager extends AbstractManager
{
    /**
     *
     */
    const TABLE = 'Indice';

    /**
     *  Initializes this class.
     */
    public function __construct()
    {
        parent ::__construct(self::TABLE);
    }
    public function selectIndice($startPays): array
    {
        return $this->pdo->query('SELECT `Indice`.`name` FROM `pays` LEFT JOIN `Indice` ON `Indice`.`id_Pays` 
    = `pays`.`id` WHERE (`pays`.name LIKE "'. $startPays . '")')->fetchAll();
    }
    public function selectPays($startPays = null)
    {
        if ($startPays === null) {
            return $this->pdo->query('SELECT * FROM pays')->fetchAll();
        }

        return $this->pdo->query('SELECT * FROM pays WHERE name <> "' . $startPays.'"')->fetchAll();
    }
}
