<?php namespace App\Controllers;
use App\Models\QuestionModel;

class Home extends BaseController
{
	public function index()
	{
    $question_model = new QuestionModel();
    $rows = $question_model->getQuestions();
    var_dump($rows);
    return view('welcome_message');
  }

	//--------------------------------------------------------------------

}
