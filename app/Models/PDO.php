<?php

namespace App\Models;
use App\Models\PDO;

class PDO {
    public function connect() {
        return 'This is a custom PDO class!';
        $pdo = new PDO();
echo $pdo->connect();
    }
}
