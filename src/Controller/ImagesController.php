<?php
declare(strict_types=1);

namespace App\Controller;

class ImagesController extends AppController
{
    public function api($args = null)
    {
        $this->addAll();
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
                    ->first();
            } else {
                $images = $this->Images
                    ->find()
                    ->where(['name LIKE' => $args])
                    ->first();
            }
        }

        return $this->response->withStringBody(json_encode($images, JSON_PRETTY_PRINT))->withType('application/json');
    }

    public function addAll()
    {
        $images = $this->Images
            ->find()
            ->all();

        if (count($images) == 0) {
            foreach (glob(WWW_ROOT . 'img/*.jpg') as $img) {
                $image = $this->Images->newEmptyEntity();
                $image->name = exif_read_data($img)['FileName'];

                $description = '';
                if (isset(exif_read_data($img)['ImageDescription'])) {
                    $description = exif_read_data($img)['ImageDescription'];
                }
                $image->description = $description;

                $image->width = exif_read_data($img)['ExifImageWidth'];
                $image->height = exif_read_data($img)['ExifImageLength'];

                $this->Images->save($image);
            }
            if (count($images) > 0) {
                $this->Flash->success('La base de données a été remplie avec succès !');
            }
        }
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

        return $this->redirect($this->referer());
    }

    public function listing()
    {
        $this->addAll();
        $request = $this->getRequest()->getQuery();

        $page = 1;
        if (isset($request['page'])) {
            $page = $request['page'];
        }

        $limit = 12;
        if (isset($request['limit']) && $request['limit'] < $limit) {
            $limit = $request['limit'];
        }

        $info = false;
        $name = '%';
        if (isset($request['name']))
            $name = '%' . $request['name'] . '%';

        $images = $this->Images
            ->find()
            ->where(['name LIKE' => $name])
            ->limit($limit)
            ->offset(($page - 1) * $limit)
            ->order(['name' => 'ASC'])
            ->toArray();

        if (count($images) == 0) {
            return $this->response->withStatus(400);
        }

        $allImages = $this->Images->find()->toArray();
        if ($limit != 0) {
            $maxPage = count($allImages) / $limit;
        }

        $this->set(compact('images'));
        $this->set(compact('limit'));
        $this->set(compact('page'));
        $this->set(compact('maxPage'));
        $this->set(compact('info'));
    }

    public function view($args = null)
    {
        if ($args == null) {
            return $this->response->withStatus(400);
        }

        if (is_numeric($args)) {
            $image = $this->Images
                ->find()
                ->contain(['Comments'])
                ->where(['id =' => $args])
                ->first();
        } else {
            $image = $this->Images
                ->find()
                ->contain(['Comments'])
                ->where(['name LIKE' => $args])
                ->first();
        }

        if ($image == null) {
            return $this->response->withStatus(400);
        }

        $this->set(compact('image'));
    }
}
