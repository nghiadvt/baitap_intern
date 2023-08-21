<?php
require('auth.php');
?>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/main.css" />
    <title>Table CRUD Ops</title>
    <link rel="stylesheet" href="assets/styles.css">
</head>

<body>
    <div class="container">
        <h2>Quản lý bài viết</h2>
        <button class="button"><a href="add_post.php">Add bài viết</a></button>
        <input type="text" id="myInput" onkeyup="searchtable()" placeholder="Search for names.." title="Type in a name">
        <div class="modal">
            <div class="modal-content">
                <span class="close-button">&times;</span>
                <form id="formElem">
                    <label for="stt">STT</label>
                    <input type="text" id="stt" name="stt">

                    <label for="title">Title</label>
                    <input type="text" id="title" name="title">

                    <label for="content">Content</label>
                    <input type="text" id="name" name="content">

                    <label for="action">Action</label>
                    <input type="text" id="action" name="action">

                    <button class="button" type="submit">Submit</button>
                </form>
            </div>
        </div>
        <table id="dataTable">
            <tr>
                <th>STT</th>
                <th>Title</th>
                <th>Content</th>
                <th>Action</th>
            </tr>
        </table>
    </div>
    <script src="js/main.js"></script>
</body>

</html>