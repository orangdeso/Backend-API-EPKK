<?php
header('Content-Type: application/json');
require '../config/config.php';
require_once __DIR__ . '/../vendor/autoload.php'; // Autoload jika menggunakan library

use Ramsey\Uuid\Uuid;

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
    $tanggal = date('Y-m-d');

    date_default_timezone_set('Asia/Jakarta');
    $timestamp = time();
    $created_at = date("Y-m-d H:i:s", $timestamp);
    $waktu = date("H:i", $timestamp);

    // Custom UUID dengan format 'KP1'
    $uuid = 'KP1-' . Uuid::uuid4()->toString();

    try {
        // Insert data ke dalam database
        $query = "INSERT INTO laporan_kader_pokja1 (uuid, PKBN, PKDRT, pola_asuh, status, tanggal, waktu, created_at, updated_at, id_user, id_role, id_organization) 
                  VALUES ('$uuid', '$PKBN', '$PKDRT', '$pola_asuh', 'Proses', '$tanggal', '$waktu', '$created_at', '$created_at', '$id_user', '$id_role', '$id_organization')";

        $result = mysqli_query($koneksi, $query);
        $check = mysqli_affected_rows($koneksi);

        if ($check > 0) {
            // Ambil data yang baru saja dimasukkan berdasarkan UUID
            $selectQuery = "
                SELECT 
                    laporan_kader_pokja1.uuid,
                    laporan_kader_pokja1.PKBN,
                    laporan_kader_pokja1.PKDRT,
                    laporan_kader_pokja1.pola_asuh,
                    laporan_kader_pokja1.status,
                    laporan_kader_pokja1.tanggal,
                    laporan_kader_pokja1.waktu,
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

            // Response jika berhasil
            $response['statusCode'] = 200;
            $response['message'] = "Successfully uploaded laporan kader pokja I";
            $response['data'] = [
                "uuid" => $data['uuid'],
                "PKBN" => $data['PKBN'],
                "PKDRT" => $data['PKDRT'],
                "pola_asuh" => $data['pola_asuh'],
                "status" => $data['status'],
                "tanggal" => $data['tanggal'],
                "waktu" => $data['waktu'],
                "created_at" => $data['created_at'],
                "updated_at" => $data['updated_at'],
                "role" => [
                    "uuid" => $data['role_uuid'],
                    "name" => $data['role_name']
                ],
                "organization" => [
                    "uuid" => $data['organization_uuid'],
                    "name" => $data['organization_name']
                ]
            ];
            $response['error'] = null;
        } else {
            // Jika insert gagal (misal data tidak berhasil dimasukkan)
            $response['statusCode'] = 500;
            $response['message'] = "Failed to upload laporan kader pokja I";
            $response['data'] = null;
            $response['error'] = ['message' => 'Data insertion failed'];
        }
    } catch (Exception $e) {
        // Jika terjadi exception
        $response['statusCode'] = 500;
        $response['message'] = "An error occurred while processing the request.";
        $response['data'] = null;
        $response['error'] = ['message' => $e->getMessage()];
    }

    echo json_encode($response);
    mysqli_close($koneksi);
}
