<?php

try {
    $pdo = new PDO("mysql:host=nginx-mysql;dbname=test;port=3306;charset=utf8", 'test', 'test', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);


    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $stmt = $pdo->query('SELECT * FROM test_update LIMIT 10');
        $fetched = $stmt->fetchAll(PDO::FETCH_ASSOC);

        var_dump($fetched); exit;
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $stmt = $pdo->prepare('INSERT INTO test_update (test_title, test_text) VALUES(:test_title, :test_text)');
        $stmt->execute(['test_title' => 'test', 'test_text' => 'Some test text']);
    }

}
catch (PDOException $e) {
    var_dump($e->getMessage());
    exit;
}