<?php
require_once __DIR__ . '/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $inputContent = $_POST['inputText'] ?? '';
    $requestType = $_POST['requestType'] ?? '';

    if ($requestType === "answer") {
        $outputDir = ANSWER_OUTPUT_DIR_PATH;
    } else if($requestType === "user") {
        $outputDir = USER_OUTPUT_DIR_PATH;
    }

    file_put_contents(USER_INPUT_FILE_PATH, $inputContent);

    $commandFormat = "java -jar %s %s -tpng -o %s 2> %s";
    $command = sprintf($commandFormat,
        PLANTUML_JAR_FILE_PATH, USER_INPUT_FILE_PATH, $outputDir, ERRORLOG_PATH);

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
            "message" => "処理が正常に完了しました"
        );
    }

    
    echo json_encode($response);


}