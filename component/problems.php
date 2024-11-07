<?php
require_once __DIR__ . '/../php/config.php';
$jsonData = file_get_contents(PROBLEMS_JSON_PATH);
$data = json_decode($jsonData, true);
include __DIR__ . "/../component/layout/header.php";

?>

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

                foreach ($data as $item) {
                    echo "<tr class='clickable-row' onclick='window.location.href=\"problem?id=" . $item["id"] . "\";'>";
                    echo "<td  class='clickable-row'><a href='problem?id=" . $item["id"] . "'>" . $item["id"] . "</td>";
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