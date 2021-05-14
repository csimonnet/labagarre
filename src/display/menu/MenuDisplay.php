<?php


namespace labagarre\src\display\menu;

use labagarre\src\Configuration;

class MenuDisplay
{

    public static function display() {
        echo "Bienvenue dans LA BAGARRE. \r\n";
        echo "La Bagarre est une version simplifiée de la bataille. Choisis juste un nom, et joins-toi au combat ! \r\n";
        echo "Prêt à combattre ? \r\n";
    }

    public static function initPlayers(): array {
        $playersName = [];
        for ($i=1; $i <= Configuration::NB_PLAYERS; $i++) {
            echo "Joueur {$i} : écris le nom de ton combattant : \r\n";
            fscanf(STDIN, "%s", $playerName);
            $playersName[] = empty($playerName) ? "Joueur {$i}" : $playerName;
        }
        return $playersName;
    }

}