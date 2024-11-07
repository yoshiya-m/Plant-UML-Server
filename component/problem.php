<?php
require_once __DIR__ . '/../php/config.php';
$jsonData = file_get_contents(PROBLEMS_JSON_PATH);
$data = json_decode($jsonData, true);

include __DIR__ . "/../component/layout/header.php";

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

<body>
    <h1>
        <?php echo sprintf("ID: %s %s %s", $id, $title, $theme); ?>
    </h1>
    <a href="/problems" class="btn btn-primary mb-3">問題一覧にもどる</a>
    <div class="d-flex vh-100 align-items-center justify-content-center">
        <!-- ユーザのテキスト入力欄 -->
        <div id="editor-container" class="box"></div>
        <!-- ユーザのUML図 -->
        <div class="box">
            <div>
                <img id="output-img" class="UML-img">
            </div>
        </div>
        <!-- 問題の答え表示 -->
        <div class="box">
            <button id="switch-to-UML-btn">Answer UML</button>
            <button id="switch-to-code-btn">Answer Code</button>
            <div id="answer-container">
                <img id="answer-img" class="UML-img">
                <p id="answer-code" class="d-none">
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