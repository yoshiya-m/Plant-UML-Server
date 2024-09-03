<?php
require_once __DIR__ . '/config.php';
$jsonData = file_get_contents(PROBLEMS_JSON_PATH);
$data = json_decode($jsonData, true)


    ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Problems</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="container mt-5">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-red">ID</th>
                    <th>Title</th>
                    <th>Theme</th>
                </tr>
            </thead>
            <tbody>

                <?php
                // jsonデータから生成する
                foreach ($data as $item) {

                    echo "<tr>";
                    echo "<td  class='clickable-row'><a href='problem.php?id=". $item["id"] . "'>". $item["id"] . "</td>";
                    echo "<td>" . $item["title"] . "</td>";
                    echo "<td>" . $item["theme"] . "</td>";
                    echo "</tr>";
                }


                ?>

            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz"
        crossorigin="anonymous"></script>
</body>

</html>