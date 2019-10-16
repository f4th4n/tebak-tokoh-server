<?php namespace App\Models;

use CodeIgniter\Model;

class LevelModel extends Model {
  protected $table = 'levels';

  public function getLevels($id = false) {
    if ($id === false) {
      return $this->findAll();
    }

    return $this->asArray()
      ->where(['id' => $id])
      ->first();
  }

  public function all() {
    return $this->asObject()->findAll();
  }
}