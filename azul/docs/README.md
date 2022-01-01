# azul

## Fonctionnement d'azul

A son exécution (ou bien en arguments),

Le joueur renseigne les paramètres de la partie :
* Nombres de joueurs. -> influence sur le nombre de `factory`.
* Mode graphique ou textuel.
* Différentes variantes.

### Déroulement de la partie

Condition de victoire : l'une des lignes du *wall* d'un joueur est remplie de tuiles (`Tile`) de couleurs différentes.
Le joueur ayant le score le plus élévé gagne.

Une partie est une succession de manches, elles même décomposées en 3 phases :
* La phase de préparation : 
	1. Vérifier que les fabriques et le centre du plateau sont vides.
	2. Remplir chaque fabrique avec 4 tuiles piochées dans le sac.
	3. Dès que le sac est vide il remplit avec le contenu de la défausse (si la défausse l'est aussi la phase de préparation est intérompue).
	4. Placer la tuile premier joueur au centre du plateau.
* La phase d'offre :
	5. Le joueur ayant récupéré la tuile premier joueur durant la manche précédante commence.
	6. Ensuite, jusqu'à ce que toutes les fabriques et le centre du plateau soient vides :
		1. Le joueur peut soit récuperer toutes les tuiles d'une même couleur d'une fabrique et alors les tuiles restantes sont déplacées au centre du plateau.
		2. Soit il choisit de récupérer les tuiles d'une même couleur situées au centre du plateau. Si il est le premier il récupère également la tuile premier joueur.
      	1. Le joueur doit ensuite placer les tuiles récupérées sur une même ligne où :
         	* La ligne en question doit être vide ou contenir des tuiles de même couleur.
           	* La ligne correspondante sur son mur ne doit pas déjà contenir la couleur.
        1. Les tuiles ne pouvant être placées sur une ligne sont placées sur le plancher (en partant de la droite).
* La phase de décoration :
   1. Pour chaques lignes : 
		* Si la ligne est complète, on place une des tuiles sur la case correspondante sur le mur. Et le reste est défaussé.
		* Sinon, les tuiles restent et ne sont donc pas défaussées.
	2. Les points de chaques joueurs sont ensuite mis à jour.
	3. Les tuiles du plancher sont défaussées.

### Variantes de jeu

La première variante consiste à jouer avec un mur incolore.
Pour que le jeu ne puisse pas se bloquer, lorsque un joueur place une tuile sur une ligne de son mur il est libre d'en choisir la couleur parcontre cela va fixer la couleur des autres tuiles de la même couleur pour le reste du mur, dans le but de ne pas avoir deux tuiles de la même couleur sur la même ligne ou colonne.

La deuxième consiste à rajouter des tuiles joker.
Lorsqu'un joueur récupère des tuiles d'une fabrique ou du centre de la table, il peut choisir (en plus des options habituelles) de prendre toutes le tuiles joker de ce lieu, ou toutes les tuiles joker et toutes les tuiles d'une autre couleur.

## UI

### Textuelle

#### Affichage de l'état du jeu

Total width = ? char.

Soit `colorn` la couleur de la tuile et `......` lorsque la case est vide.

Les fabriques : 

```
------------- 1 -------------     ------------- 9 -------------
|color1 color2 color3 color4| ... |color1 ...... ...... color4|
-----------------------------     -----------------------------
```

Le centre :

```
- Center ------------------------
|color1 color2 color3 ... colorn|
---------------------------------
```

Le plateau du joueur :

```
- Player 1 ---------------------------------------------------------------------
|                                                                              | 
|  - Pattern --------------------------  - Wall -----------------------------  |
|  |colorN                            |  |colorN colorN colorN colorN colorN|  |
|  |colorN colorN                     |  |colorN colorN colorN colorN colorN|  |
|  |colorN colorN colorN              |  |colorN colorN colorN colorN colorN|  |
|  |colorN colorN colorN colorN       |  |colorN colorN colorN colorN colorN|  |
|  |colorN colorN colorN colorN colorN|  |colorN colorN colorN colorN colorN|  |
|  ------------------------------------  ------------------------------------  |
|                                                                              |
|  - Floor ------------------------------------------          - Score ------  |
|  |color1 color2 color3 ...... ...... ...... ......|          |     10     |  |
|  --[-1]---[-1]---[-2]---[-2]---[-2]---[-3]---[-3]--          --------------  |
|                                                                              |
--------------------------------------------------------------------------------
```

#### Dialogue avec l'utilisateur

Au lancement :

```
Fill in the number of players : ( 2 3 4 )
4

Choose the variant : ( (1) classic, (2) with joker, (3) with uncolored tile )
2

Do you want to start the graphic mode ? ( yes or no )
no
```

Durant une manche :
```
( affichage de l'etat du jeu )

[Player] [Container] [Id] [Color] [Line]

Ex:
	Player1 factory/f 1 blue 3
	Player2 center/c 0 white 2
	... 
```

## Modélisation 

> Note : dans cette partie, les mots 'sémantique' et 'modélisation' peuvent être
interchangés.

**Système de coordonnées**: 
```
	  xPos
	--------->
	|
yPos|
	|
	v
```

### Datamodel

#### Enumérations [2]

`colorNolor`, représente toutes les couleurs pouvant être stockées par une tuile.\
**Intérêt** : sémantique et modularité, enfet, elle permet de simplifier leur 
manipulation. Toutes les couleurs sont regroupées au même endroit, 
ainsi l'ajout de couleur est simplifié.
( Ex : get(int) et equals(colorNolor) ).

`Direction`, est utilisé par les classes `colorNontainerX` et `colorNontainerXY`.\
**Intérêt** : sémantique et la fonction `equals(Direction)`.

#### Interfaces [1]

`LimitedSize`, permet d'avoir des ensembles de cases de taille maximale.\
**Intérêt** : facilite la modélisation d'un comportement.

#### Classes [13] 

`Tile`, représente une tuile.\
**Intérêt** : sémantique.

`colorNontainerX`, représente une 'case' à une seule dimension.\
**Intérêt** : sémantique, modularité et pour le calcul du score.

`colorNontainerXY`, étend `colorNontainerXY` et représente une 'case'
 à deux dimensions.\
**Intérêt** : sémantique, le calcul du score et permet le stockage dans une seule 
liste.

`ContainerListX`, manipule les `colorNontainerX`.\
**Intérêt** : facilite la manipulation des cases et l'implémentation des classes du
jeu.

`ContainerListXY`, étend `ContainerListX` et manipule des `colorNontainerXY`.\
**Intérêt** : facilite la manipulation des cases et l'implémentation des classes :
`Wall` et `PatternLines`.

`TileStack`, implémente une pile de `Tile`.\
**Intérêt** : sert de classe mère pour les classes `Bag` et `Discard` car ces deux 
classes n'ont pas besoins de stocker les tuiles dans un ordre particulier.

`Bag`, étend la classe `TileStack` est représente la pioche.\
**Intérêt** : facilite la création des tuiles selon la variantes de jeu ainsi que 
le tirage au hasard d'un nombre n de tuile.

`Discard`, étend `TileStack`.\
**Intérêt** : sémantique et (modularité).

`Center`, étend `colorNontainerX` et représente le centre du plateau de jeu.\
**Intérêt** : facilite la représentation et la manipulation des tuiles.

`Factory`, étend `colorNontainerX` implémente `LimitedSize` et représente une fabrique.\
**Intérêt** : permet d'avoir des ensemble de tuile avec une taille définie.

`Floor`, étend `colorNontainerX` implémente `LimitedSize` et représente le 'plancher'
(stock les tuiles ne pouvant être placées sur les lignes de motifs).
**Intérêt** : modélisation et facilite le calcul des scores.

`PatternLines`, étend `colorNontainerXY` implémente `LimitedSize` et représente les
lignes de motifs.\
**Intérêt** : modélisation et manipulation des colorNontainerXY avec des tailles limitées.

`Wall`, étend `colorNontainerXY` implémente `LimitedSize` et représente le mur.\
**Intérêt** : modélisation et manipulation des colorNontainerXY avec des tailles limitées.