<?php include 'db.php'; session_start(); ?>

<!DOCTYPE html>
<html>
<head>
  <title>Voter Registration</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <div class="container">
    <h2>Register to Vote</h2>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
      $voter_name = $_POST['voter_name'] ?? '';
      $voter_id = $_POST['voter_id'] ?? '';

      if ($voter_name && $voter_id) {
        $check = $conn->prepare("SELECT id FROM voters WHERE voter_id = ?");
        if (!$check) {
          echo "<p class='error'>SQL error: " . $conn->error . "</p>";
        } else {
          $check->bind_param("s", $voter_id);
          $check->execute();
          $check->store_result();

          if ($check->num_rows > 0) {
            echo "<p class='error'>🚫 This Voter ID is already registered.</p>";
          } else {
            $insert = $conn->prepare("INSERT INTO voters (voter_name, voter_id) VALUES (?, ?)");
            if (!$insert) {
              echo "<p class='error'>SQL error: " . $conn->error . "</p>";
            } else {
              $insert->bind_param("ss", $voter_name, $voter_id);
              if ($insert->execute()) {
                echo "<p class='success'>✅ Registered successfully! <a href='login.php'>Login to vote</a></p>";
              } else {
                echo "<p class='error'>Registration failed. Try again.</p>";
              }
            }
          }
        }
      } else {
        echo "<p class='error'>All fields are required.</p>";
      }
    }
    ?>

    <form method="post">
      <input type="text" name="voter_name" placeholder="Your Full Name" required>
      <input type="text" name="voter_id" placeholder="Your Email / Phone / ID" required>
      <button type="submit">Register</button>
    </form>
    <p style="margin-top: 15px;">
      Already registered? <a href="login.php" class="button">Login here</a>
    </p>
  </div>
</body>
</html>
