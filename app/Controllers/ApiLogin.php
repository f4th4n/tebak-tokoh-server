<?php namespace App\Controllers;

use App\Models\UserModel;
use \Firebase\JWT\JWT;

class ApiLogin extends BaseController {
	public function index()
	{
		$this->_verify();
		$data = $this->_save();
		return json_encode($data);
	}

	private function _save()
	{
		$user_model = new UserModel();
		$post_data  = $this->request->getJSON();
		$data       = [
			'uid'          => $post_data->uid,
			'email'        => $post_data->email,
			'display_name' => $post_data->displayName,
			'photo_url'    => $post_data->photoURL,
			'token'        => $post_data->auth->idToken,
		];
		$user_model->upsert($data);
		return $data;
	}

	private function _verify()
	{
		$post_data = $this->request->getJSON();
		$jwt       = $post_data->auth->idToken;

		$tks                                 = explode('.', $jwt);
		list($headb64, $bodyb64, $cryptob64) = $tks;
		$payload                             = JWT::jsonDecode(JWT::urlsafeB64Decode($bodyb64));
		if (! $payload->email)
		{
			throw new Exception('Not valid');
		}
	}
}
