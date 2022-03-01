<?php

namespace App\Controller;

class CommentsController extends AppController
{

    public function add($img_id)
    {
        $commentEntity = $this->Comments->newEntity([
            'image_id' => $img_id,
            'content' =>  $this->getRequest()->getData('content')
        ]);

        if ($this->Comments->save($commentEntity)) {
            $this->Flash->success("Le commentaire a été ajouté avec succès !");
        } else {
            $this->Flash->error("Mince ! Le commentaire n'a pas pu être ajouté...");
        }
        return $this->redirect($this->referer());
    }

}
