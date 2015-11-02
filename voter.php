<?php
session_start();
?>
<html>
<head>
</head>
<body>
<?php
if ($_SESSION["nombreVote"] >= 3) {
    echo "<h2>Vous avez atteint le nombre maximal de vote par session!</h2>";
    echo "<a href='index.php'>Retour</a>";
} else {
    echo "<h1> Choisissez votre animal préféré</h1><br/>

<form action=\"index.php\" method=\"post\">
    <select name=\"animal\">
        <option value=\"chien\">Chien</option>
        <option value=\"chat\">Chat</option>
        <option value=\"oiseau\">Oiseau</option>
        <option value=\"serpent\">Serpent</option>
        <option value=\"singe\">Singe</option>
    </select>
    <input type=\"submit\" name=\"submit\" value=\"Valider votre choix\"/>
</form>";
}
?>
</body>
</html>