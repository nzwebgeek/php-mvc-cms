<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

abstract class Repository
{
    protected PDO $db;


    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}