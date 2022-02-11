<?php

$this->assign('title', 'Liste des images');

/** @var array $images */
/** @var int $page */
/** @var int $maxPage */
/** @var int $limit */
/** @var int $info */
/** @var \Cake\ORM\Entity $comment */

if (!$info)
     echo $this->Html->link(
        "Ajouter une image",
        ["Controller" => "Images", "action" => "add"],
        ["escapeTitle" => false, "class" => "button"]);
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
                    <td>" .
                $this->Html->link(
                    $item['name'],
                    ["Controller" => "Images", "action" => "listing", $item['name']],
                    ["escapeTitle" => false]) .
                    "</td>
                    <td>" . $item['description'] . "</td>
                    <td>" . $item['width'] . "</td>
                    <td>" . $item['height'] . "</td>
                    <td>" .
                $this->Html->link(
                    $this->Html->image("/img/" . $item['name'], ["alt" => $item['name'], "width" => "250px", "height" => "auto"]),
                        ["Controller" => "Images", "action" => "listing", $item['name']],
                        ["escapeTitle" => false]) .
                    "</td>

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
    if ($info) {
        echo "<table>
            <thead>
                <tr><th colspan=\"2\">Commentaires</th></tr>
            </thead>
            <tbody>
                <tr>
                    <td>Bonjour je trouve cette image magnifique !</td>
                    <td>06/02/2022</td>
                </tr>
                <tr>
                    <td>Wow très impressionnant</td>
                    <td>22/01/2022</td>
                </tr>
            </tbody>
        </table>";

        echo $this->Form->create();
        echo $this->Form->control("", ["type" => "textarea", "maxlength" => 500]);
        echo $this->Form->button("Ajouter le commentaire");
        echo $this->Form->end();
    }
?>

<?php
    if ($page > 1) {
        if ($page-1 == 1 && !$info) {
            if ($limit == 12)
                echo $this->Html->link('Page précédente', ["controller" => 'Images', 'action' => 'listing'], ['class' => 'button']);
            else
                echo $this->Html->link('Page précédente', ["controller" => 'Images', 'action' => 'listing', '?' => ['limit' => $limit]], ['class' => 'button']);
        } else {
            if ($limit == 12)
                echo $this->Html->link('Page précédente', ["controller" => 'Images', 'action' => 'listing', '?' => ['page' => $page - 1]], ['class' => 'button']);
            else
                echo $this->Html->link('Page précédente', ["controller" => 'Images', 'action' => 'listing', '?' => ['limit' => $limit, 'page' => $page - 1]], ['class' => 'button']);
        }
    }
    if ($page < $maxPage && !$info) {
        if ($limit == 12)
            echo $this->Html->link('Page suivante', ["controller" => 'Images', 'action' => 'listing', '?' => ['page' => $page + 1]], ['class' => 'button next-button']);
        else
            echo $this->Html->link('Page suivante', ["controller" => 'Images', 'action' => 'listing', '?' => ['limit' => $limit, 'page' => $page + 1]], ['class' => 'button next-button']);
    }
?>
