<?php
session_start(); 
header('Content-Type: application/json');

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$response = ["success" => false, "message" => ""];

try {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password');

    if (empty($email) || empty($password)) {
        http_response_code(400);
        throw new Exception("Email and password are required.");
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(401);
        throw new Exception("Invalid credentials. Please try again.");
    }

    $stmt = mysqli_prepare($conn, "SELECT student_id, first_name, last_name, email, password_hash FROM students WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $user_id = null;
    $first_name = null;
    $last_name = null;
    $db_email = null;
    $password_hash = null;
    
    mysqli_stmt_bind_result($stmt, $user_id, $first_name, $last_name, $db_email, $password_hash);
    mysqli_stmt_fetch($stmt); 
    mysqli_stmt_close($stmt);

    if (!$user_id || !password_verify($password, $password_hash)) {
        http_response_code(401);
        $response['error_code'] = 'INVALID_CREDENTIALS'; 
        throw new Exception("Invalid email or password.");
    }

    $_SESSION['user_id'] = $user_id;
    $_SESSION['first_name'] = $first_name;
    $_SESSION['last_name'] = $last_name;
    $_SESSION['email'] = $db_email;

    $response['success'] = true;
    $response['message'] = "Login successful! Redirecting to dashboard...";

} catch (Exception $e) {
    if (http_response_code() < 400) {
        http_response_code(500); 
    }
    $response['success'] = false;
    $response['message'] = $e->getMessage();
    
    if (isset($response['error_code'])) {
        $response['message'] = $response['error_code'];
    }
}

echo json_encode($response);
?>