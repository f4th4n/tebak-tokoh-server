<?php namespace App\Controllers;
use App\Models\QuizModel;
use App\Models\LevelModel;

class Api extends BaseController {
  public function data() {
    $quiz_model = new QuizModel();
    $level_model = new LevelModel();
    $data = [
      'quizzes' => $quiz_model->find(),
      'levels' => $level_model->find(),
    ];
    return json_encode($data);
  }

  public function lastQuiz() {
    $quiz_model = new QuizModel();
    $data = [
      'last_quiz' => $quiz_model->last_quiz()->id
    ];
    return json_encode($data);
  }
}
