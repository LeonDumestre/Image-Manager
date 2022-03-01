<?php

$this->assign('connect', $this->Html->link("Se connecter", ["controller" => 'Users', 'action' => 'connect'], ['class' => 'button']));
$this->assign('title', 'Ajout d\'une image');

/** @var \Cake\ORM\Entity $image */
echo $this->Form->create($image, array("type" => "file"));
echo $this->Form->control("Name", ["required" => true]);
echo $this->Form->control("File", ["type" => "file", "accept" => "image/jpeg", "required" => true]);
echo $this->Form->control("Description", ["type" => "textarea", "maxlength" => 500]);
echo $this->Form->button("Ajouter l'image");
echo $this->Form->end();

?>
