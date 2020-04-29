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
    public function selectIndice(): array
    {
        return $this->pdo->query('SELECT * FROM ' . $this->table)->fetchAll();
    }
}
