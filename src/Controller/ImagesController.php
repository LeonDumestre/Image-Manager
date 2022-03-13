<?php
declare(strict_types=1);

namespace App\Controller;

class ImagesController extends AppController
{

    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);
        // Configurez l'action de connexion pour ne pas exiger d'authentification,
        // évitant ainsi le problème de la boucle de redirection infinie
        $this->Authentication->addUnauthenticatedActions(['api', 'listing', 'view']);
    }

    public function api($args = null)
    {
        $request = $this->getRequest()->getQuery();

        if ($args == null) {

            $page = 1;
            if (isset($request['page'])) {
                $page = $request['page'];
            }

            $limit = 12;
            if (isset($request['limit']) && $request['limit'] < $limit) {
                $limit = $request['limit'];
            }

            $name = '%';
            if (isset($request['name']))
                $name = '%' . $request['name'] . '%';
            elseif ($args != null) {
                $name = $args;
            }

            $images = $this->Images
                ->find()
                ->where(['name LIKE' => $name])
                ->contain(['Comments','Users'])
                ->limit($limit)
                ->offset(($page - 1) * $limit)
                ->order(['name' => 'ASC'])
                ->toArray();

            if (count($images) == 0) {
                return $this->response->withStatus(400);
            }
        } else {
            if (is_numeric($args)) {
                $images = $this->Images
                    ->find()
                    ->where(['id =' => $args])
                    ->contain(['Comments'])
                    ->first();
            } else {
                $images = $this->Images
                    ->find()
                    ->where(['name LIKE' => $args])
                    ->contain(['Comments'])
                    ->first();
            }
        }

        return $this->response->withStringBody(json_encode($images, JSON_PRETTY_PRINT))->withType('application/json');
    }


    public function add()
    {
        $image = $this->Images->newEmptyEntity();
        $this->set(compact('image'));

        $data = $this->getRequest()->getData();
        if (!empty($data)) {
            $fileData = $data['File'];

            if (count($this->Images->find()->where(['Name LIKE' => $data['Name'] . '.jpg'])->toArray()) > 0) {
                $this->Flash->error('Ce nom est déjà utilisé !');
            } else {
                $image->name = $data['Name'] . '.jpg';
                $image->description = $data['Description'];

                $result = $this->Authentication->getResult();
                if ($result->isValid()) {
                        $image->author = $result->getData()["id"];
                } else {
                    $this->Flash->error("Tu dois te connecter pour ajouter une image !");
                    return $this->redirect(['controller' => 'Users', 'action' => 'login']);
                }

                $fileData->moveTo(WWW_ROOT . 'img/' . $image->name);

                $imageSize = getimagesize(WWW_ROOT . 'img/' . $image->name);
                $image->width = $imageSize[0];
                $image->height = $imageSize[1];

                if ($this->Images->save($image)) {
                    $this->Flash->success("L'image a été ajoutée avec succès !");
                    return $this->redirect(['controller' => 'Images', 'action' => 'listing']);
                } else {
                    $this->Flash->error("Mince ! L'image n'a pas pu être ajoutée...");
                }
            }
        }
    }


    public function delete($id)
    {
        $this->getRequest()->allowMethod('post');

        $image = $this->Images->get($id);

        if ($this->Images->delete($image)) {
            $this->Flash->success("L'image a été supprimée avec succès !");
        } else {
            $this->Flash->error("Mince ! L'image n'a pas pu être supprimée...");
        }

        return $this->redirect((['controller' => 'Images', 'action' => 'listing']));
    }


    public function listing()
    {
        $request = $this->getRequest()->getQuery();

        $page = 1;
        if (isset($request['page'])) {
            $page = $request['page'];
        }

        $limit = 12;
        if (isset($request['limit']) && $request['limit'] < $limit) {
            $limit = $request['limit'];
        }

        $name = '%';
        if (isset($request['name']))
            $name = '%' . $request['name'] . '%';

        $images = $this->Images
            ->find()
            ->where(['name LIKE' => $name])
            ->contain(['Users'])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->order(['name' => 'ASC'])
            ->toArray();

        $allImages = $this->Images->find()->toArray();
        if ($limit != 0) {
            $maxPage = count($allImages) / $limit;
        }

        $this->set(compact('images'));
        $this->set(compact('limit'));
        $this->set(compact('page'));
        $this->set(compact('maxPage'));
    }


    public function view($args = null)
    {
        if ($args == null) {
            return $this->response->withStatus(400);
        }

        if (is_numeric($args)) {
            $image = $this->Images
                ->find()
                ->contain(['Comments', 'Users'])
                ->where(['id =' => $args])
                ->first();
        } else {
            $image = $this->Images
                ->find()
                ->contain(['Comments', 'Users'])
                ->where(['name LIKE' => $args])
                ->first();
        }

        if ($image == null) {
            return $this->response->withStatus(400);
        }

        $this->set(compact('image'));
    }

    public function updateDescription($id)
    {
        $image = $this->Images->get($id);
        $image['description'] = $this->getRequest()->getData('description');

        if ($this->Images->save($image)) {
            $this->Flash->success("La description a été modifiée avec succès !");
        } else {
            $this->Flash->error("Mince ! La description n'a pas pu être modifiée...");
        }

        return $this->redirect($this->referer());
    }
}
