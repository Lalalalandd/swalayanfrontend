<?php
require '../vendor/autoload.php';

use GuzzleHttp\Exception\RequestException;

if (isset($_GET["fnip"]) && $_GET["fnip"] != "") {
    $employeeEndpoint = 'http://localhost:8090/api/employee/' . $_GET["fnip"];
} else {
    $employeeEndpoint = "http://localhost:8090/api/employee";
}

$client = new \GuzzleHttp\Client();

try {
    // Lakukan permintaan dengan Guzzle
    $response = $client->request('GET', $employeeEndpoint, [
        'headers' => [
            'Authorization' => 'Bearer ' . $_SESSION['accessToken'],
            'Content-Type' => 'application/json',
        ]
    ]);
    $data = json_decode($response->getBody(), true);

    if(!isset($data['nip'])) {
        foreach ($data as $employee) {
            echo '<tr>';
            echo '<td>' . $employee['nip'] . '</td>';
            echo '<td>' . $employee['name'] . '</td>';
            echo '<td>' . $employee['username'] . '</td>';
            echo '<td>' . $employee['address'] . '</td>';
            echo '<td>' . $employee['number_phone'] . '</td>';
            echo '<td>' . $employee['dept_name'] . '</td>';
            echo '<td>' . $employee['position'] . '</td>';
            echo '<td>
            <button class="btn btn-info" style="margin-bottom: 0px; border: none; width: 100%;" data-toggle="modal" data-target="#detailsModal" onclick="showDetails(this)" data="' . str_replace("\"", "'", json_encode($employee['roles'])) . '">Details</button> 
            </td>';
            echo '<td><a href="?delete=' . $employee['nip'] . '" onclick="return confirm_alert(this);" class="btn btn-danger">Delete</a></td>';
            echo '<td><a href="employee-edit.php?edit=' . $employee['nip'] . '" class="btn btn-warning">Edit</a></td>';

            echo '</tr>';
        }
    }else{
        
        echo '<tr>';
        echo '<td>' . $data['nip'] . '</td>';
        echo '<td>' . $data['name'] . '</td>';
        echo '<td>' . $data['username'] . '</td>';
        echo '<td>' . $data['address'] . '</td>';
        echo '<td>' . $data['number_phone'] . '</td>';
        echo '<td>' . $data['dept_name'] . '</td>';
        echo '<td>' . $data['position'] . '</td>';
        echo '<td>
            <button class="btn btn-info" style="margin-bottom: 0px; border: none; width: 100%;" data-toggle="modal" data-target="#detailsModal" onclick="showDetails(this)" data="' . str_replace("\"", "'", json_encode($data['roles'])) . '">Details</button> 
            </td>';
        echo '<td><a href="?delete=' . $data['nip'] . '" onclick="return confirm_alert(this);" class="btn btn-danger">Delete</a></td>';
        echo '<td><a href="employee-edit.php?edit=' . $data['nip'] . '" class="btn btn-warning">Edit</a></td>';
        echo '</tr>';
    }
    
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Jika terjadi kesalahan saat melakukan permintaan, tangani di sini
    echo "Error: " . $e->getMessage();
}


if (isset($_GET['delete'])) {
    $nip = $_GET['delete'];
    // Panggil fungsi atau lakukan permintaan DELETE untuk menghapus data incoming products berdasarkan ID
    $isDeleted = deletEmployeebyNIP($nip);
    // Setelah menghapus, Anda dapat melakukan redirect kembali ke halaman ini.
    echo "<script>window.location.href='employee-all.php'</script>";
    exit;
}

function deletEmployeebyNIP($nip_employee)
{
    $baseUri = 'http://localhost:8090'; // Ganti dengan base URL API yang sesuai
    $endpoint = '/api/employee/' . $nip_employee; // Ganti dengan endpoint sesuai dengan API yang Anda gunakan

    $client = new \GuzzleHttp\Client(['base_uri' => $baseUri]);

    try {
        $response = $client->request('DELETE', $endpoint, [
            'headers' => [
                'Authorization' => 'Bearer ' . $_SESSION['accessToken'],
                'Content-Type' => 'application/json',
            ],
        ]);

        // Jika data produk berhasil dihapus, kembalikan true
        return true;
    } catch (RequestException $e) {
        // Tangani kesalahan permintaan API di sini, misalnya koneksi gagal atau respons tidak berhasil (404, 500, dsb.)
        return false;
    }
}
