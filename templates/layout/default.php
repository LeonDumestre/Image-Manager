<?php

?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/168132daad.js" crossorigin="anonymous"></script>
    <title>
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>


    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake']) ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <nav class="top-nav">
        <div class="top-nav-title">
            <a href="<?= $this->Url->build('/') ?>"><span>Léon</span>DUMESTRE</a>
        </div>
        <div class="top-nav-links">
            <?php
            if ($this->fetch('connect')) {
                $session = $this->request->getSession();
                if (is_null($this->request->session()->read('Auth.User.pseudo'))) {
                    echo $this->Html->link(
                        "Se connecter",
                        ['controller' => 'Users', 'action' => 'login'],
                        ['id' => 'connect', 'class' => 'button']
                    );
                } else {
                    //Le helper ne permet pas de retirer le hrf or je ne veux pas actualiser la page (car menu-déroulant)
                    echo "<ul class='menu'><li>
                        <button id='connect' class='button' disabled>" . $session->read('Username') . "</button>
                        <ul class='sub-menu'><li>";
                    if ($session->check('Admin') && $session->read('Admin') == 1) {
                        echo $this->Html->link(
                            'Utilisateurs',
                            ['controller' => 'Users', 'action' => 'view'],
                            ['class' => 'button']
                        );
                        echo "</li><li>";
                    }
                    echo $this->Html->link(
                        'Mes Images',
                        ['controller' => 'Images', 'action' => 'listing', 'myalbum'],
                        ['class' => 'button']
                    );
                    echo "</li><li>";
                    echo $this->Html->link(
                        'Me déconnecter',
                        ['controller' => 'Users', 'action' => 'disconnect'],
                        ['class' => 'button']
                    );
                    echo "</li></ul></li></ul>";
                }
            }
            ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
    </footer>
</body>
</html>
