<?php namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model {
  protected $table = 'users';
  protected $primaryKey = 'id';
  protected $allowedFields = [
    'uid',
    'email',
    'display_name',
    'photo_url',
    'token'
  ];

  public function upsert($data) {
    $row = $this->where('uid', $data['uid'])->first();
    if($row) {
      $this->update($row['id'], $data);
    } else {
      $res = $this->db->table($this->table)->insert($data);
      return $res->connID->insert_id;
    }
  }
}
