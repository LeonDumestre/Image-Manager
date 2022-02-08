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

    public function addAll()
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
                    $this->Flash->success("La base de données a été remplie avec succès !");
            }
        }
    }

    public function delete($id)
    {
        $this->getRequest()->allowMethod("post");

        $image = $this->Images->get($id);
        if ($this->Images->delete($image))
            $this->Flash->success("L'image a été supprimée avec succès !");
        else
            $this->Flash->success("Mince ! L'image n'a pas pu être supprimée...");

        return $this->redirect($this->referer());
    }

    //TODO pagination à faire
    public function listing($args = null)
    {
        $this->addAll();
        $request = $this->getRequest()->getQuery();

        if ($args == null) {

            $limit = 20;
            if (isset($request["limit"]) && $request["limit"] < $limit)
                $limit = $request["limit"];

            $name = "";
            if (isset($request["name"]))
                $name = $request["name"];

            $images = $this->Images
                ->find()
                ->where(['name LIKE' => "%$name%"])
                ->limit($limit)
                ->order(['name' => 'ASC'])
                ->toArray();
        } else {
                $images = $this->Images
                    ->find()
                    ->where(['name LIKE' => $args . ".jpg"])
                    ->toArray();
            if (count($images) == 0)
                return $this->response->withStatus(400);
        }

        $this->set(compact('images'));
    }

}
