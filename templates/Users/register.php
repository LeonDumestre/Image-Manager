<?php

$this->assign('title', 'Créer mon compte');

/** @var \Cake\ORM\Entity $user */
echo $this->Form->create($user);
echo $this->Form->control("pseudo", ["required" => true]);
echo $this->Form->control("email", ["required" => true, "type" => "email"]);
echo $this->Form->control("password", ["required" => true, "type" => "password"]);
echo $this->Form->button("Créer mon compte");
echo $this->Form->end();
