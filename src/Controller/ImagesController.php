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

    public function listing()
    {
        $imagesArray = array();
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img)
        {
            $description = '';
            if (isset(exif_read_data($img)["ImageDescription"]))
                $comment = exif_read_data($img)["ImageDescription"];

            $comment = '';
            if (isset(exif_read_data($img)["UserComment"]))
                $comment = exif_read_data($img)["UserComment"];

            $author = '';
            if (isset(exif_read_data($img)["Artist"]))
                $comment = exif_read_data($img)["Artist"];

            array_push($imagesArray, array(
                "file" => exif_read_data($img)["FileName"],
                "description" => $description,
                "comment" => $comment,
                "author" => $author,
                "width" => exif_read_data($img)["ExifImageWidth"],
                "height" => exif_read_data($img)["ExifImageLength"]
            ));
        }
        return $this->response->withStringBody(json_encode($imagesArray, JSON_PRETTY_PRINT))->withType("application/json");
    }

}
