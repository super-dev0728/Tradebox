<?php namespace App\Libraries;
class UploadImage {
	   
    public function Image($img,$savepath,$old_image,$width,$height)
    {
       
            $image      = \Config\Services::image();
            if ($img->isValid() && ! $img->hasMoved()){
                $savepath   = $savepath.$img->getRandomName();
                $image      = \Config\Services::image('imagick')
                                ->withFile($img->getRealPath())
                                ->resize($width,$height, true, 'height')
                                ->save($savepath);
            }else{
                $savepath=$old_image;                  
            }
            return '/'.$savepath;                
    }

    public function upload_image($img = null, $savepath = null, $old_image = null, $width = null, $height = null)
    {

        $image = \Config\Services::image();
     
        if($img->isValid() && ! $img->hasMoved()){

        $savepath = $savepath.$img->getRandomName();
        $image    = \Config\Services::image('imagick')
                    ->withFile($img->getRealPath())
                    ->resize($width,$height, true, 'width')
                    ->save('public/'.$savepath);
        } else {

            $savepath = $old_image;                  
        }
        return $savepath;
    }

    function doUpload($upload_path = null, $file = null) {

        if(!empty($file)){
            
            if ($file->isValid() && ! $file->hasMoved())
            {
               $newName = $file->getRandomName();
               $file->move('public/'.$upload_path, $newName);
               return $upload_path.'/'.$newName;

            } else {

                return null;
            }

        } else {

            return null;
        }
    } 
    
}


