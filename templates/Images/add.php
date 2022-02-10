<?php

$this->assign('title', 'Ajout d\'une image');

/** @var \Cake\ORM\Entity $image */
echo $this->Form->create($image, array("type" => "file"));
echo $this->Form->control("File", ["type" => "file", "accept" => "image/jpg", "required" => true]);
echo $this->Form->control("Description", ["type" => "textarea", "maxlength" => 500]);
echo $this->Form->button("Ajouter l'image");
echo $this->Form->end();

?>


