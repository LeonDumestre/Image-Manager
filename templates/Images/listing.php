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
        </tr>
    </thead>
    <tbody>
    <?php
        foreach ($dataArray as $item)
            echo "<tr><td>" . $item['file'] . "</td>
                <td>" . $item['author'] . "</td>
                <td>" . $item['description'] . "</td>
                <td>" . $item['Html'] . "</td></tr>";
    ?>
    </tbody>
</table>
