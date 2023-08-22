<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <title>Table CRUD Ops</title>
    <link rel="stylesheet" href="../../assets/styles.css">
</head>

<body>
    <div class="container">
        <h2>Quản lý bài viết</h2>
        <button class="button"><a href="add_post.php">Add bài viết</a></button>
        <input type="text" id="myInput" onkeyup="searchtable()" placeholder="Search for names.." title="Type in a name">