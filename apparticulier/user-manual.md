# Instructions

## Initialisation

Avant de commencer, il faudra créer la base de donnée à l’aide du fichier
*Models/create_tables.sql* et changer les identifiants de connexion MySQL dans la
fonction `f_request_connection()` situé dans le fichier *Controls/f_request.php*.

## Utilisation

Notre site propose quatre expériences différentes, en tant qu’administrateur,
en tant que propriétaire, en tant qu’acheteur ou bien en simple visiteur.

L'index de notre site est la page *accueil.php*.
Elle est composée d'une barre de navigation en haut de la page ainsi qu'un formulaire de recherches.
Le menu comporte le nom de notre site en haut à gauche qui est un lien vers la page
accueil.php, ainsi qu'un lien vers les pages de connexion et d'inscription tant
que l'utilisateur n'est pas connecté. Si vous êtes nouveau sur le site vous
pouvez à tout moment vous inscrire en cliquant sur inscrire puis en remplissant
le formulaire, si vous êtes ancien vous n’avez qu’à cliquer sur connexion et à
entrer votre login et votre mot de passe (qui sont les mêmes pour les
utilisateurs déjà préenregistrés dans la base de données).  Lorsque vous êtes
connectez en tant qu’administrateur vous disposez d’une barre de navigation
différente, vous pouvez modifier, ajouter ou supprimer des utilisateurs grâce à
l'option “gérer les utilisateurs”. La suppression d'un utilisateur entraîne la
suppression de ses conversations, de ses messages et de ses annonces s’il est
propriétaire.  En survolant le vôtre pseudo dans la barre de navigation vous
accédez à un menu déroulant contenant les liens permettant d'accéder à votre
profil, vos conversations et de se déconnecter.  Si vous êtes connecté en tant
que propriétaire l'option “gérer les utilisateurs” et remplacée par l'option
“poster une annonce”.  Le visiteur possède les mêmes options que l'acheteur
cependant, il ne pourra pas contacter les propriétaires par messages.  Toujours
sur la page d’accueil, que vous soyez administrateur, acheteur, propriétaire ou
visiteur vous disposez de deux outils de recherche pour trouver une annonce.

### Inscription

Lorsque vous souhaitez vous inscrire sur le site deux choix s’offrent à vous,
suivant si vous souhaitez acheter ou vendre, l’attribut `auto` qui corresponds
au niveau d’autorisation de l’utilisateur sera envoyer via un input `hidden`
par le formulaire (un administrateur possède un niveau d’autorisation égale à
2, le vendeur à 1 et l’acheteur à 0).

> Remarque : il y a seulement deux administrateurs déjà enregistré dans la base
> de données et il est impossible d’en ajouter d’autre.

### Trouver une annonce

Une recherche avec la searchbar affichera les annonces comprenant le terme de
votre recherche dans leur description. Attention : ce mode est sensible à la
casse et également aux espaces !  Vous pouvez également choisir une annonce
grâce aux options : la ville, le prix et la superficie.
Attention ! Il faut obligatoirement utiliser les 3 options !
Les annonces dont le prix correspond à celui que vous avez choisi à 100 000
euros près et dont la superficie correspond à celle choisis, à 30 m² près.
Vous pourrez ensuite voir le détail de de chaque annonce en cliquant sur le
lien rouge prévu à cet effet.

### Poster une annonce

Vous devez pour cela obligatoirement être un vendeur. Vous cliquez donc sur
“poster une annonce” Vous êtes redirigé sur une page où vous attends un
formulaire, vous le remplissez et cliquer sur le bouton “Poster mon annonce”.
Une seconde page fait un bref récapitulatif de votre annonce et vous demande
une confirmation. Après avoir accepté, un message apparaît alors pour vous
annoncer le succès (ou non) de l’enregistrement de l’annonce dans la base de
données.

### Supprimer une annonce

Seul un administrateur ou le propriétaire d’une annonce peut la supprimer.
Pour cela, l’utilisateur doit se rendre sur sa page de profil et cliquer
sur “Voir annonces”, la liste des annonces possédées par l’utilisateur
s’affiche. Il suffit de cocher les checkboxs correspondantes aux annonces
que l’utilisateur veut supprimer avant de cliquer sur “Supprimer les
annonces”.

### Gérer les utilisateurs

L’administrateur peut consulter le profil de n’importe quel utilisateur
enregistré dans la base de données. Il peut également modifier le profil d’un
utilisateur, le supprimer, ou en enregistrer un nouveau.

### Les messages

En cliquant sur “messages” dans la barre de navigation la liste de ses
conversations sont affichées et en cliquant dessus il accède aux messages de
cette conversations où il peut en écrire des nouveaux ou supprimer les anciens.
Un acheteur créer une nouvelle conversation en allant sur la page de profil
du propriétaire qu’il souhaite contacter via une des annonces qu’il a
postées, puis en cliquant sur “Envoyer un message”. Si les deux
utilisateurs se sont déjà contactés auparavant, l’acheteur est alors
redirigé vers cette conversation sinon une nouvelle conversation est créée.

### Déconnexion

La déconnexion se fait via la barre de navigation dans l’onglet <Nom_User> puis
“Déconnexion” ou bien lorsque l’utilisateur supprime son compte depuis sa page
de profil. Sa session est alors supprimée et il est redirigé vers la page
d’accueil.
