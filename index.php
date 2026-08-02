<?php
// index.php - Main webpage with form and table
require_once 'db.php';

// Fetch existing people
try {
    $stmt = $pdo->query('SELECT id, name, age, status, created_at FROM people ORDER BY id DESC');
    $people = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $people = [];
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>People Manager</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <main class="container">
    <h1>People Manager</h1>

    <section class="card form-card">
      <form id="personForm">
        <div class="field">
          <label for="name">Name</label>
          <input type="text" id="name" name="name" placeholder="Full name" required>
        </div>
        <div class="field">
          <label for="age">Age</label>
          <input type="number" id="age" name="age" placeholder="Age" min="0" required>
        </div>
        <div class="actions">
          <button type="submit" id="submitBtn">Add Person</button>
          <button type="button" id="viewDbBtn" onclick="location.href='index.php'">View Database</button>
        </div>
        <div id="formMessage" class="message"></div>
      </form>
    </section>

    <section class="card table-card">
      <h2>People</h2>
      <div class="table-wrap">
        <table id="peopleTable">
          <thead>
            <tr>
              <th>ID</th>
              <th>Name</th>
              <th>Age</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($people as $p): ?>
            <tr data-id="<?=htmlspecialchars($p['id'])?>">
              <td class="col-id"><?=htmlspecialchars($p['id'])?></td>
              <td class="col-name"><?=htmlspecialchars($p['name'])?></td>
              <td class="col-age"><?=htmlspecialchars($p['age'])?></td>
              <td class="col-status"><?=($p['status'] ? 'Active' : 'Inactive')?></td>
              <td>
                <button class="toggleBtn" data-id="<?=htmlspecialchars($p['id'])?>">Toggle</button>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </section>

  </main>
  <script src="script.js"></script>
</body>
</html>
