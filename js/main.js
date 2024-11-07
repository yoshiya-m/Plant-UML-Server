const config = {
    generate_PHP_File: "../php/generate.php",
    outputImg: document.getElementById("output-img"),
    answerImg: document.getElementById("answer-img"),
    answerCode: document.getElementById("answer-code"),
    switchToCodeBtn: document.getElementById("switch-to-code-btn"),
    switchToUMLBtn: document.getElementById("switch-to-UML-btn")
}

let timeout;
const requestDelay = 1000;
let editor;


function sendRequest(requestType, isDelayed = true) {

    if (isDelayed) delay = requestDelay;
    else delay = 0;



    // delayが必要な場合は、setTimeoutする
    if (isDelayed) {
        console.log("delay あり" + delay)
        clearTimeout(timeout);
        timeout = setTimeout(() => {
            requestHandler(requestType)
        }, delay)
    } else {
        requestHandler(requestType);
    }

}


function requestHandler(requestType) {
    console.log("request start!!")
    var text = editor.getValue();
    // 入力テキストが有効か確認
    if ((text.includes("@startuml") === false || text.includes("@enduml") === false) && requestType === "user") {
        config.outputImg.src = "";
        return
    }


    let code = new DOMParser().parseFromString(config.answerCode.innerHTML.trim().replace(/<br>/gi, '\n'), 'text/html')

    const params = new URLSearchParams();
    if (requestType === "user") params.append("inputText", text)
    else params.append("inputText", code.body.innerText);
    params.append("requestType", requestType);


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
                    config.answerImg.src = data.file_url;

                } else if (requestType === "user") {
                    config.outputImg.src = data.file_url;
                }
            } else {
                config.outputImg.src = "";
                console.log(data.message);
            }
        })
        .catch(error => {
            console.error('エラー:', error);
        });
}


require.config({ paths: { 'vs': 'https://cdnjs.cloudflare.com/ajax/libs/monaco-editor/0.20.0/min/vs' } });
require(['vs/editor/editor.main'], function () {
    editor = monaco.editor.create(document.getElementById('editor-container'), {
        value:
            `
@startuml
tom -> john: hello
@enduml
`,
        language: 'markdown'
    });


    editor.onDidChangeModelContent(() => {
        sendRequest("user")
    });
    // 答えのUMLを生成
    sendRequest("answer", false);
    sendRequest("user", false);


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

