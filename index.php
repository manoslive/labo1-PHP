<?php
session_start();
if (!isset($_SESSION["nombreVote"])) {
    $_SESSION["nombreVote"] = 0;
}
if (isset($_COOKIE["theme"])) {
    $theme = $_COOKIE["theme"];
} else {
    $theme = "rouge";
}
// Affectation du cookie contenant le choix du thème de couleur
$demain = time() + (60 * 60 * 24);
setcookie("theme", $theme, $demain);
// Déclaration / initialisation des variables
$nombreparticipant = 0;
$mon_fichier = "";
$data = "";
$fichier = "data.txt";
$animal = "";
$nbrChien = 0;
$nbrChat = 0;
$nbrOiseau = 0;
$nbrSerpent = 0;
$nbrSinge = 0;
$ligne = "";
$MAX_WIDTH = "200";
$mostPopularAnimal = "";

// On ajoute le choix du vote dans le fichier
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST['animal'])) {
    } else {
        $animal = $_POST['animal'];
        file_put_contents($fichier, ';' . $animal, FILE_APPEND | LOCK_EX);
        $_SESSION["nombreVote"] += 1;
    }
}
// On li le contenu du fichier
$mon_fichier = file_get_contents($fichier);

// On fait une liste des votes
$ligne = explode(';', $mon_fichier);

// On compte le nombre de résultat
$nombreparticipant = count($ligne) - 1;

// On compte le nombre le nombre de vote
foreach ($ligne as $valeur) {
    switch ($valeur) {
        case 'chien':
            $nbrChien++;
            break;
        case 'chat':
            $nbrChat++;
            break;
        case 'oiseau':
            $nbrOiseau++;
            break;
        case 'serpent':
            $nbrSerpent++;
            break;
        case 'singe':
            $nbrSinge++;
            break;
    }
}

// Liste des choix possible
$array = [
    "nbrChien" => $nbrChien,
    "nbrChat" => $nbrChat,
    "nbrOiseau" => $nbrOiseau,
    "nbrSerpent" => $nbrSerpent,
    "nbrSinge" => $nbrSinge
];
// On vérifie les catégories qui ont le plus de vote
$biggestValueName = array_keys($array, max($array));

// On obtient la valeur de la / des catégorie(s) qui ont le plus de vote
switch ($biggestValueName[0]) {
    case 'nbrChien':
        $mostPopularAnimal = $nbrChien;
        break;
    case 'nbrChat':
        $mostPopularAnimal = $nbrChat;
        break;
    case 'nbrOiseau':
        $mostPopularAnimal = $nbrOiseau;
        break;
    case 'nbrSerpent':
        $mostPopularAnimal = $nbrSerpent;
        break;
    case 'nbrSinge':
        $mostPopularAnimal = $nbrSinge;
        break;
}
?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="style.css">
    <style>
        td {
            text-align: right;
        }

        table {
            border-spacing: 7px;
        }

        div {
            min-height: 100%;
            height: 100%;
            content: "";
        }

        <?php
        if($nombreparticipant == 0){
            $MAX_WIDTH = 0;
        }
        ?>
    </style>
    <script>
        function ChangerCouleur(laCouleur) {
            var now = new Date();
            var time = now.getTime();
            time += 3600 * 1000;
            now.setTime(time);

            for (var i = 1; i <= 5; i++) {
                document.getElementById(String(i)).className = laCouleur.concat(String(i));
            }
            document.cookie = "theme=" + laCouleur + ";expires=" + now.toUTCString();

        }
        window.onload = function () {
            if (getCookie('theme') === '') {
                ChangerCouleur('rouge');
                document.getElementById('RB_Rouge').checked = true;
            }
            else {
                ChangerCouleur(getCookie('theme'));
            }
        }
        function getCookie(cname) {
            var name = cname + "=";
            var ca = document.cookie.split(';');
            for (var i = 0; i < ca.length; i++) {
                var c = ca[i];
                while (c.charAt(0) == ' ') c = c.substring(1);
                if (c.indexOf(name) == 0) return c.substring(name.length, c.length);
            }
            return "";
        }
    </script>
</head>
<body>
<h2>Votre animal préféré</h2>
<?php
if ($nombreparticipant > 1) {
    echo '<h3>Résultats obtenus pour ' . $nombreparticipant . ' participants :</h3>';
} else {
    echo '<h3>Résultats obtenus pour ' . $nombreparticipant . ' participant :</h3>';
}

?>
<table>
    <!-- Chien -->
    <tr>
        <td style="text-align: left">Chien</td>
        <td><?php echo $nbrChien ?></td>
        <td>
            <?php
            if ($nombreparticipant != 0) {
                echo ceil(($nbrChien / $nombreparticipant) * 100) . ' %';
            } else {
                echo "0 %";
            }
            ?>
        </td>
        <td>
            <div id="1" class="rouge1" style="width:
            <?php
            if (in_array("nbrChien", $biggestValueName)) {
                echo $MAX_WIDTH . "px";
            } else {
                if ($nbrChien != 0) {
                    echo (ceil(($nbrChien / $nombreparticipant) * 100) / ceil(($mostPopularAnimal / $nombreparticipant) * 100)) * $MAX_WIDTH . 'px';
                } else {
                    echo "0px";
                }
            }
            ?>
                "><span
                    style="width: 100%">&nbsp;</span></div>
        </td>
    </tr>

    <!-- Chat -->
    <tr>
        <td style="text-align: left">Chat</td>
        <td><?php echo $nbrChat ?></td>
        <td>
            <?php
            if ($nombreparticipant != 0) {
                echo ceil(($nbrChat / $nombreparticipant) * 100) . ' %';
            } else {
                echo "0 %";
            }
            ?>
        </td>
        <td>
            <div id="2" class="rouge2" style="width:
            <?php
            if (in_array("nbrChat", $biggestValueName)) {
                echo $MAX_WIDTH . "px";
            } else {
                if ($nbrChat) {
                    echo (ceil(($nbrChat / $nombreparticipant) * 100) / ceil(($mostPopularAnimal / $nombreparticipant) * 100)) * $MAX_WIDTH . 'px';
                } else {
                    echo "0px";
                }
            }
            ?>
                "><span style="width: 100%">&nbsp;</span></div>
        </td>
    </tr>

    <!-- Oiseau -->
    <tr>
        <td style="text-align: left">Oiseau</td>
        <td><?php echo $nbrOiseau ?></td>
        <td>
            <?php
            if ($nombreparticipant != 0) {
                echo ceil(($nbrOiseau / $nombreparticipant) * 100) . ' %';
            } else {
                echo "0 %";
            }
            ?>
        </td>
        <td>
            <div id="3" class="rouge3" style="width:
            <?php
            if (in_array("nbrOiseau", $biggestValueName)) {
                echo $MAX_WIDTH . "px";
            } else {
                if ($nbrOiseau != 0) {
                    echo (ceil(($nbrOiseau / $nombreparticipant) * 100) / ceil(($mostPopularAnimal / $nombreparticipant) * 100)) * $MAX_WIDTH . 'px';
                } else {
                    echo "0px";
                }
            }
            ?>
                "><span style="width: 100%">&nbsp;</span></div>
        </td>
    </tr>

    <!-- Serpent -->
    <tr>
        <td style="text-align: left">Serpent</td>
        <td><?php echo $nbrSerpent ?></td>
        <td>
            <?php
            if ($nombreparticipant != 0) {
                echo ceil(($nbrSerpent / $nombreparticipant) * 100) . ' %';
            } else {
                echo "0 %";
            }
            ?>
        </td>
        <td>
            <div id="4" class="rouge4" style="width:
            <?php
            if (in_array("nbrSerpent", $biggestValueName)) {
                echo $MAX_WIDTH . "px";
            } else {
                if ($nbrSerpent != 0) {
                    echo (ceil(($nbrSerpent / $nombreparticipant) * 100) / ceil(($mostPopularAnimal / $nombreparticipant) * 100)) * $MAX_WIDTH . 'px';
                } else {
                    echo "0px";
                }
            }
            ?>
                "><span style="width: 100%">&nbsp;</span></div>
        </td>
    </tr>

    <!-- Singe -->
    <tr>
        <td style="text-align: left">Singe</td>
        <td><?php echo $nbrSinge ?></td>
        <td>
            <?php
            if ($nombreparticipant != 0) {
                echo ceil(($nbrSinge / $nombreparticipant) * 100) . ' %';
            } else {
                echo "0 %";
            }
            ?>
        </td>
        <td>
            <div id="5" class="rouge5" style="width:
            <?php
            if (in_array("nbrSinge", $biggestValueName)) {
                echo $MAX_WIDTH . "px";
            } else {
                if ($nbrSinge != 0) {
                    echo (ceil(($nbrSinge / $nombreparticipant) * 100) / ceil(($mostPopularAnimal / $nombreparticipant) * 100)) * $MAX_WIDTH . 'px';
                } else {
                    echo "0px";
                }
            }
            ?>
                "><span style="width: 100%">&nbsp;</span></div>
        </td>
    </tr>
</table>
<br/>
<a href="voter.php">Voter</a><br/>
<a href="index.php?action=callfunction">Effacer les données</a>

<h3>Choisissez le thème de couleur que vous préférez</h3>
<?php
if (isset($_COOKIE["theme"])) {
    if ($_COOKIE["theme"] == "rouge") {
        echo "<input id=\"RB_Rouge\" type=\"radio\" name=\"theme\" value=\"rouge\" onchange=\"ChangerCouleur('rouge')\" checked=\"checked\"/>Rouge<br/>";
    } else {
        echo "<input id=\"RB_Rouge\"type=\"radio\" name=\"theme\" value=\"rouge\" onchange=\"ChangerCouleur('rouge')\"/>Rouge<br/>";
    }
    if ($_COOKIE["theme"] == "bleu") {
        echo "<input id=\"RB_Bleu\" type=\"radio\" name=\"theme\" value=\"bleu\" onchange=\"ChangerCouleur('bleu')\" checked=\"checked\"/>Bleu<br/>";
    } else {
        echo "<input id=\"RB_Bleu\" type=\"radio\" name=\"theme\" value=\"bleu\" onchange=\"ChangerCouleur('bleu')\"/>Bleu<br/>";
    }
    if ($_COOKIE["theme"] == "vert") {
        echo "<input id=\"RB_Vert\" type=\"radio\" name=\"theme\" value=\"vert\" onchange=\"ChangerCouleur('vert')\" checked=\"checked\"/>Vert<br/>";
    } else {
        echo "<input id=\"RB_Vert\" type=\"radio\" name=\"theme\" value=\"vert\" onchange=\"ChangerCouleur('vert')\"/>Vert<br/>";
    }
} else {
    echo "<input id=\"RB_Rouge\" type=\"radio\" name=\"theme\" value=\"rouge\" onchange=\"ChangerCouleur('rouge')\" checked=\"checked\"/>Rouge<br/>";
    echo "<input id=\"RB_Bleu\" type=\"radio\" name=\"theme\" value=\"bleu\" onchange=\"ChangerCouleur('bleu')\"/>Bleu<br/>";
    echo "<input id=\"RB_Vert\" type=\"radio\" name=\"theme\" value=\"vert\" onchange=\"ChangerCouleur('vert')\"/>Vert<br/>";
}
?>
</form>
</body>
</html>
<?php
if (isset($_GET['action']) && $_GET['action'] == 'callfunction') {
    // On efface le fichier
    file_put_contents($fichier, "");
    // On redirige vers index.php
    header('Location: index.php');
}
?>
