<?php

namespace App\Modules\Auth\Controllers\Admin;

helper('captcha');

class Auth extends BaseController
{
	public function index()
	{


		$data['title']    = display('admin');

		#-------------------------------------#
		$this->validation->setRule('email', display('email'), 'required|valid_email|max_length[100]');
		$this->validation->setRule('password', display('password'), 'required|max_length[32]|md5');
		$this->validation->setRule('captcha', display('captcha'), 'required|max_length[32]');

		#-------------------------------------#
		$data['user'] = (object)$userData = array(
			'email' 	 => $this->request->getVar('email', FILTER_SANITIZE_EMAIL),
			'password'   => $this->request->getVar('password', FILTER_SANITIZE_STRING),
		);
		$oldCaptcha = $this->session->get('captcha');

		$captcha   = $this->request->getVar('captcha', FILTER_SANITIZE_STRING);
		#-------------------------------------#
		if ($this->validation->withRequest($this->request)->run()) {
			$this->session->remove('captcha');
			$user = $this->auth_model->checkUser($userData);

			if (!empty($user->getResult())) {

				$sData = array(
					'isLogIn' 	  => true,
					'isAdmin' 	  => (($user->getRow()->is_admin == 1 || $user->getRow()->is_admin == 2) ? true : false),
					'id' 		  => $user->getRow()->id,
					'fullname'	  => $user->getRow()->fullname,
					'user_level'  => $user->getRow()->user_level,
					'email' 	  => $user->getRow()->email,
					'image' 	  => $user->getRow()->image,
					'last_login'  => $user->getRow()->last_login,
					'last_logout' => $user->getRow()->last_logout,
					'ip_address'  => $user->getRow()->ip_address,
				);
				if ($captcha == $oldCaptcha) {

					if ($user->getRow()->status != 0) {
						//store date to session 
						$this->session->remove('user_id');
						$this->session->set($sData);
						//update database status
						$ipadd = $this->request->getIPAddress();
						$this->auth_model->last_login($ipadd);
						//welcome message
						$this->session->setFlashdata('message', display('welcome_back') . ' ' . $user->getrow()->fullname);
						return redirect()->to(base_url('backend/home'));

					} else {

						$this->session->setFlashdata('exception', "You are not active admin");
						return redirect()->to(base_url('admin'));
					}

				} else {
					
					$this->session->setFlashdata('exception', 'Captcha is not Matched');
					return redirect()->to(base_url('admin'));
				}
			} else {

				$this->session->setFlashdata('exception', display('incorrect_email_password'));
				return redirect()->to(base_url('admin'));
			}
		} else {
			$error = $this->validation->listErrors();
			if ($this->request->getMethod() == "post") {
				$this->session->setFlashdata('exception', $error);
			}
		}

		$captcha = create_captcha(array(
			'img_path'      => FCPATH . './public/assets/images/captcha/',
			'img_url'       => base_url('public/assets/images/captcha/'),
			'font_path'     => FCPATH . './public/assets/fonts/captcha.ttf',
			'img_width'     => '300',
			'img_height'    => 64,
			'expiration'    => 600, //5 min
			'word_length'   => 4,
			'font_size'     => 26,
			'img_id'        => 'Imageid',
			'pool'          => '0123456789abcdefghijklmnopqrstuvwxyz',
			// White background and border, black text and red grid
			'colors'        => array(
				'background' => array(255, 255, 255),
				'border' 	=> array(228, 229, 231),
				'text' 		=> array(49, 141, 1),
				'grid' 		=> array(241, 243, 246)
			)
		));

		$data['captcha_word'] = $captcha['word'];
		$data['captcha_image'] = $captcha['image'];
		$this->session->set('captcha', $captcha['word']);
		return view($this->BASE_VIEW . '\login', $data);
	}

	public function logout()
	{
		//destroy session
		$ipadd = $this->request->getIPAddress();
		$this->auth_model->last_logout($ipadd);
		$this->session->destroy();
		return redirect()->route('admin');
	}
}