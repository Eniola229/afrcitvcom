<?php

require '../includes/dbcon.php';

// function error422($message)
// {
//     $data = [
//         'status' => 422,
//         'message' => $message,
//     ];
//     header("HTTP/1.0 422 Unprocessable Entity");
//     echo json_encode($data);
//     exit();
// }


function storeNews($newsInput) {
    global $pdo;

    $body = isset($newsInput['body']) ? trim($newsInput['body']) : '';
    $Intro = isset($newsInput['Intro']) ? trim($newsInput['Intro']) : '';
    $extra_paragraph = isset($newsInput['extra_paragraph']) ? trim($newsInput['extra_paragraph']) : '';
     $category = isset($newsInput['category']) ? trim($newsInput['category']) : '';
     $source = isset($newsInput['source']) ? trim($newsInput['source']) : '';
     $postData = isset($newsInput['postData']) ? trim($newsInput['postData']) : '';
     $tags = isset($newsInput['tags']) ? trim($newsInput['tags']) : '';
     $essentials_link = isset($newsInput['essentials_link']) ? trim($newsInput['essentials_link']) : '';
    $share_url = isset($newsInput['share_url']) ? trim($newsInput['share_url']) : '';
    $img = isset($newsInput['img']) ? trim($newsInput['img']) : '';
    $subimgs = isset($newsInput['subimgs']) ? trim($newsInput['subimgs']) : '';
    $number_of_views = isset($newsInput['number_of_views']) ? trim($newsInput['number_of_views']) : '';
    $read_time = isset($newsInput['read_time']) ? trim($newsInput['read_time']) : '';


    if (empty($body) && empty($img)) {
    return error422('Enter your body or Upload an Image');
    }
    elseif (empty($category)) 
    {
        return error422('Enter your category');
    }
    elseif (empty($source)) 
    {
        return error422('Enter your source');
    }

  
    
    // Prepare SQL statement
    $query = "INSERT INTO posts (body, Intro, extra_paragraph, category, source, tags, essentials_link, share_url, img, subimgs, number_of_views, read_time) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    // Bind parameters and execute statement
    $stmt->execute([$body, $Intro, $extra_paragraph, $category, $source, $tags, $essentials_link, $share_url, $img, $subimgs, $number_of_views, $read_time]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        $data = [
            'status' => 201,
            'message' => 'Post Created Successfully',
        ];
        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Failed to create post',
        ];
        header("HTTP/1.0 500 Internal Server Error");
        return json_encode($data);
    }
}

// Helper function for 422 errors
function error422($message) {
    $data = [
        'status' => 422,
        'message' => $message
    ];
    http_response_code(422);
    return json_encode($data);
}

// Helper function for 500 errors
function error500($message) {
    $data = [
        'status' => 500,
        'message' => $message,
    ];
    http_response_code(500);
    return json_encode($data);
}

// Helper function for 404 errors
function error404($message) {
    $data = [
        'status' => 404,
        'message' => $message,
    ];
    http_response_code(404);
    return json_encode($data);
}


function getNewsList() {
    global $pdo;

    $query = "SELECT * FROM posts";
    $statement = $pdo->query($query);

    if ($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => "News List Fetched Successfully",
                'data' => $result
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            return error404("No News Found");
        }
    } else {
        return error500("Internal Server Error");
    }
}

function getNews($newsParams) {
    global $pdo;

    if (!isset($newsParams['id'])) {
        return error422("Please provide News id");
    }

    // Check if connection is valid
    if (!$pdo) {
        return error500("Database connection failed");
    }

    $newsId = htmlspecialchars($newsParams['id']); // Sanitize input
    $query = "SELECT * FROM posts WHERE id=?";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$newsId]);
        $news = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return error500("Database Error: " . $e->getMessage());
    }

    if ($news) {
        $data = [
            'status' => 200,
            'message' => "News Fetched Successfully",
            'data' => $news,
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);
    } else {
        return error404("News Not Found");
    }
}
