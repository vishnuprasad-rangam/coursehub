<?php
header('Content-Type: application/json');

require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    http_response_code(405);
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
    exit;
}

$response = ["success" => false, "message" => ""];
$errors = [];

try {
    $inputs = [
        'firstName' => filter_input(INPUT_POST, 'firstName', FILTER_SANITIZE_SPECIAL_CHARS),
        'lastName' => filter_input(INPUT_POST, 'lastName', FILTER_SANITIZE_SPECIAL_CHARS),
        'email' => filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL),
        'gender' => filter_input(INPUT_POST, 'gender', FILTER_SANITIZE_SPECIAL_CHARS),
        'birthdate' => filter_input(INPUT_POST, 'birthdate', FILTER_SANITIZE_SPECIAL_CHARS),
        'state' => filter_input(INPUT_POST, 'state', FILTER_SANITIZE_SPECIAL_CHARS),
        'pincode' => filter_input(INPUT_POST, 'pincode', FILTER_SANITIZE_SPECIAL_CHARS),
        'password' => filter_input(INPUT_POST, 'password'),
        'terms' => filter_input(INPUT_POST, 'terms'),
    ];

    $required_fields = ['firstName', 'email', 'gender', 'birthdate', 'state', 'pincode', 'password'];
    foreach ($required_fields as $field) {
        if (empty($inputs[$field])) {
            $errors[] = ucfirst($field) . " is required.";
        }
    }

    if (!filter_var($inputs['email'], FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid email format.";
    }
    
    if (!preg_match('/^[1-9]\d{5}$/', $inputs['pincode'])) {
        $errors[] = "Invalid pincode format (must be 6 digits and not start with 0).";
    }

    if ($inputs['terms'] !== 'on') {
        $errors[] = "You must agree to the Terms & Conditions.";
    }
    
    if (!empty($errors)) {
        throw new Exception(implode(" ", $errors));
    }

    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) FROM students WHERE email = ?");
    mysqli_stmt_bind_param($stmt, "s", $inputs['email']);
    mysqli_stmt_execute($stmt);
    
    $count = 0;
    mysqli_stmt_bind_result($stmt, $count);
    mysqli_stmt_fetch($stmt); 
    mysqli_stmt_close($stmt);

    if ($count > 0) {
        throw new Exception("An account with this email already exists. Please log in.");
    }

    $password_hash = password_hash($inputs['password'], PASSWORD_BCRYPT);

    $sql = "INSERT INTO students (first_name, last_name, email, password_hash, gender, date_of_birth, state, pincode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);

    mysqli_stmt_bind_param($stmt, "ssssssss", 
        $inputs['firstName'], 
        $inputs['lastName'], 
        $inputs['email'], 
        $password_hash, 
        $inputs['gender'], 
        $inputs['birthdate'], 
        $inputs['state'], 
        $inputs['pincode']
    );

    if (mysqli_stmt_execute($stmt)) {
        $response['success'] = true;
        $response['message'] = "Account created successfully! Redirecting to login...";
    } else {
        throw new Exception("Database insertion failed: " . mysqli_error($conn));
    }

    mysqli_stmt_close($stmt);

} catch (Exception $e) {
    http_response_code(400);
    $response['success'] = false;
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
?>