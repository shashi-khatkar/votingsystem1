<?php include 'db.php'; session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Login to Vote</title>
  <link rel="stylesheet" href="style.css" />
</head>
<body>
  <div class="container">
    <h2>User Login</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      $voter_id = $_POST['voter_id'] ?? '';

      if ($voter_id) {
        $stmt = $conn->prepare("SELECT * FROM voters WHERE voter_id = ?");
        if (!$stmt) {
          echo "<p class='error'>SQL Error: " . $conn->error . "</p>";
        } else {
          $stmt->bind_param("s", $voter_id);
          $stmt->execute();
          $result = $stmt->get_result();

          if ($result->num_rows === 1) {
            $voter = $result->fetch_assoc();
            if ($voter['has_voted']) {
              echo "<p class='error'>❌ You have already voted.</p>";
            } else {
              $_SESSION['voter_id'] = $voter['id'];
              header("Location: vote.php");
              exit();
            }
          } else {
            echo "<p class='error'>Voter ID not found. <a href='register.php'>Register here</a></p>";
          }
        }
      } else {
        echo "<p class='error'>Voter ID is required.</p>";
      }
    }
    ?>

    <!-- Login Form -->
    <form method="post">
      <input type="text" name="voter_id" placeholder="Enter Your Voter ID" required><br>
      <button type="submit">Login</button>
    </form>

    <!-- Register Link -->
    <p style="margin-top: 15px;">
      New user? <a href="register.php" class="button" style="text-decoration:none;">Register here</a>
    </p>
  </div>
</body>
</html>
