# Gestionnaire d'images
By Léon DUMESTRE


## Installation

Une fois dans le dossier global du projet :

1. Télécharger Composer

```bash
composer install
```

2. Lancer le serveur

```bash
bin/cake server -p 8765
```

Vous pouvez désormais visiter `http://localhost:8765` pour voir le site.

## Migration

Je n'ai pas réussi à effectuer la migration de la base de données.
Le fichier `FirstMigration` est pourtant bien créer dans le dossier `/config/Migrations`.
Pour pallier à cela, une base de données vide est importée avec le Git.

## Visuel

Il n'y a actuellement aucune données sur le site donc il est normal que le tableau soit vide.

## Administration

ATTENTION : Le 1er compte créé sera le seul et unique compte administrateur.
            Choississez-le avec soin.
