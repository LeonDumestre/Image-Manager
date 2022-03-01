<?php

$this->assign('connect', $this->Html->link("Se connecter", ["controller" => 'Users', 'action' => 'connect'], ['class' => 'button']));
$this->assign('title', 'Liste des images');

/** @var \Cake\ORM\Entity $image */

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
            <th>Supprimer</th>
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
            </td>

            <td class='center-item'>" . $this->Form->postLink(
                "<i class=\"fa-solid fa-trash-can fa-2x fa-red\"></i>",
                ["Controller" => "Images", "action" => "delete", $image['id']],
                ["escapeTitle" => false, "confirm" => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $image['name'])]) . "
            </td>

        </tr>";
    ?>
    </tbody>
</table>
<?php
    echo "<table>
            <thead>
                <tr><th colspan=\"2\">Commentaires</th></tr>
            </thead>
            <tbody>";

    foreach ($image['comments'] as $item)
        echo "<tr>
            <td>" .  $item['content'] . "</td>
        </tr>";

    echo "</tbody>
            </table>";


/** @var \Cake\ORM\Entity $comment */
    echo $this->Form->create(null, ['url' => ["controller" => "Comments", "action" => "add", $image->id]]);
    echo $this->Form->control("content", [ "required" => true, "type" => "textarea", "maxlength" => 500]);
    echo $this->Form->button('Ajouter le commentaire');
    echo $this->Form->end();
?>
