<?php

spl_autoload_register(function($className) {
    $className = str_replace("\\", DIRECTORY_SEPARATOR, $className);
    $className = str_replace("labagarre", "./", $className);
    include_once $className . '.php';
});

use labagarre\src\Game;

CONST NB_PLAYERS = 2;

echo "Bienvenue dans LA BAGARRE. \r\n";
echo "La Bagarre est une version simplifiée de la bataille. Choisis juste un nom, et joins-toi au combat ! \r\n";
echo "Prêt à combattre ? \r\n";

$game = new Game();

for ($i=1; $i <= NB_PLAYERS; $i++) {
    $playerName = "Joueur ".$i;
    echo "Joueur {$i} : écris le nom de ton combattant : \r\n";
    fscanf(STDIN, "%s", $playerName);
    $game->addPlayer($playerName);
}

echo "Répartition des cartes en cours.... \r\n";
$game->begin();
echo "C'est parti !\r\n";

while (!$game->isOver()) {
    $game->launchRound()
        ->displayRoundStatus()
        ->endRound();
}

