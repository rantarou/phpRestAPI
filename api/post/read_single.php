<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Init DB & connect
$database = new Database();
$db = $database->connect();

// Init blog post object
$post = new Post($db);

if(isset($_GET['id'])) {
    $post->id = $_GET['id'];
    // Blog post query
    $result = $post->read_single();

    // get row count
    $num = $result->rowCount();

    // if any posts
    if($num > 0) {
        // Post array
        $posts_arr = array();
        $posts_arr['status'] = '200';
        $posts_arr['message'] = $num . ' data found';

        $row = $result->fetch(PDO::FETCH_ASSOC);
        extract($row);

        $posts_arr['data'] = array(
            'id'            => $id,
            'title'         => $title,
            'body'          => html_entity_decode($body),
            'author'        => $author,
            'category_id'   => $category_id,
            'category_name' => $category_name,
            'created_at'    => $created_at
        );
    } else {
        $posts_arr['status'] = '404';
        $posts_arr['message'] = 'No Data Found';
    }

} else {
    $posts_arr['status'] = '500';
    $posts_arr['message'] = 'Post ID not defined';
}

echo json_encode($posts_arr);




