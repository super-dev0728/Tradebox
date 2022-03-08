<?php 
 if(!function_exists('lan')) {
     

    function display($text = null)
    {
        $session = \Config\Services::session();
        $CI = db_connect();
        $table         = 'language';
        $phrase        = 'phrase';
        $setting_table = 'setting';
        $default_lang  = 'english';

        //set language  
        $user_id = $session->userdata('user_id');
        if(!empty($user_id)){

            $default_lang  = 'english';
            $setting_table = 'dbt_user';
            $builder = $CI->table($setting_table);
            $data = $builder->where('user_id',$user_id)->get()->getRow();
            $session->remove('lang');
            $language = $data->language;
            
        } else if($session->userdata('lang')){

           $language = $session->userdata('lang');

        } else {

            $default_lang  = 'english';
            $setting_table = 'setting';
            //set language  
            $builder = $CI->table($setting_table);
            $data = $builder->get()->getRow();
            $session->remove('lang');

            $language = $data->language;
        } #end
       
        if (!empty($text)) {

            if ($CI->tableExists($table)) { 

                if ($CI->fieldExists($phrase, $table)) { 

                    if ($CI->fieldExists($language, $table)) {

                        $row = $CI->table($table)
                              ->select($language)
                              ->where($phrase, $text)
                             ->get()
                             ->getRow();

                        if (!empty($row->$language)) {
                            return $row->$language;
                        } else {
                            return false;
                        }

                    } else {
                        return false;
                    }

                } else {
                    return false;
                }

            } else {
                return false;
            }            
        } else {
            return false;
        }  

    }
 
}

