<?php
function searchArt($query) {
    $url = "https://collectionapi.metmuseum.org/public/collection/v1/search?q=" . urlencode($query);
    $response = file_get_contents($url);
    return json_decode($response, true);
}

function fetchArt($objectId) {
    $url = "https://collectionapi.metmuseum.org/public/collection/v1/objects/$objectId";
    $response = file_get_contents($url);
    return json_decode($response, true);
}

if (isset($_GET['query'])) {
    $query = $_GET['query'];
    $searchResults = searchArt($query);
if ($searchResults && $searchResults['total'] > 0) {
        $objectIds = array_slice($searchResults['objectIDs'], 0, 10);

 foreach ($objectIds as $objectId) {
            $art = fetchArt($objectId);
            if ($art && !empty($art['primaryImageSmall'])) {
                echo '<div class="art-card">';
              echo '<img src="' . $art['primaryImageSmall'] . '" alt="' . $art['title'] . '">';
                echo '<h2>' . $art['title'] . '</h2>';
           echo '</div>';
            }   }
    } else {
        echo '<p>Nenhum resultado encontrado para "' . htmlspecialchars($query) . '"</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arte</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h1>Galeria de Arte</h1>
    <form method="GET" action="index.php">
        <input type="text" name="query" placeholder="Pesquisar arte..." required>
        <button type="submit">Buscar</button>
    </form>
    <div id="art-container">
    </div>
</body>
</html>


