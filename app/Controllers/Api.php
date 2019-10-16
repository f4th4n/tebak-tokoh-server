<?php namespace App\Controllers;
use App\Models\QuizModel;

class Api extends BaseController {
  public function index() {
    $quiz_model = new QuizModel();
    $rows = $quiz_model->getQuizzes();
    return json_encode($rows);
  }

  //--------------------------------------------------------------------

}
