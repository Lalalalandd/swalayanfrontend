<?php
require '../vendor/autoload.php';

use GuzzleHttp\Exception\RequestException;

$transactionEndpoint = $endpoint; 
$client = new \GuzzleHttp\Client();
try {

    // Tampilkan data di halaman web
    if (isset ($productData["id_incomingproduct"])){
        echo '<tr>';
        echo '<td>' . $productData['id_incomingproduct'] . '</td>';
        echo '<td>' . $productData['nip'] . '</td>';
        echo '<td>' . $productData['day'] . '</td>';
        echo '<td>' . $productData['month'] . '</td>';
        echo '<td>' . $productData['year'] . '</td>';
        echo '<td>' . $productData['time'] . '</td>';
        echo '<td>
            <button class="btn btn-info" style="margin-bottom: 0px; border: none; width: 100%;" data-toggle="modal" data-target="#detailsModal" onclick="showDetails(this)" data="' . str_replace("\"", "'", json_encode($productData['transactionItems'])) . '">Details</button> 
            </td>';
        echo '<td><a href="?delete=' . $productData['id_incomingproduct'] . '" class="btn btn-danger">Delete</a></td>';

        echo '</tr>';
    }else{
            foreach ($productData as $incoming) {
                echo '<tr>';
                echo '<td>' . $incoming['id_incomingproduct'] . '</td>';
                echo '<td>' . $incoming['nip'] . '</td>';
                echo '<td>' . $incoming['day'] . '</td>';
                echo '<td>' . $incoming['month'] . '</td>';
                echo '<td>' . $incoming['year'] . '</td>';
                echo '<td>' . $incoming['time'] . '</td>';
                echo '<td>
                    <button class="btn btn-info" style="margin-bottom: 0px; border: none; width: 100%;" data-toggle="modal" data-target="#detailsModal" onclick="showDetails(this)" data="' . str_replace("\"", "'", json_encode($incoming['transactionItems'])) . '">Details</button> 
                    </td>';
                echo '<td><a href="?delete=' . $incoming['id_incomingproduct'] . '" class="btn btn-danger">Delete</a></td>';

                echo '</tr>';
            }
        }
} catch (\GuzzleHttp\Exception\RequestException $e) {
    echo "Error: " . $e->getMessage();
}

if (isset($_GET['delete'])) {
    $incomingId = $_GET['delete'];
    // Panggil fungsi atau lakukan permintaan DELETE untuk menghapus data incoming products berdasarkan ID
    $isDeleted = deleteIncomingProductById($incomingId);
    // Setelah menghapus, Anda dapat melakukan redirect kembali ke halaman ini.
    echo "<script>window.location.href='incoming_product-all.php'</script>";
    exit;
}

function deleteIncomingProductById($id_incomingproduct)
{
    $baseUri = 'http://103.176.78.115:8093'; // Ganti dengan base URL API yang sesuai
    $endpoint = '/api/incoming-products/' . $id_incomingproduct; // Ganti dengan endpoint sesuai dengan API yang Anda gunakan

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
