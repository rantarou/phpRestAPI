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

    // create post
    public function create() {
        // create query
        $query = '
            INSERT INTO
                '.$this->table.'
            SET
                title = :title
                body = :body
                author = :author
                category_id = :category_id
        ';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));


        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);

        // Execute Query
        if($stmt->execute()){
            return true;
        }

        // print error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // update post
    public function update() {
        // create query
        $query = '
            UPDATE
                '.$this->table.'
            SET
                title = :title
                body = :body
                author = :author
                category_id = :category_id
            WHERE
                id = :id
        ';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->title = htmlspecialchars(strip_tags($this->title));
        $this->body = htmlspecialchars(strip_tags($this->body));
        $this->author = htmlspecialchars(strip_tags($this->author));
        $this->category_id = htmlspecialchars(strip_tags($this->category_id));
        $this->id = htmlspecialchars(strip_tags($this->id));


        // Bind data
        $stmt->bindParam(':title', $this->title);
        $stmt->bindParam(':body', $this->body);
        $stmt->bindParam(':author', $this->author);
        $stmt->bindParam(':category_id', $this->category_id);
        $stmt->bindParam(':id', $this->id);

        // Execute Query
        if($stmt->execute()){
            return true;
        }

        // print error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }

    // delete post
    public function delete() {
        // create query
        $query = 'DELETE FROM '.$this->table.' WHERE id = :id';

        // prepare statement
        $stmt = $this->conn->prepare($query);

        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));

        // bind data
        $stmt->bindParam(':id', $this->id);

        // Execute query
        if($stmt->execute()){
            return true;
        }

        // print error
        printf("Error: %s.\n", $stmt->error);
        return false;
    }
}
