<?php namespace App\Controllers;
use App\Models\QuizModel;

class Home extends BaseController
{
	public function index()
	{
    $question_model = new QuizModel();
    $rows = $question_model->getQuestions();
    var_dump($rows);
    return view('welcome_message');
  }

	//--------------------------------------------------------------------

}
