<?php namespace App\Controllers;
use App\Models\QuizModel;
use App\Models\LevelModel;
use App\Libraries\Session;

class AdminLevel extends BaseController {
  function __construct() {
    $this->session = session();
    $this->quiz_model = new QuizModel();
    $this->level_model = new LevelModel();
  }

  private function _is_login() {
    return $this->session->role === 'admin';
  }

  public function list() {
    $levels = $this->level_model->all();
    $data = array(
      'levels' => $levels
    );
    return view('admin/levels/list', $data);
  }

  public function add() {
    if($this->request->getPost('title')) {
      $this->_save_level();
      return redirect()->to('/admin/levels');
    }

    return view('admin/levels/add');
  }

  private function _save_level() {
    $quiz = array();
    $quiz['title'] = $this->request->getPost('title');

    $quiz_id = $this->level_model->add($quiz);
    return $quiz_id;
  }
}