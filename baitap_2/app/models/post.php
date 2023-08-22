<?php
require_once('../traits/CRUDTrait.php');
class Post
{
    use CRUDTrait;

    private $conn;
    protected $table = 'posts';

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    public function addPost($data)
    {
       
        return $this->create($this->table, $data);
    }

    public function getPostsByUserId($user_id)
    {
        return $this->read($this->table, "user_id = $user_id");
    }
}
