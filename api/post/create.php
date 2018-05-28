<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Init DB & connect
$database = new Database();
$db = $database->connect();

// Init blog post object
$post = new Post($db);


// get raw posted data
$data = json_decode(file_get_contents("php://input"));

if(!empty($data)) {
    $post->title       = $data->title;
    $post->body        = $data->body;
    $post->author      = $data->author;
    $post->category_id = $data->category_id;

    if($post->update()) {
        $posts_arr['status'] = '200';
        $posts_arr['message'] = 'Post Created';
    } else {
        $posts_arr['status'] = '500';
        $posts_arr['message'] = 'Post Not Created';
    }
} else {
    $posts_arr['status'] = '404';
    $posts_arr['message'] = 'Data not included';
}

echo json_encode($posts_arr);
