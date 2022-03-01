<?php

$this->assign('title', 'Se connecter');

echo $this->Form->create(null);
echo $this->Form->control("email", ["required" => true, "type" => "email"]);
echo $this->Form->control("password", ["required" => true, "type" => "password"]);
echo $this->Form->button("Me connecter");
echo $this->Form->end();

echo "Je ne possède pas encore de compte ? ";
echo $this->Html->link('M\'inscrire', ["controller" => 'Users', 'action' => 'register'], ['class' => 'button']);





