<?php
require_once __DIR__ . '/config.php';
$jsonData = file_get_contents(PROBLEMS_JSON_PATH);
$data = json_decode($jsonData, true);


if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $id = (int) htmlspecialchars($_GET['id']) ?? "";
    foreach ($data as $item) {
        if ($item['id'] === $id) {
            $title = $item['title'];
            $theme = $item['theme'];
            $uml = $item['uml'];
        }
    }

}

?>


<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>PlantUML-Server</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1>
        <?php echo sprintf("ID: %s %s %s", $id, $title, $theme); ?>
    </h1>
    <div class="d-flex vh-100 align-items-center justify-content-center">
        <div id="editor-container" class="box"></div>

        <div class="box">
            <div>
                <img id="output-img" class="UML-img">
            </div>
        </div>
        <div class="box">
            <button id="switch-to-UML-btn">Answer UML</button>
            <button id="switch-to-code-btn">Answer Code</button>
            <div id="answer-container">
                <img id="answer-img" class="UML-img">
                <p id="answer-code">
                    <?php echo str_replace("\n", "<br>", $uml) ?>
                </p>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs/loader.min.js"></script>
    <script src="../js/main.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>
</html>