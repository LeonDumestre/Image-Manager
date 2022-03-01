<?php

namespace App\Controller;

class UsersController extends AppController
{

    public function connect()
    {
        $newUser = $this->getRequest()->getData();

        if (!empty($newUser)) {
            $userData = $this->Users
                ->find()
                ->where(['email LIKE' => $this->getRequest()->getData('email')])
                ->first();

            if ($userData == null) {
                $this->Flash->error("Ce compte n'existe pas !");
            } else if (!password_verify($newUser["password"], $userData['password'])) {
                $this->Flash->error("Ce n'est pas le bon mot de passe !");
            } else {
                $this->Flash->success("Tu as été connecté avec succès !");
                return $this->redirect(['controller' => 'Images', 'action' => 'listing']);
            }
        }
    }

    public function register()
    {
        $user = $this->Users->newEmptyEntity();
        $this->set(compact('user'));
        $data = $this->getRequest()->getData();

        if (!empty($data)) {
            $userSimilar = $this->Users
                ->find()
                ->where(['email LIKE' => $this->getRequest()->getData('email')])
                ->first();

            if ($userSimilar !== null) {
                $this->Flash->success("Cette email est déjà utilisé !");
            } else {
                $userEntity = $this->Users->newEntity([
                    'pseudo' => $data["pseudo"],
                    'email' => $data["email"],
                    'password' => password_hash($data["password"], PASSWORD_DEFAULT)
                ]);

                if ($this->Users->save($userEntity)) {
                    $this->Flash->success("Ton compte a été créé avec succès !");
                    return $this->redirect(['controller' => 'Images', 'action' => 'listing']);
                } else {
                    $this->Flash->error("Oups ! Ton compte n'a pas pu être créé.");
                }
            }
        }
    }

}
