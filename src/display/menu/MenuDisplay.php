<?php


namespace labagarre\src\display\menu;

use labagarre\src\Configuration;

class MenuDisplay
{

    public static function display() {
        echo "\033[31m_______________________________________________\r\n";
        echo "\r\n";
        echo "\033[1m| (╬ ಠ益ಠ)\033[1m Bienvenue dans LA BAGARRE. ᕦ(ò_óˇ)ᕤ \033[1m |\r\n ";
        echo "\033[31m_______________________________________________\r\n";
        echo "\r\n";
        echo "\033[0mLa Bagarre est une version simplifiée de la bataille. \r\n Chaque joueur choisit un nom, et place au combat !  \r\n";
        echo "\r\n";
        echo "Prêt à combattre ? \r\n";
        echo "\033[1m_______________________________________________\r\n";
    }

    public static function initPlayers(): array {
        $playersName = [];
        for ($i=1; $i <= Configuration::NB_PLAYERS; $i++) {
            echo "\033[1m\033[33mJoueur {$i}, écris le nom de ton combattant : \033[0m\r\n";
            fscanf(STDIN, "%s", $playerName);
            $playersName[] = empty($playerName) ? "Joueur {$i}" : $playerName;
        }
        return $playersName;
    }

}