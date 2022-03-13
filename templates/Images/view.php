<?php
/** @var \Cake\ORM\Entity $image */
/** @var \Cake\ORM\Entity $comment */

$this->assign('title', $image['name']);

$admin = false;
$connected = false;
if ($this->Identity->isLoggedIn()) {
    $connected = true;
    if ($this->Identity->get("id") == 1 || $this->Identity->get("id") == $image['id'])
        $admin = true;
}
?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Auteur</th>
            <th>Description</th>
            <th>Dimensions</th>
            <th>Image</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td> <?= $image['name'] ?> </td>
            <td> <?php if ($image['user'] != null) echo $image['user']['pseudo'] ?> </td>
            <td> <?php if ($admin): ?>
                <div class="no-title">
                    <?php echo $this->Form->create(
                        null,
                        ['url' => ["controller" => "Images", "action" => "updateDescription", $image->id]]
                    );
                    echo $this->Form->control(
                        "description",
                        ["required" => true, "type" => "textarea", "maxlength" => 500, "value" => $image['description']]
                    );
                    echo $this->Form->button('Valider');
                    echo $this->Form->end(); ?>
                </div>
                <?php else:
                    echo $image['description'];
                endif; ?>
            </td>
            <td class="center-item">
                <div>
                    <?= $image['width']; ?>
                </div>
                <div>
                    <?= $image['height']; ?>
                </div>
            </td>
            <td>
                <?= $this->Html->link(
                    $this->Html->image("/img/" . $image['name'], ["alt" => $image['name'], "width" => "250px", "height" => "auto"]),
                    [],
                    ["escapeTitle" => false]) ?>
            </td>

            <td class='center-item'>
                <div>
                    <?= $this->Html->link(
                        '<i class="fa-solid fa-download fa-2x fa-black"></i>',
                        '/img/' . $image['name'],
                        ['escapeTitle' => false, 'download' => '/img/' . $image['name']]
                    ); ?>
                </div>
                <?php if ($admin): ?>
                <div>
                    <?= $this->Form->postLink(
                        '<i class="fa-solid fa-trash-can fa-2x fa-red"></i>',
                        ['controller' => 'Images', 'action' => 'delete', $image['id']],
                        ['escapeTitle' => false,
                            'confirm' => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $image['name'])
                        ]
                    ); ?>
                </div>
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
