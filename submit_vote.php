<?php include 'db.php'; session_start();

if (!isset($_SESSION['voter_id']) || !isset($_POST['candidate_id'])) {
  header("Location: login.php");
  exit();
}

$voter_id = $_SESSION['voter_id'];
$candidate_id = $_POST['candidate_id'];

// Check if already voted
$check = $conn->query("SELECT has_voted FROM voters WHERE id = $voter_id");
if ($check->fetch_assoc()['has_voted']) {
  echo "You have already voted.";
  exit();
}

// Increment vote
$conn->query("UPDATE candidates SET vote_count = vote_count + 1 WHERE id = $candidate_id");

// Mark voter as voted
$conn->query("UPDATE voters SET has_voted = 1 WHERE id = $voter_id");

session_destroy();
echo "<h2>Thank you for voting!</h2>";
?>
