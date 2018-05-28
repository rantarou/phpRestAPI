<?php
//Headers
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Methods: DELETE');
header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');

include_once '../../config/Database.php';
include_once '../../models/Post.php';

// Init DB & connect
$database = new Database();
$db = $database->connect();

// Init blog post object
$post = new Post($db);

if(isset($_GET['id'])) {
    $post->id = $_GET['id'];

    if($post->delete()) {
        $posts_arr['status'] = '200';
        $posts_arr['message'] = 'Post Deleted';
    } else {
        $posts_arr['status'] = '500';
        $posts_arr['message'] = 'Post Not Deleted';
    }
} else {
    $posts_arr['status'] = '500';
    $posts_arr['message'] = 'Post ID not defined';
}

echo json_encode($posts_arr);
