<?php
require '../vendor/autoload.php';

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;

if (isset($_GET["fnip"]) && $_GET["fnip"] != "") {
    $productEndpoint = 'http://103.183.74.79:8091/api/product/' . $_GET["fnip"];
} else {
    $productEndpoint = "http://103.183.74.79:8091/api/product";
}

$client = new \GuzzleHttp\Client();

try {
    $response = $client->get($productEndpoint, [
        'headers' => [
            'Authorization' => 'Bearer ' . $_SESSION['accessToken'], // Ganti dengan token akses Anda
            'Content-Type' => 'application/json',
        ],
    ]);

    $data = json_decode($response->getBody(), true);

    if (!isset($data['id'])) {
        foreach ($data as $product) {
            echo '<tr>';
            echo '<td>' . $product['id'] . '</td>';
            echo '<td>' . $product['name'] . '</td>';
            echo '<td>' . $product['price'] . '</td>';
            echo '<td>' . $product['product_desc'] . '</td>';
            echo '<td>' . $product['stock'] . '</td>';
            echo '<td><a href="product-edit.php?edit=' . $product['id'] . '" class="btn btn-warning">Edit</a></td>';
            echo '<td><a href="?delete=' . $product['id'] . '" onclick="return confirm_alert(this);" class="btn btn-danger">Delete</a></td>';
            echo '</tr>';
        }
    }else{
        
            echo '<tr>';
            echo '<td>' . $data['id'] . '</td>';
            echo '<td>' . $data['name'] . '</td>';
            echo '<td>' . $data['price'] . '</td>';
            echo '<td>' . $data['product_desc'] . '</td>';
            echo '<td>' . $data['stock'] . '</td>';
            echo '<td><a href="product-edit.php?edit=' . $data['id'] . '" class="btn btn-warning">Edit</a></td>';
            echo '<td><a href="?delete=' . $data['id'] . '" onclick="return confirm_alert(this);" class="btn btn-danger">Delete</a></td>';
            echo '</tr>';
    }
    

    // Tampilkan data di halaman web
    
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Jika terjadi kesalahan saat melakukan permintaan, tangani di sini
    echo "Error: " . $e->getMessage();
}



if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    // Panggil fungsi atau lakukan permintaan DELETE untuk menghapus data incoming products berdasarkan ID
    $isDeleted = deleteProductById($id);
    // Setelah menghapus, Anda dapat melakukan redirect kembali ke halaman ini.
    echo "<script>window.location.href='product-all.php'</script>";
    exit;
}

function deleteProductById($id_product)
{
    $baseUri = 'http://103.183.74.79:8091'; // Ganti dengan base URL API yang sesuai
    $endpoint = '/api/product/' . $id_product; // Ganti dengan endpoint sesuai dengan API yang Anda gunakan

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
