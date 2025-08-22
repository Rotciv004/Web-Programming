<?php
require_once 'functions.php';
require_login();
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <title>Colecție Linkuri</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <h1>My Links</h1>
  <a href="logout.php">Logout</a>
  
  <h2>Adaugă un link nou</h2>
  <form id="formAdd" action="add_link.php" method="post">
    URL: <input type="url" name="url" required>
    Descriere: <input type="text" name="description" required>
    Categorie: <input type="text" name="category" required>
    <button type="submit">Adaugă</button>
  </form>
  
  <h2>Filtrează după categorie</h2>
  <select id="selectCategory" onchange="loadLinks(1)">
    <option value="">Toate</option>
    <option>Work</option>
    <option>Personal</option>
    <option>Study</option>
    <!-- Poţi popula şi dinamic -->
  </select>
  
  <div id="linksContainer"></div>
  
  <button id="prevBtn" onclick="prevPage()">Prev</button>
  <span id="pageInfo"></span>
  <button id="nextBtn" onclick="nextPage()">Next</button>
  
  <script src="script.js"></script>
</body>
</html>
