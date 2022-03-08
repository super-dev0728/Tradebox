<?php

namespace App\Modules\Auth\Controllers\Customer;

helper('captcha');
class User_auth extends BaseController
{

    public function index()
    {
        if ($this->session->get('isLogIn') && $this->session->get('user_id')) {
            return redirect()->to(base_url('customer/home'));
        }
        if ($this->session->get('isLogIn') && $this->session->get('isAdmin')) {
            return redirect()->to('customer/home');
        }
        $data['title']    = display('customer');
        $data['session']  = $this->session;

        //check the validation
        #-------------------------------------#
        $this->validation->setRule('email', display('email'), 'required|valid_email|max_length[100]');
        $this->validation->setRule('password', display('password'), 'required|max_length[32]|md5');
        $this->validation->setRule('captcha', display('captcha'), 'required|max_length[32]');
        #-------------------------------------#

        $data['user'] = (object)$userData = array(
            'email'      => $this->request->getPost('email', FILTER_SANITIZE_STRING),
            'password'   => $this->request->getPost('password', FILTER_SANITIZE_STRING),
        );

        $oldCaptcha = $this->session->get('captcha');
        $captcha   = $this->request->getPost('captcha', FILTER_SANITIZE_STRING);

        if ($this->validation->withRequest($this->request)->run()) {

            $this->session->remove('captcha');
            $user = $this->auth_model->checkUser($userData);
            if ($captcha == $oldCaptcha) {
                if (!empty($user->getResult())) {

                    $sData = array(
                        'isLogIn'       => true,
                        'id'           => $user->getRow()->uid,
                        'user_id'       => $user->getRow()->user_id,
                        'sponsor_id'      => $user->getRow()->sponsor_id,
                        'fullname'      => $user->getRow()->f_name . ' ' . $user->getRow()->l_name,
                        'email'       => $user->getRow()->email,
                        'image'       => $user->getRow()->image,
                        'phone'       => $user->getRow()->phone,
                    );
                    echo "<pre>";
                    
                    //store date to session 
                    $this->session->set($sData);
                    
                    //welcome message
                    $this->session->setFlashdata('message', display('welcome_back') . ' ' . $user->getRow()->f_name . ' ' . $user->getRow()->l_name);

                    return  redirect()->to(base_url('customer/home'));
                } else {

                    $this->session->setFlashdata('exception', display('incorrect_email_password'));
                    return redirect()->route('customer/login');
                }
            } else {

                $this->session->setFlashdata('exception', 'Captcha is not Matched');
                return redirect()->route('customer/login');
            }
        } else {

            $error = $this->validation->listErrors();
            if ($this->request->getMethod() == "post") {
                $this->session->setFlashdata('exception', $error);
                return redirect()->route('customer/login');
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
                    'border' => array(228, 229, 231),
                    'text' => array(49, 141, 1),
                    'grid' => array(241, 243, 246)
                )
            ));

            $data['captcha_word'] = $captcha['word'];
            $data['captcha_image'] = $captcha['image'];

            $this->session->set('captcha', $captcha['word']);

            return view($this->BASE_VIEW . '\login', $data);
        }
    }

    //customer logout function
    public function logout()
    {
        // $ipadd = $this->request->getIPAddress();
        // $this->auth_model->last_logout($ipadd);
        $this->session->destroy();
        return redirect()->route('customer');
    }
}