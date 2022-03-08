<?php namespace App\Libraries;

use Config\Database;


class CustomRules
{
	/**
	 * Check The Database if the username is exist or not
	 * provide the user id in the parameter
	 * @return boolean
	 */
        public function username_check($username, $uid)
        { 
            $db=  db_connect();
            $builder=$db->table('user_registration');
            $usernameExists = $builder->select('username')
            ->where('username',$username) 
            ->where('uid != ',$uid)
            ->get()
            ->getResult();
            if (!empty($usernameExists)){
                return false;
            } else {
                return true;
            }
        }
    /**
	 * Check The Database if the email address is exist or not
	 * provide the user id in the parameter
	 * @return boolean
	 */
        public function email_check($email, $uid)
        {
            $db=  db_connect();
            $builder=$db->table('user_registration');
            $emailExists = $builder->select('email')
            ->where('email',$email) 
            ->where('uid != ',$uid)
            ->get()
            ->getResult();
            if (!empty($emailExists)){
                return false;
            }else {
                return true;
            }
        }
    /**
	 * Check The Database if the Package name is exist or not
	 * provide the Package id in the parameter
	 * @return boolean
	 */
        public function package_check($package_name, $package_id)
        { 
            //die("ok");
            $db=  db_connect();
            $builder=$db->table('package');
             $packageExists =$builder->select('*')
                            ->where('package_name',$package_name) 
                            ->where('package_id!=',$package_id)
                            ->get()
                            ->getResult();
             if (!empty($packageExists)){
                return false;
             }else{
                return true;
             }
        
        } 
     /**
	 * Check The Database if the admin email address is exist or not
	 * provide the admin id in the parameter
	 * @return boolean
	 */
        public function admin_email_check($email, $id)
        { 
            $db=  db_connect();
            $builder=$db->table('admin');
            $emailExists = $builder->select('email')
            ->where('email',$email) 
            ->where('id != ',$id)
            ->get()
            ->getResult();
            if (!empty($emailExists)){
                return false;
            }else {
                return true;
            }
        }
        /**
	 * Check The Database if the headline is exist or not
	 * provide the headline id in the parameter
	 * @return boolean
	 */
        public function slug_check($headline_en, $article_id)
        { 
            $this->validation     =  \Config\Services::validation();
            $db=  db_connect();
            $builder=$db->table('web_article');
            $packageExists = $builder->select('*')
                ->where('headline_en',$headline_en) 
                ->where('article_id !=',$article_id)
                ->get()
                ->getResult();

            if (!empty($packageExists)) {
               // $this->validation->showError('headline_en', 'The {field} is already registered.');
                return false;
            } else {
                return true;
            }

        }
        /**
	 * Check The Database if the News Headline is exist or not
	 * provide the article id in the parameter
	 * @return boolean
	 */
        public function news_slug_check($headline_en, $article_id)
        { 
            $this->validation     =  \Config\Services::validation();
            $db=  db_connect();
            $builder=$db->table('web_news');
            $packageExists = $builder->select('*')
                ->where('headline_en',$headline_en) 
                ->where('article_id !=',$article_id)
                ->get()
                ->getResult();

            if (!empty($packageExists)){
                   return false;
               }else{
                   return true;
               }
        }
        /**
	 * Check The Database if the Category Name is exist or not
	 * provide the Category id in the parameter
	 * @return boolean
	 */
        public function cat_slug_check($cat_name_en, $cat_id)
        { 
            $this->validation     =  \Config\Services::validation();
            $db=  db_connect();
            $builder=$db->table('web_category');
            $packageExists = $builder->select('*')
                ->where('cat_name_en',$cat_name_en) 
                ->where('cat_id !=',$cat_id)
                ->get()
                ->getResult();

            if (!empty($packageExists)){
                   return false;
               }else{
                   return true;
               }
        }
        
}
