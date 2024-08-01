<?php
session_start(); // Memulai session untuk menggunakan $_SESSION

// Menyertakan file koneksi untuk menghubungkan ke database
include "koneksi.php";

// Memeriksa koneksi database
if (!$db) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

// Menulis query SQL untuk mengambil semua data dari tabel 'barang'
$sql = "SELECT * FROM barang";

// Menjalankan query dan menyimpan hasilnya ke dalam variabel $query
$query = mysqli_query($db, $sql);

// Mengecek apakah query berhasil dijalankan
if (!$query) {
    die("Query gagal: " . mysqli_error($db));
}

// Mengecek apakah jumlah baris hasil query lebih dari 0
if ($query->num_rows > 0) {
    // Jika ada data, mulai membuat tabel HTML dengan border
    echo "<a href='tambah.php'>Tambah barang</a><br><br>";
    
    // Mengecek jika ada pesan dalam session dan menampilkannya
    if (isset($_SESSION['pesan'])) {
        echo htmlspecialchars($_SESSION['pesan']); // Menampilkan pesan
        unset($_SESSION['pesan']); // Menghapus pesan dari session setelah ditampilkan
    }
    
    // Membuat tabel HTML
    echo "
    <table border='1'>
        <tr>
            <th>No</th> <!-- Kolom untuk nomor urut -->
            <th>Nama Barang</th> <!-- Kolom untuk nama barang -->
            <th>Harga Barang</th> <!-- Kolom untuk harga barang -->
            <th>Stok Barang</th> <!-- Kolom untuk stok barang -->
            <th>Action</th> <!-- Kolom untuk aksi edit dan hapus -->
        </tr>
    ";

    // Mengambil setiap baris data hasil query dan menampilkannya di dalam tabel
    while ($data = mysqli_fetch_assoc($query)) {
        $id_barang = htmlspecialchars($data['id_barang']);
        $nama_barang = htmlspecialchars($data['nama_barang']);
        $harga_barang = htmlspecialchars($data['harga_barang']);
        $stok_barang = htmlspecialchars($data['stok_barang']);
        
        echo "
        <tr>
            <td>{$id_barang}</td> <!-- Menampilkan ID barang -->
            <td>{$nama_barang}</td> <!-- Menampilkan nama barang -->
            <td>{$harga_barang}</td> <!-- Menampilkan harga barang -->
            <td>{$stok_barang}</td> <!-- Menampilkan stok barang -->
            <td>
                <a href='edit.php?id={$id_barang}'>Edit</a> | 
                <a href='hapus.php?id={$id_barang}'>Hapus</a>
            </td> <!-- Link untuk aksi edit dan hapus -->
        </tr>
        ";
    }
    
    // Menutup tag tabel setelah semua data ditampilkan
    echo "</table>";
} else {
    echo "Tidak ada data yang ditemukan.";
}

// Menutup koneksi database
mysqli_close($db);
?>
