<?php
header('Content-Type: application/json');
require '../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['phone_number'])) {
        $phone_number = $_GET['phone_number'];
        
        try {
            $stmt = $koneksi->prepare("SELECT uuid, phone_number, full_name, password, kode_otp, status, created_at, updated_at, id_subdistrict, id_village, id_role, id_organization FROM users_mobile WHERE phone_number = ?");
            $stmt->bind_param("s", $phone_number);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                $data = $result->fetch_assoc();

                $response = [
                    'statusCode' => 200,
                    'message' => 'Phone number found.',
                    'data' => [
                        'id' => $data['uuid'],  
                        'phone_number' => $data['phone_number'],
                        'full_name' => $data['full_name'],
                    ],
                    'error' => null
                ];
            } else {
                $response = [
                    'statusCode' => 404,
                    'message' => 'Phone number not found.',
                    'data' => null,
                    'error' => ['message' => 'No user found with this phone number.']
                ];
            }

            $stmt->close();

        } catch (Exception $e) {
            $response = [
                'statusCode' => 500,
                'message' => $e->getMessage(),
                'data' => null,
                'error' => ['message' => 'Error while fetching data.']
            ];
        }

        echo json_encode($response);

    } else {
        $response = [
            'statusCode' => 400,
            'message' => 'Phone number is required.',
            'data' => null,
            'error' => ['message' => 'Please provide a phone number.']
        ];
        echo json_encode($response);
    }

    mysqli_close($koneksi);
}
