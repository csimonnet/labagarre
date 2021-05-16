#La Bagarre (version simplifiée de la bataille)

## Pour jouer : 

Lancez simplement le script php launcher.php situé à la racine du dossier. Le nom de chaque joueur devra être 
saisi (par défaut, 2 joueurs, mais le jeu est conçu pour pouvoir être joué à n'importe quel nombre). Ensuite, laissez faire le hasard et vous aurez le résultat du match.

## Informations supplémentaires

Le script nécessite php >= 7.4 pour s'éxécuter correctement.

## Tests

Deux tests unitaires très minimaux ont été développés avec PhPUnit ; il est nécessaire de l'installer et 
de configurer son autoload sur celui présent à la racine du dossier pour les exécuter.

## Architectures et évolutions possibles (nécessaires !)

### Existant
Le jeu repose principalement sur deux classes qui vont déterminer l'état du jeu : `GameRunner` et `RoundRunner`.
A chaque étape, elles représentent dans quel round on se trouve, quels joueurs ont joué, et quelles cartes ils ont joué.

Ces classes sont soumises à l'interface `Runner` pour qu'elles soient utilisables toujours sous le même contrat.
Chaque étape est alors exécutable via la méthode `nextStep` de chaque runner. 

Les classes qui affichent les résultats (les classes du dossier Display) ont surtout besoin de l'état du runner et des principales propriétés : joueurs, cartes, etc...

Le but était de pouvoir afficher à chaque étape ce qu'il se passe (quel joueur joue quelle carte) mais aussi, si l'on préfère séparer les étapes par un appui de touche, rajouter un scanf entre les différentes étapes ou quoique ce soit.

Les runners Game et Round ont été aussi séparés, ce qui permettrait sur le long terme de pouvoir séparer les deux fonctions. Ainsi le "Game" exécute seulement le round, on peut changer les conditions de passage au round suivant, etc.
Le Round peut donc aussi avoir ses propres conditions pour dire s'il est terminé ou non, et comment il s'exécute sans que le "Game" n'y intervienne.

### A améliorer

* Fonctionnalités
  
Ces fonctionnalités ne sont pas implémentées mais seraient plutôt facilement ajoutable en l'état.

   - On peut ajouter facilement un mode de jeu automatique / manuel, où il s'agirait de devoir appuyer sur Entrée à chaque étapes ou à certaines seulement, ou a aucune et laisser le jeu faire comme actuellement.
   - Un récap de fin de jeu avec classement et gestion des égalités
   - Pouvoir abandonner un jeu


* La décorrélation et le découpage en service
  Selon les besoins futurs, on devrait pouvoir plus agir sur la décorrélation entre les games et les rounds si nécessaire.
  De plus, le déroulé d'un round est ici encore "en dur", néanmoins on peut ajouter la notion de Turn pour gérer ça complètement (ici, cela correspond à nos "cardsPlayed"). Un tour pourrait implémenter lui aussi l'interface "Runner".
  
  Le DeckMaster tel qu'il est pourrait également prendre plus de responsabilités, et gérer de façon générique la construction de decks et la distribution de cartes ; il correspondrait davantage à un "croupier" pouvant faire des opérations liées aux decks et aux cartes.

  Il y a aussi beaucoup de propriétés qui sont à la fois dans les runners, et les "pojos" tels que Game ou Round. A la base, les pojos sont effectivement disponibles pour sauvegarder le game, qui a joué, qui a gagné, etc. Ces pojos font encore un peu trop d'opérations.

* Gestion d'erreurs

Peu d'erreurs sont encore gérées, par exemple le fait de n'avoir qu'un joueur en configuration, des erreurs sur les incompatibilités d'état, etc...

### Note subsidiaire

Des petits commentaires pour expliquer l'architecture sont mis dans le code ; techniquement sur du code de production ce genre de commentaires n'existerait pas.
Ils existent plus dans le cadre du test technique pour justifier de certains choix peut-être discutables.