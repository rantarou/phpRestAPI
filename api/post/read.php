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

// Blog post query
$result = $post->read();
// get row count
$num = $result->rowCount();

// if any posts
if($num > 0) {
    // Post array
    $posts_arr = array();
    $posts_arr['status'] = '200';
    $posts_arr['message'] = $num . ' data found';
    $posts_arr['data'] = array();

    while($row = $result->fetch(PDO::FETCH_ASSOC)){
        extract($row);

        $post_item = array(
            'id'            => $id,
            'title'         => $title,
            'body'          => html_entity_decode($body),
            'author'        => $author,
            'category_id'   => $category_id,
            'category_name' => $category_name,
            'created_at'    => $created_at
        );

        // push to "data"
        array_push($posts_arr['data'], $post_item);
    }
} else {
    $posts_arr['status'] = '404';
    $posts_arr['message'] = 'No Data Found';
}

echo json_encode($posts_arr);
