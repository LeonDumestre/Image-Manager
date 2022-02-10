<?php

$this->assign('title', 'Liste des images');

/** @var array $images */
/** @var int $page */


 echo $this->Html->link(
    "Ajouter une image",
    ["Controller" => "Images", "action" => "add"],
    ["escapeTitle" => false, "class" => "button"])
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
        foreach ($images as $item)
            echo "<tr>
                    <td>" . $item['name'] . "</td>
                    <td>" . $item['description'] . "</td>
                    <td>" . $item['width'] . "</td>
                    <td>" . $item['height'] . "</td>
                    <td>" . $this->Html->image("/img/" . $item['name'], ["alt" => $item['name'], "width" => "250px", "height" => "auto"]) . "</td>
                    <td class='center-item'>" . $this->Html->link(
                        "<i class=\"fa-solid fa-download fa-2x fa-black\"></i>",
                        "/img/" . $item['name'],
                        ["escapeTitle" => false, "download" => "/img/" . $item['name']]) . "
                    </td>
                    <td class='center-item'>" . $this->Form->postLink(
                        "<i class=\"fa-solid fa-trash-can fa-2x fa-red\"></i>",
                        ["Controller" => "Images", "action" => "delete", $item['id']],
                        ["escapeTitle" => false, "confirm" => __("Etes-vous sûr de vouloir supprimer l'image {0} ?", $item['name'])]) . "
                    </td>
                </tr>";
    ?>
    </tbody>
</table>

<?php
$page = 1;
    if ($page > 1) echo "<a class='button'>Page précédente</a>";
    if ($page <= 1) echo "<a class='button next-button'>Page suivante</a>";
?>
