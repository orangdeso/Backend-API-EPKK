<?php
header('Content-Type: application/json');
require '../../config/config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $idUser = $_GET['id_user'];

    // Pagination setup
    $limit = isset($_GET['limit']) ? intval($_GET['limit']) : 10; 
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $offset = ($page - 1) * $limit;

    // Query untuk mendapatkan data laporan kader pokja1 berdasarkan id_user
    $perintah = "
        SELECT 
            laporan_kader_pokja1.uuid AS uuid_laporan, 
            laporan_kader_pokja1.PKBN, 
            laporan_kader_pokja1.PKDRT, 
            laporan_kader_pokja1.pola_asuh,
            laporan_kader_pokja1.catatan, 
            laporan_kader_pokja1.status, 
            laporan_kader_pokja1.created_at, 
            laporan_kader_pokja1.updated_at,
            role_users_mobile.uuid AS role_uuid,
            role_users_mobile.name AS role_name,
            role_organization.uuid AS organization_uuid,
            role_organization.name AS organization_name,
            users_mobile.uuid AS user_uuid,
            users_mobile.full_name AS user_full_name,
            users_mobile.phone_number AS user_phone_number
        FROM laporan_kader_pokja1
        LEFT JOIN role_users_mobile ON laporan_kader_pokja1.id_role = role_users_mobile.id
        LEFT JOIN role_organization ON laporan_kader_pokja1.id_organization = role_organization.id
        LEFT JOIN users_mobile ON laporan_kader_pokja1.id_user = users_mobile.id
        WHERE laporan_kader_pokja1.id_user = '$idUser' 
        ORDER BY laporan_kader_pokja1.created_at DESC
        LIMIT $limit OFFSET $offset";

    $eksekusi = mysqli_query($koneksi, $perintah);
    $cek = mysqli_num_rows($eksekusi); 

    if ($cek > 0) {
        $response["statusCode"] = 200;
        $response["message"] = "History Report Kader Pokja I Available";
        $response["content"] = array();

        while ($ambil = mysqli_fetch_assoc($eksekusi)) {
            $F = array(
                "id" => $ambil['uuid_laporan'],
                "PKBN" => $ambil['PKBN'],
                "PKDRT" => $ambil['PKDRT'],
                "pola_asuh" => $ambil['pola_asuh'],
                "catatan" => $ambil['catatan'],
                "status" => $ambil['status'],
                "created_at" => $ambil['created_at'],
                "updated_at" => $ambil['updated_at'],
                "user" => [
                    "id" => $ambil['user_uuid'],
                    "fullName" => $ambil['user_full_name'],
                    "phoneNumber" => $ambil['user_phone_number']
                ],
                "role" => [
                    "id" => $ambil['role_uuid'],
                    "name" => $ambil['role_name']
                ],
                "organization" => [
                    "id" => $ambil['organization_uuid'],
                    "name" => $ambil['organization_name']
                ],
            );
            array_push($response["content"], $F);
        }

        // Menghitung total data
        $countQuery = "SELECT COUNT(*) as total FROM laporan_kader_pokja1 WHERE id_user = '$idUser'";
        $countResult = mysqli_query($koneksi, $countQuery);
        $totalData = mysqli_fetch_assoc($countResult)['total'];

        // Pagination response
        $response["content"] = [
            "data" => $response["content"],
            "totalData" => $totalData,
            "totalPage" => ceil($totalData / $limit)
        ];
        $response["error"] = null; // Tidak ada error
    } else {
        $response["statusCode"] = 404;
        $response["message"] = "History report Kader Pokja I Not Found!";
        $response["content"] = [
            "data" => [],
            "totalData" => 0,
            "totalPage" => 0
        ];
        $response["error"] = null;
    }
} else {
    $response["statusCode"] = 405;
    $response["message"] = "Method not permitted";
    $response["content"] = [
        "data" => [],
        "totalData" => 0,
        "totalPage" => 0
    ];
    $response["error"] = array(
        "code" => 405,
        "message" => "Only the GET method is allowed"
    );
}

echo json_encode($response);
mysqli_close($koneksi);
