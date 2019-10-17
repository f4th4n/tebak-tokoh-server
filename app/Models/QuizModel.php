<?php namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model {
  protected $table = 'quizzes';

  public function add($data) {
    $res = $this->db->table($this->table)->insert($data);
    return $res->connID->insert_id;
  }

  public function all() {
    $builder = $this->db->table('quizzes');
    return $builder
      ->select('quizzes.*, levels.title')
      ->join('levels', 'quizzes.level_id = levels.id')
      ->get()
      ->getResult();
  }
}