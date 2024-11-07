<?php

return [
    // デフォルトルート
    "" => function() {
        require __DIR__ . "/../component/home.php";
        
    },
    "problems" => function() {
        require __DIR__ . "/../component/problems.php";
    },
    "problem" => function() {
        if ($_SERVER['REQUEST_METHOD'] !== "GET") json_encode(["status" => "error", "message" => "Invalid request method."]);
        require __DIR__ . "/../component/problem.php";
    }
];