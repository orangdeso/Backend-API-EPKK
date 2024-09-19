<?php
header('Content-Type: application/json');
require '../config/config.php';

function generateCustomUUID() {
    $randomString = substr(str_shuffle("0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, 6); // Membuat 7 karakter acak
    return 'KP1-' . $randomString; 
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!$koneksi) {
        $response['statusCode'] = 500;
        $response['message'] = "Database connection failed.";
        $response['data'] = null;
        $response['error'] = ['message' => 'Failed to connect to database'];
        echo json_encode($response);
        exit();
    }

    $PKBN = $_POST['PKBN'];
    $PKDRT = $_POST['PKDRT'];
    $pola_asuh = $_POST['pola_asuh'];
    $id_user = $_POST['id_user'];
    $id_role = $_POST['id_role'];
    $id_organization = $_POST['id_organization'];

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);

    $uuid = generateCustomUUID();

    try {
        // Insert data ke dalam database
        $query = "INSERT INTO laporan_kader_pokja1 (uuid, id_user, PKBN, PKDRT, pola_asuh, status, created_at, updated_at, id_role, id_organization) 
                  VALUES ('$uuid', '$id_user', '$PKBN', '$PKDRT', '$pola_asuh', 'Proses', '$created_at', '$created_at', '$id_role', '$id_organization')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            $selectQuery = "
                SELECT 
                    laporan_kader_pokja1.uuid,
                    laporan_kader_pokja1.PKBN,
                    laporan_kader_pokja1.PKDRT,
                    laporan_kader_pokja1.pola_asuh,
                    laporan_kader_pokja1.status,
                    laporan_kader_pokja1.created_at,
                    laporan_kader_pokja1.updated_at,
                    role_users_mobile.uuid AS role_uuid,
                    role_users_mobile.name AS role_name,
                    role_organization.uuid AS organization_uuid,
                    role_organization.name AS organization_name
                FROM laporan_kader_pokja1
                LEFT JOIN role_users_mobile ON laporan_kader_pokja1.id_role = role_users_mobile.id
                LEFT JOIN role_organization ON laporan_kader_pokja1.id_organization = role_organization.id
                WHERE laporan_kader_pokja1.uuid = '$uuid'
            ";
            $selectResult = mysqli_query($koneksi, $selectQuery);
            $data = mysqli_fetch_assoc($selectResult);

            $response['statusCode'] = 200;
            $response['message'] = "Successfully uploaded report kader pokja I";
            $response['data'] = [
                "id" => $data['uuid'],
                "PKBN" => $data['PKBN'],
                "PKDRT" => $data['PKDRT'],
                "pola_asuh" => $data['pola_asuh'],
                "status" => $data['status'],
                "created_at" => $data['created_at'],
                "updated_at" => $data['updated_at'],
                "role" => [
                    "id" => $data['role_uuid'],
                    "name" => $data['role_name']
                ],
                "organization" => [
                    "id" => $data['organization_uuid'],
                    "name" => $data['organization_name'],
                ],
            ];
            $response['error'] = null;
        } else {
            $response['statusCode'] = 500;
            $response['message'] = "Failed to upload report kader pokja I";
            $response['data'] = null;
            $response['error'] = ['message' => 'Data insertion failed'];
        }
    } catch (Exception $e) {
        $response['statusCode'] = 500;
        $response['message'] = "An error occurred while processing the request.";
        $response['data'] = null;
        $response['error'] = ['message' => $e->getMessage()];
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
