<?php
require '../vendor/autoload.php';
use GuzzleHttp\Exception\RequestException;
            
$transactionEndpoint = $endpoint; 
$client = new \GuzzleHttp\Client();

try {
    // Lakukan permintaan dengan Guzzle
    // $response = $client->request('GET', $transactionEndpoint, [
    //     'headers' => [
    //         'Authorization' => 'Bearer ' . $jwtToken,
    //         'Content-Type' => 'application/json', 
    //     ]
    //     ]);
  
    // $data = json_decode($response->getBody(), true);

    // Tampilkan data di halaman web
    foreach ($productData as $transaction) {
      echo '<tr>';
      echo '<td>' . $transaction['id_trans'] . '</td>';
      echo '<td>' . $transaction['nip'] . '</td>';
      echo '<td>' . $transaction['day'] . '</td>';
      echo '<td>' . $transaction['month'] . '</td>';
      echo '<td>' . $transaction['year'] . '</td>';
      echo '<td>' . $transaction['time'] . '</td>';
      echo '<td>' . $transaction['total_amount'] . '</td>';
      echo '<td>
            <button class="btn btn-info" style="margin-bottom: 0px; border: none; width: 100%;" data-toggle="modal" data-target="#detailsModal" onclick="showDetails(this)" data="' . str_replace("\"", "'", json_encode($transaction['transactionItems'])) . '">Details</button> 
            </td>';
            echo '<td><a href="?delete=' . $transaction['id_trans'] . '" class="btn btn-danger">Delete</a></td>';
      
      echo '</tr>';
  }
   
} catch (\GuzzleHttp\Exception\RequestException $e) {
    // Jika terjadi kesalahan saat melakukan permintaan, tangani di sini
    echo "Error: " . $e->getMessage();
}


if (isset($_GET['delete'])) {
    $transactionId = $_GET['delete'];
    // Panggil fungsi atau lakukan permintaan DELETE untuk menghapus data incoming products berdasarkan ID
    $isDeleted = deleteIncomingProductById($transactionId);
    // Setelah menghapus, Anda dapat melakukan redirect kembali ke halaman ini.
    echo "<script>window.location.href='transaction-all.php'</script>";
    exit;
}

function deleteIncomingProductById($id_transaction)
{
    $baseUri = 'http://103.176.78.115:8092'; // Ganti dengan base URL API yang sesuai
    $endpoint = '/api/transaction/' . $id_transaction; // Ganti dengan endpoint sesuai dengan API yang Anda gunakan

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

