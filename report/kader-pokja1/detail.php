<?php
header('Content-Type: application/json');
require '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['id'])) {
        $id = $_GET['id'];

        // Query untuk mendapatkan data berdasarkan UUID
        $perintah = "
            SELECT 
                laporan_kader_pokja1.uuid AS laporan_uuid,
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
            WHERE laporan_kader_pokja1.uuid = '$id'";
        $eksekusi = mysqli_query($koneksi, $perintah);
        $cek = mysqli_num_rows($eksekusi); 

        if ($cek > 0) {
            $response["statusCode"] = 200;
            $response["message"] = "Report data kader pokja I with ID: $id available";
            $response["content"] = array();

            // Mendapatkan data laporan
            while ($ambil = mysqli_fetch_assoc($eksekusi)) {
                $F = array(
                    "id" => $ambil['laporan_uuid'],
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
                    ]
                );
                array_push($response["content"], $F);
            }
            $response["error"] = null; // Tidak ada error
        } else {
            // Jika data tidak ditemukan
            $response["statusCode"] = 404;
            $response["message"] = "Data Tidak Tersedia";
            $response["content"] = null;
            $response["error"] = null;
        }
    } else {
        // Jika parameter UUID tidak ada
        $response["statusCode"] = 400;
        $response["message"] = "Parameter UUID not found";
        $response["content"] = null;
        $response["error"] = array("message" => "Please provide a valid UUID.");
    }
}

echo json_encode($response);
mysqli_close($koneksi);
