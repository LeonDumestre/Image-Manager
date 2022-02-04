<?php

$this->assign('title', 'Images - Listing');

/** @var array $dataArray */
/** @var int $page */
?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Auteur</th>
            <th>Description</th>
            <th>Image</th>
            <th>DL</th>
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($dataArray as $item)
            echo "<tr>
                    <td>" . $item['file'] . "</td>
                    <td>" . $item['author'] . "</td>
                    <td>" . $item['description'] . "</td>
                    <td>" . $item['Html'] . "</td>
                    <td><a download=\"/img/" . $item['file'] . "\" href=\"/img/" . $item['file'] . "\" title=\"" . $item['file'] . "\">
                        <img alt=\"icon_download\" src=\"img/icon/icon_download.png\" width=25'>
                    </a></td>
                </tr>";
    ?>
    </tbody>
</table>

<?php
$page = 1;
    if ($page >= 1) echo "<a class='button'>Page précédente</a>";
    if ($page == 1) echo "<a class='button next-button'>Page suivante</a>";
?>
