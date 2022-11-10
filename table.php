<?php

/*
 * todo 1 :
 * - Initialiser la session
 * - Créer la variable de session 'players' qui est un tableau
 *   - Dans le tableau de session 'players', créer deux joueurs :
 *     - Joueur Farid, Id 0
 *     - Joueur Martin, Id 1
 * - Créer la variable de session 'round' qui est un tableau
 * - Créer la variable de session 'next_player_id' qui a comme valeur l'id du premier joueur
 * 
 * Aide : https://www.php.net/manual/en/session.idpassing.php#example-4790
 */

session_start();
if (!array_key_exists('players', $_SESSION)) {
    $_SESSION['players'] = [];
}
//ici les numbres est le 'key' et les prenoms est la valeur
// 0 => 'farid',
// 1 => 'martin',


/*
todo 4:
- Avant de définir la variable de sessions 'round', ajouter une condition comme pour 'players'
*/
if (!array_key_exists('round', $_SESSION)) {
    $_SESSION['round'] = [];
}


/*
todo 4:
- Déplacer le reset de la variable de session 'next_player_id' à l'endroit où la variable de session 'players' est reset
*/
// $_SESSION['next_player_id'] = 0;

/*
todo 3 :
- Ajouter une condition pour vérifier si des données sont envoyées en POST
- Si oui :
  - Afficher la variable POST dans un 'var_dump'
  - Ajouter une condition pour vérifier si la variable POST avec le nom 
'formtype' est définie, et sa valeur est 'users'
    - Si oui :
      - Traiter les données du formulaire afin d'ajouter les joueurs dans 
la variable de session 'players'
 */

if (!empty($_POST)) {
    // var_dump($_POST);
    if (isset($_POST['formtype']) && $_POST['formtype'] == 'users') {
        //vider la list des jouers existents
        $_SESSION['players'] = [];
        $_SESSION['next_player_id'] = 0;
        $_SESSION['round'] = [];
        $_SESSION['winner'] = null;

        //pour chaque user envoiyer en post on fait une boucle
        foreach ($_POST['players'] as $player) {
            // dans la boucle on ajoute le player dans la session players 
            // array_push($_SESSION['players'], $player);
            $_SESSION['players'][] = [
                'name' => $player,
                'score' => 301,
            ];
        }
    }

    /*
todo 4:
- Ajouter une condition pour vérifier si la variable POST avec le nom 'formtype' est définie, et sa valeur est 'game'
  - Si oui, traiter les données du formulaire :
    - Récupérer le nouveau score dans une variable 'newScore'
    - En utilisant la variable de session 'next_player_id', ajouter le nouveau score dans la variable de session 'round'

La variable de session 'round' est un tableau qui contient un tableau pour chaque tour de jeu. Elle va ressembler à ça :
[
  [               // Début du tour 1
    0 => 256,     // Score du joueur 0 (key = playerId = 0, value = 256)
    1 => 280,     // Score du joueur 1
  ],              // Fin du tour 1
  [               // Début du tour 2
    0 => 212,     // Score du joueur 0
    1 => 246,     // Score du joueur 1
  ],              // Fin du tour 2
  ...
];
*/
    if (isset($_POST['formtype']) && $_POST['formtype'] == 'game') {
        //ici on recopere le score
        $score = intval($_POST['score']);
        $currentPlayerId = $_SESSION['next_player_id'];

        if ($currentPlayerId == 0) {

            //on ajoute une nouvelle line dans le tableau round
            // $_SESSION['round'][] = []
            array_unshift($_SESSION['round'], []);
        }


        //metre a jour le score de joueur
        $newScore = $_SESSION['players'][$currentPlayerId]['score'] - $score;
        if ($newScore >= 0) {
            $_SESSION['players'][$currentPlayerId]['score'] = $newScore;
        }
        //ici on a met une condation pour enregistre l'id de gagnant
        if ($_SESSION['players'][$currentPlayerId]['score'] == 0) {
            $_SESSION['winner'] = $currentPlayerId;
        }

        $_SESSION['round'][0][$currentPlayerId] = $_SESSION['players'][$currentPlayerId]['score'];

        $_SESSION['next_player_id']++;

        if ($_SESSION['next_player_id'] == count($_SESSION['players'])) {
            $_SESSION['next_player_id'] = 0;
        }

        // var_dump($_SESSION);
    }
    header('Location: table.php');
}




?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>DARTS</title>
</head>

<body>
    <header>
        <div class="header">
            <img class="logo" src="logos/darts.png">
            <h1>DARTS</h1>
        </div>
    </header>

    <section class="table">
        <table style="width: 100%;">
            <thead>
                <tr>
                    <?php
                    /*
                 * todo 2
                 * - Faire une boucle sur la variable de session des joueurs
                 * - Pour chaque joueur, afficher son nom dans un <th>
                 */
                    //on a ajouter une condation pour metre une class css sur le jouer quidois jouer
                    foreach ($_SESSION['players'] as $player_id => $player) {
                        if ($player_id == $_SESSION['next_player_id']) {
                            echo ('<th class="name">' . $player['name'] . '</th>');
                        } else {
                            echo ('<th>' . $player['name'] . '</th>');
                        }
                    }
                    ?>
                </tr>
            </thead>
            <tbody>

                <?php

                //ici on fait une boucle pour afficher le score round par round.
                foreach (array_reverse($_SESSION['round']) as $round) {
                    echo ('<tr>');

                    foreach ($round as $score) {
                        echo ('<td>' . $score . '</td>');
                    }

                    echo ('</tr>');
                }



                ?>
                <!--
                  <tr>
                    <td>280</td>
                    <td>275</td>
                  </tr>
                -->
            </tbody>
        </table>
    </section>
    <section class="flex1">
        <?php
        /*
         * todo 4
         * - Remplacer la 'div' en dessous par un 'form' en méthode 'post'
         - Ajouter un input de type hidden avec le nom 'formtype' et la  
     */

        //on ajouter une condation pour afficher le formolaier seulement si il n'y a pas de gagnant.
        if (is_null($_SESSION["winner"])) {
        ?>
        <form class="flex" action="" method="post">

            <input type="hidden" name="formtype" value="game">

            <input type="number" name="score" id="player-score" placeholder="score">
            <button class="btn" id="add-score">
                <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10
              3.125C6.20304 3.125 3.125 6.20304 3.125 10C3.125
              13.797 6.20304 16.875 10 16.875C13.797 16.875 16.875
              13.797 16.875 10C16.875 6.20304 13.797 3.125 10
              3.125ZM1.875 10C1.875 5.51269 5.51269 1.875 10
              1.875C14.4873 1.875 18.125 5.51269 18.125 10C18.125
              14.4873 14.4873 18.125 10 18.125C5.51269 18.125
              1.875 14.4873 1.875 10Z" fill="white" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.0346 6.90962C10.2787 6.66554 10.6744
                6.66554 10.9185 6.90962L13.5669 9.55806C13.811
                9.80214 13.811 10.1979 13.5669 10.4419L10.9185
                13.0904C10.6744 13.3345 10.2787 13.3345 10.0346
                13.0904C9.79054 12.8463 9.79054 12.4506 10.0346
                12.2065L12.2411 10L10.0346 7.7935C9.79054
                7.54943 9.79054 7.1537 10.0346 6.90962Z" fill="white" />
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M6.25 10C6.25 9.65482 6.52982 9.375 6.875
                  9.375H13.125C13.4702 9.375 13.75 9.65482
                  13.75 10C13.75 10.3452 13.4702 10.625 13.125
                  10.625H6.875C6.52982 10.625 6.25 10.3452
                  6.25 10Z" fill="white" />
                </svg>

            </button>
        </form>
        <?php
        }
        ?>
    </section>

    <div id="player-win">
        <?php
        //ici on ajouter une condation pour afficher le gagnant
        if (!is_null($_SESSION["winner"])) {
            echo ('<p>' . $_SESSION['players'][$_SESSION["winner"]]['name'] . ' A gagné </p> <a class="restart" href="index.html">Redémarrer</a>');
        }
        ?>

    </div>


    <!-- <a href="index.html">Restart</a> -->
    <!-- <script src="game.js"></script> -->



    <footer class="container_footer">
        <div class="footer">
            <h4> <a href="contact.html">Contactez Nous</a></h4>
            <p class="">Tous droits réservés &copy; - 2022</p>

        </div>

    </footer>
</body>

</html>