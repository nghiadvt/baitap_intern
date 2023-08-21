<?php
require('db_connection.php');
require('../models/Post.php');
function addPost($title, $content)
{
    global $conn;

    $title = $conn->real_escape_string($title);
    $content = $conn->real_escape_string($content);

    $sql = "INSERT INTO posts (title, content) VALUES ('$title', '$content')";
    $result = $conn->query($sql);

    return $result;
}

function getPosts()
{
    global $conn;

    $posts = [];

    $sql = "SELECT id, title, content FROM posts";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $post = new Post($row['id'], $row['title'], $row['content']);
            $posts[] = $post;
        }
    }

    return $posts;
}
