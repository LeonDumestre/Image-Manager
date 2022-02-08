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

    public function add()
    {
        $images = $this->Images
            ->find()
            ->all();

        if (count($images) == 0) {
            foreach (glob(WWW_ROOT . 'img/*.jpg') as $img) {
                $image = $this->Images->newEmptyEntity();
                $image->name = exif_read_data($img)["FileName"];

                $description = '';
                if (isset(exif_read_data($img)["ImageDescription"]))
                    $description = exif_read_data($img)["ImageDescription"];
                $image->description = $description;

                $image->width = exif_read_data($img)["ExifImageWidth"];
                $image->height = exif_read_data($img)["ExifImageLength"];

                if ($this->Images->save($image))
                    $id = $image->id;
            }
        }
        dd('add');
    }

    //TODO pagination à faire
    public function listing($args = null)
    {
        $request = $this->getRequest()->getQuery();
        $dataArray = array();

        foreach (glob(WWW_ROOT.'img/*.jpg') as $img) {

            if (count($dataArray) <= 10) {

                if (exif_read_data($img)["FileName"] == $args ||
                    substr(exif_read_data($img)["FileName"], 0, strpos(exif_read_data($img)["FileName"], '.')) == $args ||
                    $args == null) {

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
                                "Html" => "<img src=\"/img/" . exif_read_data($img)["FileName"] . "\" alt=\"" . exif_read_data($img)["FileName"] . "\"width=150 height=auto>"
                            ));

                        }
                    }
                }
            }
        }

        if ($args != null && count($dataArray) == 0)
            return $this->response->withStatus(400);

        $this->set(compact('dataArray'));
    }

}
