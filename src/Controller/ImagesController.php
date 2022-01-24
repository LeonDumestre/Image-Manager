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

    public function listing($name = null)
    {
        $request = $this->getRequest()->getQuery();
        $imagesArray = array();
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img) {

            if (substr(exif_read_data($img)["FileName"], 0, strpos(exif_read_data($img)["FileName"], '.')) == $name || $name == null) {
                if ((isset($request["limit"]) && count($imagesArray) < $request["limit"]) || !isset($request["limit"])) {
                    if ((isset($request["name"]) && str_contains(exif_read_data($img)["FileName"], $request["name"])) || !isset($request["name"])) {

                        $description = '';
                        if (isset(exif_read_data($img)["ImageDescription"]))
                            $description = exif_read_data($img)["ImageDescription"];

                        $comment = '';
                        if (isset(exif_read_data($img)["UserComment"]))
                            $comment = exif_read_data($img)["UserComment"];

                        $author = '';
                        if (isset(exif_read_data($img)["Artist"]))
                            $author = exif_read_data($img)["Artist"];

                        array_push($imagesArray, array(
                            "file" => exif_read_data($img)["FileName"],
                            "description" => $description,
                            "comment" => $comment,
                            "author" => $author,
                            "width" => exif_read_data($img)["ExifImageWidth"],
                            "height" => exif_read_data($img)["ExifImageLength"]
                        ));
                    }
                }
            }
        }
        if ($name != null && count($imagesArray) == 0) {
            return $this->response->withStatus(400);
        }
        return $this->response->withStringBody(json_encode($imagesArray, JSON_PRETTY_PRINT))->withType("application/json");
    }

}
