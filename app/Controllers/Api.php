<?php namespace App\Controllers;
use App\Models\QuizModel;
use App\Models\LevelModel;
use App\Models\UserModel;

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

  public function login() {
    $user_model = new UserModel();
    $post_data = $this->request->getJSON();
    $data = [
      'uid' => $post_data->uid,
      'email' => $post_data->email,
      'display_name' => $post_data->displayName,
      'photo_url' => $post_data->photoURL,
      'token' => $post_data->auth->idToken
    ];
    $user_model->upsert($data);
    return json_encode($data);
  }
}
