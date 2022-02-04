<?php

namespace App\Controller;

use phpDocumentor\Reflection\Types\Array_;

class ImagesController extends AppController
{

    public function index()
    {
        $dataArray = array();
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img)
        {
            array_push($dataArray, $img);
        }
         return $this->response->withStringBody(json_encode($dataArray))->withType("application/json");
    }

    //TODO Ajouter le numéro de page en paramètre
    public function listing($name = null)
    {
        $request = $this->getRequest()->getQuery();
        $dataArray = array();
        foreach (glob(WWW_ROOT.'img/*.jpg') as $img) {

            if (exif_read_data($img)["FileName"] == $name ||
                substr(exif_read_data($img)["FileName"], 0, strpos(exif_read_data($img)["FileName"], '.')) == $name ||
                $name == null)
            {
                if ((isset($request["limit"]) && count($dataArray) < $request["limit"]) || !isset($request["limit"])) {
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

                        array_push($dataArray, array(
                            "file" => exif_read_data($img)["FileName"],
                            "description" => $description,
                            "comment" => $comment,
                            "author" => $author,
                            "width" => exif_read_data($img)["ExifImageWidth"],
                            "height" => exif_read_data($img)["ExifImageLength"],
                            "Html" => "<img src=\"/img/" . exif_read_data($img)["FileName"] . "\" alt=\"" . exif_read_data($img)["FileName"] . "\"width=400 height=auto>"
                        ));

                    }
                }
            }
        }

        if ($name != null && count($dataArray) == 0)
            return $this->response->withStatus(400);

        $image = $this->response->withStringBody(json_encode($dataArray))->withType("application/json");
        $this->set(compact('image'));
        $this->set(compact('dataArray'));
    }

}
