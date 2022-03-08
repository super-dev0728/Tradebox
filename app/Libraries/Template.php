<?php

namespace App\Libraries;
define('UPDATE_INFO_URL','https://update.bdtask.com/tradebox/autoupdate/update_info');
use App\Modules\Website\Models\Web_model;

class Template
{
    public function __construct()
    {
        $this->db         = db_connect();
        $this->web_model  = new Web_model();
        $session          = \Config\Services::session();
    }

    public function admin_layout($data)
    {

        $uri                = service('uri','<?php echo base_url(); ?>');
        $data['uri']        = $uri;
        $session            = \Config\Services::session();
        $data['session']    = $session;
        $data['request']    = \Config\Services::request();
        
        $validation         =  \Config\Services::validation();
        $data['validation'] = $validation;

        if ( @fopen("https://update.bdtask.com", "r") ) 
        {
           $max_version = file_get_contents(UPDATE_INFO_URL);

        } else {

            $max_version = $this->current_version();

        } 
        $data['max_version']     = $max_version;
        $data['current_version'] = $this->current_version();
        $data['settings']        = $this->setting_data();

        echo view('admin/head', $data);
        echo view('admin/sidebar', $data);
        echo view('admin/header', $data);
        echo view('admin/messages', $data);
        echo view($data['content'], $data);

        return view('admin/footer', $data);
    }

    public function customer_layout($data)
    {
        $uri                = service('uri','<?php echo base_url(); ?>');
        
        $data['uri']        = $uri;
        $session            = \Config\Services::session();
        $data['session']    = $session;
        $data['request']      = \Config\Services::request();
        $validation         =  \Config\Services::validation();
        $data['validation'] = $validation;

        $data['settings']   = $this->setting_data();

        echo view('customer/head', $data);
        echo view('customer/sidebar', $data);
        echo view('customer/header', $data);
        echo view('customer/messages', $data);            
        
        echo view($data['content'], $data);
        return view('customer/footer', $data);
    }

    public function website_layout($data)
    {
        $uri                = service('uri','<?php echo base_url(); ?>');
        $data['uri']        = $uri;
        $session            = \Config\Services::session();
        $data['session']    = $session;
        $data['segment_1']    = $uri->setSilent()->getSegment(1);
        $data['segment_2']    = $uri->setSilent()->getSegment(2);

        $data['settings']     = $this->setting_data();
        $data['web_language'] = $this->web_model->webLanguage();
        $data['social_link']  = $this->web_model->social_link();
        $data['category']     = $this->web_model->categoryList();
        $data['lang']         = $this->langSet();
        $data['service']      = $this->web_model->article($this->web_model->catidBySlug('service')->cat_id, 8);
        
        $googleapikey = $this->db->table('external_api_setup')->select('data')->where('id',4)->where('status',1)->get()->getRow();
        $data['googleapikeydecode'] = json_decode($googleapikey->data,true);
        $builder = $this->db->table('themes');
        $template = $builder->select('name')->where('status',1)->get()->getRow();
        echo view('themes/'.$template->name.'/header', $data);
        echo  view('themes/'.$template->name.'/layout', $data);
        return view('themes/'.$template->name.'/footer', $data);
    }

    public function setting_data()
    {
        $builder = $this->db->table('setting')
            ->get()
            ->getRow();
        return $builder;
    }
    /******************************
     * Language Set For User
     ******************************/
    public function langSet()
    {
        $session    = \Config\Services::session();

        $lang = "";
        $user_id = $session->get('user_id');
        if ($user_id != "") {
            $builder = $this->db->table('dbt_user');
            $ulang = $builder->select('language')->where('user_id', $user_id)->get()->getRow();
            if ($ulang->language != 'english') {
                $lang = 'french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $session->set($newdata);
            } else {
                $lang = 'english';
                $newdata = array(
                    'lang'  => 'french'
                );
                $session->set($newdata);
            }
        } else {
            $builder = $this->db->table('setting');
            $alang = $builder->select('language')->get()->getRow();
            if ($alang->language == 'french') {
                $lang = 'french';
                $newdata = array(
                    'lang'  => 'french'
                );
                $session->set($newdata);
            } else {
                if ($session->lang == 'french') {
                    $lang = 'french';
                } else {
                    $lang = 'english';
                }
            }
        }

        return $lang;
    }

    private function current_version(){

        //Current Version
        $product_version = '';
        $path = FCPATH.'system/Security/lic.php'; 
        if (file_exists($path)) {
            
            // Open the file
            $whitefile = file_get_contents($path);

            $file = fopen($path, "r");
            $i    = 0;
            $product_version_tmp = array();
            $product_key_tmp = array();
            while (!feof($file)) {
                $line_of_text = fgets($file);

                if (strstr($line_of_text, 'product_version')  && $i==0) {
                    $product_version_tmp = explode('=', strstr($line_of_text, 'product_version'));
                    $i++;
                }                
            }
            fclose($file);

            $product_version = trim(@$product_version_tmp[1]);
            $product_version = ltrim(@$product_version, '\'');
            $product_version = rtrim(@$product_version, '\';');

            return @$product_version;
            
        } else {
            //file is not exists
            return false;
        }
    }
}