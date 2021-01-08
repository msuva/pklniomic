<?php namespace app\Controllers;

use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\API\ResponseTrait;
use App\Models\Produkmodel;

class Produks extends ResourceController{
  use ResponseTrait;
    // get produkk
  public function index(){
    $model = new Produkmodel();
    $data = $model->findAll();
    return $this->respond($data, 200);
  }

    // get satu produkk
  public function show($id = null){
    $model = new Produkmodel();
    $data = $model->getWhere(['id_produk' => $id])->getResult();

    if($data){
      return $this->respond($data);
    }else{
        return $this->failNotFound('Tidak ditemukan'.$id);
    }
  }

  //create yang lain
  public function create(){
    $model = new Produkmodel();
    $file = $this->request->getFile('fitur_file');

    $file->move(WRITEPATH.'uploads');

    $data = [
      'nama_produk' => $this->request->getPost('nama_produk'),
      'harga_produk' => $this->request->getPost('harga_produk'),
      'fitur_file' => $file->getName('fitur_file')
    ];
    $model->insert($data);
    return $this->respondCreated($data);
  }

  // update produkk
  public function update($id = null){
    $model = new Produkmodel();
    $json = $this->request->getJSON();

    if($json){
      $data = [
        'nama_produk' => $json->nama_produk,
        'harga_produk' => $json->harga_produk
      ];
    }else{
      $input = $this->request->getRawInput();
      $data = [
        'nama_produk' => $input['nama_produk'],
        'harga_produk' => $input['harga_produk']
      ];
    }

    $model->update($id, $data);
    $response = [
      'status'   => 200,
      'error'    => null,
      'messages' => [
        'success' => 'Data terupdate'
      ]
    ];
    return $this->respond($response);
  }

  // delete produkk
  public function delete($id = null){
    helper('filesystem');
    $model = new Produkmodel();
    $data = $model->find($id);

    if($data){
      delete_files(WRITEPATH.'uploads/'. $data->fitur_file);
      $model->delete($id);
      $response = [
        'status'   => 200,
        'error'    => null,
        'messages' => [
          'success' => 'Data terhapus'
        ]
      ];
      return $this->respondDeleted($response);
    }else{
      return $this->failNotFound('Tidak ditemukan produk dengan id tersebut'.$id);
    }
  }
}
?>
