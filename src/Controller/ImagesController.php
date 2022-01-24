<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;

class ImagesController extends AppController
{

    public function index()
    {
        $imagesArray = array();
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img)
        {
            array_push($imagesArray, $img);
        }
         return $this->response->withStringBody(json_encode($imagesArray))->withType("application/json");
    }

    public function picture($id)
    {
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img)
        {
            $fileName = exif_read_data($img)["FileName"];
            if (substr($fileName, 0, strpos($fileName, '.')) == $id) {
                return $this->response->withStringBody(json_encode(exif_read_data($img)))->withType("application/json");
            }
        }
        return $this->response->withStringBody("L'image n'existe pas !");
    }

}
