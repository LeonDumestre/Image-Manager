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
        $json = json_encode($imagesArray);
        dd($json);
    }

    public function view($id)
    {

    }

}
