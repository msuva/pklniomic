<?php namespace app\Models;

use CodeIgniter\Model;

class Produkmodel extends Model{
  protected $table = 'produks';
  protected $primaryKey = 'id_produk';
  protected $allowedFields = ['nama_produk', 'harga_produk', 'fitur_file'];
}
?>
