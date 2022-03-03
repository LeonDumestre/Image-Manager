<?php

/** @var array $images */
/** @var int $page */
/** @var int $maxPage */
/** @var int $limit */
/** @var int $noLimit */
/** @var int $album */
/** @var int $connected */
/** @var \Cake\ORM\Entity $comment */

$this->assign('connect', true);
if ($album) $this->assign('title', 'Mes images');
else $this->assign('title', 'Les images');

$session = $this->request->getSession();
$admin = false;
if ($session->check("Admin") && $session->read("Admin") || $album) {
    $admin = true;
}

if ($session->check("Email") && !$album) {
    echo $this->Html->link(
        'Ajouter une image',
        ['controller' => 'Images', 'action' => 'add'],
        ['escapeTitle' => false, 'class' => 'button']
    );
}
?>

<table>
    <thead>
    <tr>
        <th>Nom</th>
        <th>Description</th>
        <th>Largeur</th>
        <th>Hauteur</th>
        <th>Image</th>
        <th>Télécharger</th>
        <?php if ($admin) echo "<th>Supprimer</th>"; ?>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($images as $item) {
        echo "<tr>
                    <td>" .
            $this->Html->link(
                $item['name'],
                ['controller' => 'Images', 'action' => 'listing', $item['name']],
                ['escapeTitle' => false]
            ) .
            "</td>
                    <td>" . $item['description'] . "</td>
                    <td>" . $item['width'] . "</td>
                    <td>" . $item['height'] . "</td>
                    <td>" .
            $this->Html->link(
                $this->Html->image(
                    '/img/' . $item['name'],
                    ['alt' => $item['name'], 'width' => '250px', 'height' => 'auto']
                ),
                ['controller' => 'Images', 'action' => 'view', $item['name']],
                ['escapeTitle' => false]
            ) .
            "</td>

                    <td class='center-item'>" . $this->Html->link(
                '<i class="fa-solid fa-download fa-2x fa-black"></i>',
                '/img/' . $item['name'],
                ['escapeTitle' => false, 'download' => '/img/' . $item['name']]
            ) . "
                    </td>";
        if ($admin) {
            echo "<td class='center-item'>" . $this->Form->postLink(
                    '<i class="fa-solid fa-trash-can fa-2x fa-red"></i>',
                    ['controller' => 'Images', 'action' => 'delete', $item['id']],
                    ['escapeTitle' => false,
                        'confirm' => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $item['name'])
                    ]
                ) . "</td>";
        }
        echo "</tr>";
    }
    ?>
    </tbody>
</table>

<?php
if ($page > 1) {
    if ($page - 1 == 1 && !$album) {
        if ($limit == 12) {
            echo $this->Html->link(
                'Page précédente',
                ['controller' => 'Images', 'action' => 'listing'],
                ['class' => 'button']
            );
        } else {
            echo $this->Html->link(
                'Page précédente',
                ['controller' => 'Images', 'action' => 'listing', '?' => ['limit' => $limit]],
                ['class' => 'button']
            );
        }
    } else {
        if ($limit == 12) {
            echo $this->Html->link(
                'Page précédente',
                ['controller' => 'Images', 'action' => 'listing', '?' => ['page' => $page - 1]],
                ['class' => 'button']
            );
        } else {
            echo $this->Html->link(
                'Page précédente',
                ['controller' => 'Images', 'action' => 'listing', '?' => ['limit' => $limit, 'page' => $page - 1]],
                ['class' => 'button']
            );
        }
    }
}
if ($page < $maxPage && !$album) {
    if ($limit == 12) {
        echo $this->Html->link(
            'Page suivante',
            ['controller' => 'Images', 'action' => 'listing', '?' => ['page' => $page + 1]],
            ['class' => 'button next-button']
        );
    } else {
        echo $this->Html->link(
            'Page suivante',
            ['controller' => 'Images', 'action' => 'listing', '?' => ['limit' => $limit, 'page' => $page + 1]],
            ['class' => 'button next-button']
        );
    }
}
?>
