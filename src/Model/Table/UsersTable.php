<?php

namespace App\Model\Table;

use Cake\ORM\Table;

class UsersTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        //TODO Ajouter les liens avec les images
        //$this->hasMany('Images')->setDependent(true);
    }
}
