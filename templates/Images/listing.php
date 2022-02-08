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
                    <td><img src=\"/img/" . $item['name'] . "\" alt=\"" . $item['name'] . "\" width=150 height=auto></td>
                    <td><a download=\"/img/" . $item['name'] . "\" href=\"/img/" . $item['name'] . "\" title=\"" . $item['name'] . "\">
                        <img alt=\"icon_download\" src=\"/img/icon/icon_download.png\" width=25'></a>
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
