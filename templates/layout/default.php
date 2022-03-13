<?php
$result = $this->fetch('result')
?>

<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://kit.fontawesome.com/168132daad.js" crossorigin="anonymous"></script>
    <title> <?= $this->fetch('title') ?> </title>
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
            if (!$this->Identity->isLoggedIn()): ?>
                <?= $this->Html->link(
                    "Se connecter",
                    ['controller' => 'Users', 'action' => 'login'],
                    ['id' => 'connect', 'class' => 'button']
                ); ?>
            <?php else: ?>
                <ul class='menu'>
                    <li>
                        <button id='connect' class='button' disabled> <?= $this->Identity->get("pseudo") ?> </button>
                        <ul class='sub-menu'>
                            <?php if ($this->Identity->get("id") == 1): ?>
                            <li>
                                <?= $this->Html->link(
                                    'Utilisateurs',
                                    ['controller' => 'Users'],
                                    ['class' => 'button']
                                ); ?>
                            </li>
                            <?php endif ?>
                            <li>
                                <?= $this->Html->link(
                                    'Me déconnecter',
                                    ['controller' => 'Users', 'action' => 'logout'],
                                    ['class' => 'button']
                                ); ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </nav>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer>
        <?= $this->fetch('footer') ?>
    </footer>
</body>
</html>
