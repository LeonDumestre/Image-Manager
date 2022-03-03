<?php
declare(strict_types=1);

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
            } elseif (!password_verify($newUser['password'], $userData['password'])) {
                $this->Flash->error("Ce n'est pas le bon mot de passe !");
            } else {
                $this->request->getSession()->write([
                    "Username" => $userData['pseudo'],
                    "Email" => $userData['email'],
                    "Id" => $userData['id'],
                    "Admin" => $userData['admin']
                ]);
                $this->Flash->success('Tu as été connecté avec succès !');
                return $this->redirect(['controller' => 'Images', 'action' => 'listing']);
            }
        }
    }

    public function disconnect() {
        $session = $this->request->getSession();
        $session->destroy();
        $this->Flash->warning('Tu as été déconnecté avec succès !');
        return $this->redirect($this->referer());
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
                $this->Flash->success('Cette email est déjà utilisé !');
            } else {
                $userEntity = $this->Users->newEntity([
                    'pseudo' => $data['pseudo'],
                    'email' => $data['email'],
                    'password' => password_hash($data['password'], PASSWORD_DEFAULT),
                ]);

                if ($this->Users->save($userEntity)) {
                    $this->Flash->success('Ton compte a été créé avec succès !');
                    return $this->redirect(['controller' => 'Users', 'action' => 'connect']);
                } else {
                    $this->Flash->error("Oups ! Ton compte n'a pas pu être créé.");
                }
            }
        }
    }

    public function listing() {
        $session = $this->request->getSession();
        if ($session->read('Id') == 1) {
            $users = $this->Users
                ->find()
                ->toArray();
            $this->set(compact('users'));
        } else {
            return $this->redirect(['controller' => 'Images', 'action' => 'listing']);
        }
    }


    public function delete($id)
    {
        $this->getRequest()->allowMethod('post');

        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success("L'utilisateur a été supprimée avec succès !");
        } else {
            $this->Flash->error("Mince ! L'utilisateur n'a pas pu être supprimé...");
        }
        return $this->redirect((['controller' => 'Users', 'action' => 'listing']));
    }

}
