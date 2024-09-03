const config = {
    generate_PHP_File: "../php/generate.php",
    output_img_file: "../images/input.png",
    answer_img_file: "../images/answer/input.png",
    outputImg: document.getElementById("output-img"),
    answerImg: document.getElementById("answer-img"),
    answerCode: document.getElementById("answer-code"),
    switchToCodeBtn: document.getElementById("switch-to-code-btn"),
    switchToUMLBtn: document.getElementById("switch-to-UML-btn")
}

let timeout;
const requestDelay = 1000;
let editor;


function sendRequest(requestType) {
    console.log("send start")
    if (requestType === "user") delay = requestDelay;
    else delay = 0;

    clearTimeout(timeout);
    timeout = setTimeout(() => {
        console.log("request started")
        var text = editor.getValue();
        // 入力テキストが有効か確認
        if ((text.includes("@startuml") === false || text.includes("@enduml") === false) && requestType === "user") {
            config.outputImg.src = "";
            return
        }

        const params = new URLSearchParams();
        if (requestType === "user") params.append("inputText", text)
        else params.append("inputText", config.answerCode.innerText.trim().replace(/<br>/gi, '\n'));
        params.append("requestType", requestType);
        console.log()

        // UML図を取得する
        fetch(config.generate_PHP_File, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: params.toString()
        })
            .then((response) => {
                return response.json();
            })
            .then((data) => {
                if (data.status === "success") {
                    // 生成された画像を表示する
                    if (requestType === "answer") {
                        config.answerImg.src = config.answer_img_file + "?" + new Date().getTime();
                        config.answerCode.classList.add("d-none");
                    } else if (requestType === "user") {
                        config.outputImg.src = config.output_img_file + "?" + new Date().getTime();
                    }
                } else {
                    config.outputImg.src = "";
                    console.log(data.message);
                }
            })
            .catch(error => {
                console.error('エラー:', error);
            });
    }, delay);
}


require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs' } });
require(['vs/editor/editor.main'], function () {
    editor = monaco.editor.create(document.getElementById('editor-container'), {
        value: '',
        language: 'markdown'
    });
    
    
    editor.onDidChangeModelContent(() => {
        sendRequest("user")});
    // 答えのUMLを生成
    sendRequest("answer");

    function switchToUML() {
        config.answerCode.classList.add("d-none");
        config.answerImg.classList.remove("d-none");
    }

    function switchToCode() {
        config.answerCode.classList.remove("d-none");
        config.answerImg.classList.add("d-none");
    }

    config.switchToUMLBtn.addEventListener("click", switchToUML);
    config.switchToCodeBtn.addEventListener("click", switchToCode);
    
});

