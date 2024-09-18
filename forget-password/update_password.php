<?php
header('Content-Type: application/json');
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'PUT') {
    parse_str(file_get_contents("php://input"), $_PUT);
    $phone_number = $_PUT["phone_number"];
    $new_password = $_PUT["password"];

    $stmt = $koneksi->prepare("SELECT password FROM users_mobile WHERE phone_number = ?");
    $stmt->bind_param("s", $phone_number);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $old_password_hashed = $user['password'];

        if (password_verify($new_password, $old_password_hashed)) {
            $response = [
                'statusCode' => 400,
                'message' => 'New password cannot be the same as the old password.',
                'data' => null,
                'error' => ['message' => 'No changes made.']
            ];
        } else {
            $hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            $stmt_update = $koneksi->prepare("UPDATE users_mobile SET password = ? WHERE phone_number = ?");
            $stmt_update->bind_param("ss", $hashed_password, $phone_number);
            $stmt_update->execute();

            $check = $stmt_update->affected_rows;

            if ($check > 0) {
                $response = [
                    'statusCode' => 200,
                    'message' => 'Password updated successfully.',
                    'data' => [],
                    'error' => null
                ];
            } else {
                $response = [
                    'statusCode' => 404,
                    'message' => 'Phone number not found or no changes made.',
                    'data' => null,
                    'error' => ['message' => 'User with this phone number was not found.']
                ];
            }

            $stmt_update->close();
        }
    } else {
        $response = [
            'statusCode' => 404,
            'message' => 'Phone number not found.',
            'data' => null,
            'error' => ['message' => 'User with this phone number was not found.']
        ];
    }

    echo json_encode($response);

    $stmt->close();
    $koneksi->close();
}
