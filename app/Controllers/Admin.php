<?php namespace App\Controllers;
use App\Models\QuizModel;
use App\Models\LevelModel;
use App\Libraries\Session;

define('ADMIN_USER', 'adminzz');
define('ADMIN_PASSWORD', 'if9d923ffasFF');
define('SHARE_SIDE', 1000);
define('NORMAL_SIDE', 400);
define('THUMB_SIDE', 100);

class Admin extends BaseController {
  function __construct() {
    $this->session = session();
    $this->quiz_model = new QuizModel();
    $this->level_model = new LevelModel();
  }

  private function _is_login() {
    return $this->session->role === 'admin';
  }

  public function index() {
    if(!$this->_is_login()) return redirect()->to('/admin/login');

    return view('admin/index');
  }

  public function login() {
    if($this->_is_login()) return redirect()->to('/admin');

    if($this->request->getPost('user')) {
      if($this->request->getPost('user') == ADMIN_USER && $this->request->getPost('password') == ADMIN_PASSWORD) {
        $userdata = array('role' => 'admin');
        $this->session->set($userdata);
        return redirect()->to('/admin');
      }
    }

    return view('admin/login');
  }

  public function quizzes() {
    $quizzes = $this->quiz_model->all();
    $data = array(
      'quizzes' => $quizzes
    );
    return view('admin/quizzes', $data);
  }

  public function add_quiz() {
    if($this->request->getPost('level_id')) {
      $this->_save_quiz();
      return redirect()->to('/admin/quizzes');
    }

    $levels = $this->level_model->all();
    $data = array(
      'levels' => $levels
    );
    return view('admin/add_quiz', $data);
  }

  public function view_quiz($id) {
    $quiz = $this->quiz_model->find($id);
    $quiz['level_title'] = $this->level_model->find($quiz['level_id'])['title'];
    $data = array(
      'quiz' => $quiz
    );
    return view('admin/view_quiz', $data);
  }

  private function _save_quiz() {
    $save_to_db = function() {
      $quiz = array();
      $quiz['level_id'] = $this->request->getPost('level_id');
      $quiz['answer'] = $this->request->getPost('answer');
      $quiz['question'] = $this->request->getPost('question');

      $quiz_id = $this->quiz_model->add($quiz);
      return $quiz_id;
    };

    $save_original_pict = function($file_name) {
      if(!$file_name) return null;

      $full_dest = WRITEPATH.'uploads/'.$file_name;
      $data_base64 = $this->request->getPost('quiz_pict');
      list($type, $data_base64) = explode(';', $data_base64);
      list(, $data_base64)      = explode(',', $data_base64);
      $data_base64 = base64_decode($data_base64);

      $img = new \Imagick();
      $img->readimageblob($data_base64);
      $img->setImageFormat('jpg');
      $img->resizeImage(NORMAL_SIDE, NORMAL_SIDE, \Imagick::FILTER_LANCZOS, 1);
      $img->writeImage($full_dest);

      return $full_dest;
    };

    $generate_thumbnail_pict = function($file_name, $original_pict_full_path) {
      if(!$file_name) return null;

      $full_dest = WRITEPATH.'uploads/'.$file_name;

      $im = new \Imagick($original_pict_full_path);
      $im->setCompression(\Imagick::COMPRESSION_JPEG); 
      $im->setCompressionQuality(60); 
      $im->setImageFormat('jpeg'); 
      $im->cropThumbnailImage(THUMB_SIDE, THUMB_SIDE);
      $im->writeImage($full_dest); 
      $im->clear(); 
      $im->destroy(); 
    };

    $generate_share_pict = function($file_name) {
      if(!$file_name) return null;

      $full_dest = WRITEPATH.'uploads/' . $file_name;
      $share_mask = FCPATH . 'share_mask.png';

      $data_base64 = $this->request->getPost('quiz_pict');
      list($type, $data_base64) = explode(';', $data_base64);
      list(, $data_base64)      = explode(',', $data_base64);
      $data_base64 = base64_decode($data_base64);

      $base = new \Imagick();
      $base->readimageblob($data_base64);
      $base->setImageFormat('jpg');
      $base->resizeImage(SHARE_SIDE, SHARE_SIDE, \Imagick::FILTER_LANCZOS, 1);

      $mask = new \Imagick($share_mask);
      $mask->resizeImage(SHARE_SIDE, SHARE_SIDE, \Imagick::FILTER_LANCZOS, 1);

      $base->compositeImage($mask, \Imagick::COMPOSITE_OVER, 0, 0);
      $base->writeImage($full_dest); 
      $base->clear(); 
      $base->destroy(); 
    };

    $quiz_id = $save_to_db();
    $original_pict_full_path = $save_original_pict($quiz_id . '.normal.jpg');
    $generate_thumbnail_pict($quiz_id . '.thumb.jpg', $original_pict_full_path);
    $generate_share_pict($quiz_id . '.share.jpg');
  }
}
