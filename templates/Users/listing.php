<?php
/** @var array $users */

$this->assign('title', 'Utilisateurs');
?>

<table>
    <thead>
    <tr>
        <th>Id</th>
        <th>Pseudo</th>
        <th>Email</th>
        <th class="center-item">Supprimer</th>
    </tr>
    </thead>
    <tbody>
    <?php
    foreach ($users as $item) {
        echo "<tr>
                <td>" . $item['id'] . "</td>
                <td>" . $item['pseudo'] . "</td>
                <td>" . $item['email'] . "</td>
                <td class='center-item'>" .
                    $this->Form->postLink(
                        '<i class="fa-solid fa-trash-can fa-2x fa-red"></i>',
                        ['controller' => 'Users', 'action' => 'delete', $item['id']],
                        ['escapeTitle' => false,
                            'confirm' => __("Etes-vous sûr de vouloir supprimer l'utilisateur {0} ?", $item['pseudo'])
                        ]
                    ) . "
                </td>
            </tr>";
    }
    ?>
    </tbody>
</table>
