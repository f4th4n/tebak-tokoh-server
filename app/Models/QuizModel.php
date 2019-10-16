<?php namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model {
  protected $table = 'quizzes';

  public function getQuizzes($level = false) {
    if ($level === false) {
      return $this->findAll();
    }

    return $this->asArray()
    ->where(['level' => $level])
    ->first();
  }
}