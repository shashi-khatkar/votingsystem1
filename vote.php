<?php include 'db.php'; session_start();

if (!isset($_SESSION['voter_id'])) {
  header("Location: login.php");
  exit();
}

$result = $conn->query("SELECT * FROM candidates");
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Vote Now</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Select Your Candidate</h2>

    <form action="submit_vote.php" method="post">
      <?php while ($row = $result->fetch_assoc()): ?>
        <label style="display: block; margin-bottom: 10px; text-align: left;">
          <input type="radio" name="candidate_id" value="<?= $row['id'] ?>" required>
          <strong><?= htmlspecialchars($row['name']) ?></strong> (<?= htmlspecialchars($row['party']) ?>)
        </label>
      <?php endwhile; ?>

      <button type="submit">Submit Vote</button>
    </form>
  </div>
</body>
</html>
