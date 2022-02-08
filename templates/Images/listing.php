<?php

$this->assign('title', 'Images - Listing');

/** @var array $images */
/** @var int $page */
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
    //TODO Remplacer les img par des PHP Helper
        foreach ($images as $item)
            echo "<tr>
                    <td>" . $item['name'] . "</td>
                    <td>" . $item['description'] . "</td>
                    <td>" . $item['width'] . "</td>
                    <td>" . $item['height'] . "</td>
                    <td>" . $this->Html->image("/img/" . $item['name'], ["width" => "200px", "height" => "auto"]) . "</td>
                    <td><a download=\"/img/" . $item['name'] . "\" href=\"/img/" . $item['name'] . "\" title=\"" . $item['name'] . "\">" .
                         $this->Html->image("/img/icon_download.png", ["width" => "25px", "height" => "25px"]) . "</a>
                    </td>
                    <td>" . $this->Form->postLink(
                        "delete",
                        ["Controller" => "Images", "action" => "delete", $item['id']]) . "
                    <img alt=\"icon_delete\" src=\"/img/icon/icon_delete.png\" width=20'></td>
                </tr>";
    ?>
    </tbody>
</table>

<?php
$page = 1;
    if ($page > 1) echo "<a class='button'>Page précédente</a>";
    if ($page <= 1) echo "<a class='button next-button'>Page suivante</a>";
?>
