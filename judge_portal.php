<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
require_once "db.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Fetch participants for dropdown
$participants = [];
$result = $conn->query("SELECT id, name FROM participants");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}

// Fetch judges for dropdown
$judges = [];
$result = $conn->query("SELECT id, display_name FROM judges");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $judges[] = $row;
    }
}

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judge_id = trim($_POST['judge_id']);
    $participant_id = trim($_POST['participant_id']);
    $score = trim($_POST['points']);

    if ($judge_id == "" || $participant_id == "" || $score == "") {
        $message = "Please fill in all fields.";
    } elseif (!is_numeric($score) || $score < 1 || $score > 100) {
        $message = "Score must be between 1 and 100.";
    } else {
        $check = $conn->prepare("SELECT id FROM scores WHERE judge_id = ? AND participant_id = ?");
        $check->bind_param("ii", $judge_id, $participant_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "This judge has already scored this participant.";
        } else {
            $stmt = $conn->prepare("INSERT INTO scores (judge_id, participant_id, score) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $judge_id, $participant_id, $score);
            if ($stmt->execute()) {
                $message = "Score submitted successfully!";
            } else {
                $message = "Error submitting score.";
            }
            $stmt->close();
        }

        $check->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Judge Portal - Submit Score</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="index.php">Scoreboard App</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="admin_panel.php">Add Judge</a></li>
                <li class="nav-item"><a class="nav-link" href="add_participant.php">Add Participant</a></li>
                <li class="nav-item"><a class="nav-link" href="judge_portal.php">Submit Score</a></li>
                <li class="nav-item"><a class="nav-link" href="scoreboard.php">View Scoreboard</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <div class="card p-4 shadow-sm">
        <h2 class="mb-4">Judge Portal – Submit Score</h2>

        <?php if ($message != ""): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Judge</label>
                <select name="judge_id" class="form-control" required>
                    <option value="">Select a judge</option>
                    <?php foreach ($judges as $judge): ?>
                        <option value="<?php echo $judge['id']; ?>">
                            <?php echo htmlspecialchars($judge['display_name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Participant</label>
                <select name="participant_id" class="form-control" required>
                    <option value="">Select a participant</option>
                    <?php foreach ($participants as $participant): ?>
                        <option value="<?php echo $participant['id']; ?>">
                            <?php echo htmlspecialchars($participant['name']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Score (1–100)</label>
                <input type="number" name="points" class="form-control" min="1" max="100" required>
            </div>

            <button type="submit" class="btn btn-success">Submit Score</button>
        </form>
    </div>
</div>

</body>
</html>
