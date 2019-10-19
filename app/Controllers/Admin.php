<?php namespace App\Controllers;
use App\Libraries\Session;

define('ADMIN_USER', 'adminzz');
define('ADMIN_PASSWORD', 'if9d923ffasFF');

class Admin extends BaseController {
  function __construct() {
    $this->session = session();
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
}
