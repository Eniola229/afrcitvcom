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


function storeAds($adsInput) {
    global $pdo;

    $img_video = isset($adsInput['img_video']) ? trim($adsInput['img_video']) : '';
    $share_url = isset($adsInput['share_url']) ? trim($adsInput['share_url']) : '';
    $ads_start = isset($adsInput['ads_start']) ? trim($adsInput['ads_start']) : ''; 
    $number_of_views = isset($adsInput['number_of_views']) ? trim($adsInput['number_of_views']) : '';
    $description = isset($adsInput['description']) ? trim($adsInput['description']) : '';
    $ads_end = isset($adsInput['ads_end']) ? trim($adsInput['ads_end']) : null; // Set to NULL if not provided

    if (empty($img_video)) {
        return error422('Enter your img_video'); 
    } elseif (empty($share_url)) {
        return error422('Enter your share_url');
    } elseif (empty($ads_start)) {
        return error422('Enter your ads_start');
    } elseif (empty($number_of_views)) {
        return error422('Enter your number_of_views');
    } elseif (empty($ads_end)) {
        return error422('Enter your ads_end');
    }

    // Prepare SQL statement
    $query = "INSERT INTO ads (img_video, share_url, ads_start, ads_end, number_of_views,description) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($query);

    // Bind parameters and execute statement
    $stmt->execute([$img_video, $share_url, $ads_start, $ads_end, $number_of_views, $description]);

    // Check if the query was successful
    if ($stmt->rowCount() > 0) {
        $data = [
            'status' => 201,
            'message' => 'Ads Created Successfully',
        ];
        header("HTTP/1.0 201 Created");
        return json_encode($data);
    } else {
        $data = [
            'status' => 500,
            'message' => 'Failed to create ads',
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


function getAdsList() {
    global $pdo;

    $query = "SELECT * FROM ads";
    $statement = $pdo->query($query);

    if ($statement) {
        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            $data = [
                'status' => 200,
                'message' => "Ads List Fetched Successfully",
                'data' => $result
            ];
            header("HTTP/1.0 200 OK");
            return json_encode($data);
        } else {
            return error404("No Ads Found");
        }
    } else {
        return error500("Internal Server Error");
    }
}

function getAds($adsParams) {
    global $pdo;

    if (!isset($adsParams['ads_id'])) {
        return error422("Please provide Ads ads_id");
    }

    // Check if connection is valid
    if (!$pdo) {
        return error500("Database connection failed");
    }

    $adsId = htmlspecialchars($adsParams['ads_id']); // Sanitize input
    $query = "SELECT * FROM ads WHERE ads_id=?";
    $stmt = $pdo->prepare($query);
    
    try {
        $stmt->execute([$newsId]);
        $ads = $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return error500("Database Error: " . $e->getMessage());
    }

    if ($ads) {
        $data = [
            'status' => 200,
            'message' => "Ads Fetched Successfully",
            'data' => $ads,
        ];
        header("HTTP/1.0 200 OK");
        return json_encode($data);
    } else {
        return error404("Ads Not Found");
    }
}
