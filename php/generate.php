<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputContent = $_POST['inputText'] ?? '';

    // 同時リクエストでも衝突しないようrandom生成
    // www-userのファイル生成のために、ディレクトリの権限
    // 画像file
    // 入力したテキストのファイル
    $inputFilename = bin2hex(random_bytes(16));
    
    file_put_contents(TMP_DIR_PATH . "/" . $inputFilename . ".txt", $inputContent);
    $commandFormat = "java -jar %s -o %s -tpng %s 2> %s";
    $command = sprintf($commandFormat,
        PLANTUML_JAR_FILE_PATH, TMP_DIR_PATH,  TMP_DIR_PATH . "/" . $inputFilename . ".txt", ERRORLOG_PATH);

    // コマンドを実行し、出力とエラーを取得
    $output = [];
    $returnVar = 0;
    exec($command, $output, $returnVar);
   
    // エラーがあれば失敗として返す
    $error = file_get_contents(ERRORLOG_PATH);
    if ($error !== ""){
        header("Content-Type: application/json");
        http_response_code(400);
        $response = array(
            "status" => "error",
            "message" => "エラー：" . $error
        );
    } else {
        header("Content-Type: application/json");
        http_response_code(200);
        $response = array(
            "status" => "success",
            "message" => "処理が正常に完了しました",
            "file_url" => "tmp/" . $inputFilename . ".png"
        );
    }
    echo json_encode($response);
}
