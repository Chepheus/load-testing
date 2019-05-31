<?php

try {
    $pdo = new PDO("mysql:host=nginx-mysql;dbname=test;port=3306;charset=utf8", 'test', 'test', [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);

    switch ($_SERVER['REQUEST_METHOD']) {

        case 'GET':
            $page = $_GET['page'] ?? 1;
            $limit = 10;
            $offset = $limit * ($page - 1);

            $stmt = $pdo->prepare('SELECT * FROM test_update LIMIT :offset, :limit');
            $stmt->execute(['offset' => $offset, 'limit' => $limit]);

            $fetched = $stmt->fetchAll(PDO::FETCH_ASSOC);

            var_dump($fetched);
            http_response_code(200);
            exit;

        case 'POST':
            $title = $_POST['title'] ?? 'test';
            $text = $_POST['text'] ?? 'test';

            $stmt = $pdo->prepare('INSERT INTO test_update (test_title, test_text) VALUES(:test_title, :test_text)');
            $stmt->execute(['test_title' => $title, 'test_text' => $text]);
            http_response_code(204);
            exit;

    }

}
catch (\Exception $e) {
    var_dump($e->getMessage());
    exit;
}