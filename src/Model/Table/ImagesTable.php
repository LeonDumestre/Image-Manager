<?php

namespace App\Model\Table;

use ArrayObject;
use Cake\Datasource\EntityInterface;
use Cake\Event\EventInterface;
use Cake\ORM\Table;

class ImagesTable extends Table
{
    public function initialize(array $config): void
    {
        parent::initialize($config);
        $this->hasMany('Comments')->setDependent(true)->setCascadeCallbacks(true);
        $this->belongsTo('Users', ['foreignKey' => 'author']);
    }

    public function afterDelete(EventInterface $event, EntityInterface $entity, ArrayObject $options) {
        if (file_exists(WWW_ROOT . 'img/' . $entity->name)) {
            unlink(WWW_ROOT . 'img/' .$entity['name']);
        }
    }
}
