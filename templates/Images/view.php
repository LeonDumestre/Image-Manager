<?php
/** @var \Cake\ORM\Entity $image */
/** @var \Cake\ORM\Entity $comment */

$this->assign('title', $image['name']);

$admin = false;
if ($this->Identity->isLoggedIn()) $admin = $this->Identity->get("admin");
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
        <tr>
            <td> <?= $image['name'] ?> </td>
            <td> <?= $image['description'] ?> </td>
            <td> <?= $image['width'] ?> </td>
            <td> <?= $image['height'] ?> </td>
            <td>
                <?= $this->Html->link(
                    $this->Html->image("/img/" . $image['name'], ["alt" => $image['name'], "width" => "250px", "height" => "auto"]),
                    [],
                    ["escapeTitle" => false]) ?>
            </td>

            <td class='center-item'> <?= $this->Html->link(
                "<i class=\"fa-solid fa-download fa-2x fa-black\"></i>",
                "/img/" . $image['name'],
                ["escapeTitle" => false, "download" => "/img/" . $image['name']]) ?>
            </td>

            <?php if ($admin): ?>
                <td class='center-item'>
                    <?= $this->Form->postLink(
                        "<i class='fa-solid fa-trash-can fa-2x fa-red'></i>",
                        ['Controller' => 'Images', 'action' => 'delete', $image['id']],
                        ['escapeTitle' => false,
                            'confirm' => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $image['name'])]
                    ) ?>
                </td>
            <?php endif; ?>
        </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
        <th>Commentaires</th>
         <?php if ($admin) echo "<th class='center-item'>Supprimer</th>" ?>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($image['comments'] as $item): ?>
        <tr>
            <td> <?= $item['content'] ?> </td>
            <?php if ($admin): ?>
                <td class='center-item'>
                <?= $this->Form->postLink(
                    "<i class='fa-solid fa-trash-can fa-2x fa-red'></i>",
                    ['controller' => 'Comments', 'action' => 'delete', $item['id']],
                    ['escapeTitle' => false,
                        'confirm' => __("Etes-vous sûr de vouloir supprimer le commentaire ?")
                    ]
                ) ?>
                </td>
            <?php endif; ?>
        </tr>
    <?php endforeach; ?>

    </tbody>
</table>

<div class='no-title'>
<?php
echo $this->Form->create(null, ['url' => ["controller" => "Comments", "action" => "add", $image->id]]);
echo $this->Form->control(
    "content",
    ["required" => true, "type" => "textarea", "maxlength" => 500]
);
echo $this->Form->button('Ajouter le commentaire');
echo $this->Form->end(); ?>
</div>
