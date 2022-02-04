<?php

$this->assign('title', 'Images - Listing');

/** @var array $dataArray */
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
                    <td><a download=\"/img/" . $item['file'] . "\" href=\"/img/" . $item['file'] . "\"title=\"" . $item['file'] . "\">
                        <img alt=\"icon_download\" src=\"img/icon/icon_download.png\" width=30 style='align-items: center'>
                    </a></td>
                </tr>";
    ?>
    </tbody>
</table>
