<?php

try {
    $pdo = new PDO("mysql:host=nginx-mysql;dbname=test;port=3306;charset=utf8", 'test', 'test', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);


    $stmt = $pdo->query('SELECT test_id FROM test_update LIMIT 1');
    $fetched = $stmt->fetch();

    if (empty($fetched)) {
        $pdo->query("INSERT INTO test_update (test_id) VALUE (1)");
    } else {
        $test_id = ++$fetched['test_id'];
        $stmt = $pdo->prepare("UPDATE test_update SET test_id = :test_id");
        $stmt->execute(['test_id' => $test_id]);
    }

    echo $fetched['test_id'] ?? 'empty';
}
catch (PDOException $e) {
    var_dump($e->getMessage());
    exit;
}