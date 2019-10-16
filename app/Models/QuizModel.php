<?php namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model {
  protected $table = 'quizzes';

  public function add($data) {
    $res = $this->db->table($this->table)->insert($data);
    return $res->connID->insert_id;
  }

  public function getQuizzes($level = false) {
    if ($level === false) {
      return $this->findAll();
    }

    return $this->asArray()
    ->where(['level' => $level])
    ->first();
  }

  public function all() {
    $builder = $this->db->table('quizzes');
    return $builder
      ->join('levels', 'quizzes.level_id = levels.id')
      ->get()
      ->getResult();
  }
}