<?php
class Post {
    // DB Stuff
    private $conn;
    private $table = 'posts';

    // Post Property
    public $id;
    public $category_id;
    public $category_name;
    public $title;
    public $body;
    public $author;
    public $created_at;

    // Constructor
    public function __construct($db){
        $this->conn = $db;
    }

    // Get Posts
    public function read(){
        // create querry
        $query = '
            SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '.$this->table.' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            ORDER BY
                p.created_at DESC
        ';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // execure query
        $stmt->execute();

        return $stmt;
    }

    // Get Single Post
    public function read_single() {
        // create query
        $query = '
            SELECT
                c.name as category_name,
                p.id,
                p.category_id,
                p.title,
                p.body,
                p.author,
                p.created_at
            FROM
                '.$this->table.' p
            LEFT JOIN
                categories c ON p.category_id = c.id
            WHERE
                p.id = :id
            LIMIT 0,1
        ';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // bind ID
        $stmt->bindParam(':id', $this->id);

        // execute query
        $stmt->execute();

        return $stmt;
    }
}
