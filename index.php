<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="frame">

    </div>
    <form action="insert.php" method="post" id="actionForm">
        <label for="insert">Insert 1 triệu record</label>
        <button name="insert_1m" value="insert" class="custom-btn btn-1">INSERT</button><br>
        <label for="export">Export 1 triệu record ra file csv</label>
        <button name="export_1m" value="export" class="custom-btn btn-4"><span>Export</span></button>
    </form>
</body>

</html>