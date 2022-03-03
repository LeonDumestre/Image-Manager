<?php
/** @var \Cake\ORM\Entity $image */

$this->assign('connect', true);
$this->assign('title', $image['name']);


$session = $this->request->getSession();
$admin = false;
if (($session->check("Admin") && $session->read("Admin")) ||
    ($session->check("Id") && $session->read("Id") == $image['author'])) {
    $admin = true;
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
    echo "<tr>
            <td>" . $image['name'] . "</td>
            <td>" . $image['description'] . "</td>
            <td>" . $image['width'] . "</td>
            <td>" . $image['height'] . "</td>
            <td>" .
        $this->Html->link(
            $this->Html->image("/img/" . $image['name'], ["alt" => $image['name'], "width" => "250px", "height" => "auto"]),
                [],
                ["escapeTitle" => false]) .
            "</td>

            <td class='center-item'>" . $this->Html->link(
                "<i class=\"fa-solid fa-download fa-2x fa-black\"></i>",
                "/img/" . $image['name'],
                ["escapeTitle" => false, "download" => "/img/" . $image['name']]) . "
            </td>";

    if ($admin) {
        echo "<td class='center-item'>" . $this->Form->postLink(
                '<i class="fa-solid fa-trash-can fa-2x fa-red"></i>',
                ['Controller' => 'Images', 'action' => 'delete', $image['id']],
                ['escapeTitle' => false,
                    'confirm' => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $image['name'])
                ]
            ) . "</td>";
    }
    echo "</tr>";
    ?>
    </tbody>
</table>
<?php
    echo "<table>
            <thead>
                <tr>
                <th>Commentaires</th>";
                 if ($admin) echo "<th class='center-item'>Supprimer</th>";
    echo "</tr>
            </thead>
            <tbody>";

    foreach ($image['comments'] as $item) {
        echo "<tr>
                <td>" . $item['content'] . "</td>";
        if ($admin) echo "<td class='center-item'>" .
            $this->Form->postLink(
                '<i class="fa-solid fa-trash-can fa-2x fa-red"></i>',
                ['controller' => 'Comments', 'action' => 'delete', $item['id']],
                ['escapeTitle' => false,
                    'confirm' => __("Etes-vous sûr de vouloir supprimer le commentaire ?")
                ]
            ) . "</td>";
            echo "</tr>";
        }

    echo "</tbody>
            </table>";


/** @var \Cake\ORM\Entity $comment */
    echo $this->Form->create(null, ['url' => ["controller" => "Comments", "action" => "add", $image->id]]);
    echo "<div class='no-title'>";
    echo $this->Form->control(
        "content",
        ["required" => true, "type" => "textarea", "maxlength" => 500]
    );
    echo "</div>";
    echo $this->Form->button('Ajouter le commentaire');
    echo $this->Form->end();
?>
