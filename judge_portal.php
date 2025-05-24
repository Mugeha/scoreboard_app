<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
$conn = new mysqli("localhost", "appuser", "jackie1428", "scoreboard_app");
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

// Handle form submit
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $judge_id = trim($_POST['judge_id']);
    $participant_id = trim($_POST['participant_id']);
    $points = trim($_POST['points']);

    if ($judge_id == "" || $participant_id == "" || $points == "") {
        $message = "Please fill in all fields.";
    } elseif (!is_numeric($points) || $points < 1 || $points > 100) {
        $message = "Score must be between 1 and 100.";
    } else {
        // Prevent duplicate judge-participant scoring
        $check = $conn->prepare("SELECT id FROM scores WHERE judge_id = ? AND participant_id = ?");
        $check->bind_param("ii", $judge_id, $participant_id);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "This judge has already scored this participant.";
        } else {
            $stmt = $conn->prepare("INSERT INTO scores (judge_id, participant_id, points) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $judge_id, $participant_id, $points);
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
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Judge Portal – Submit Score</h2>

            <?php if ($message != ""): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Judge ID</label>
                    <input type="number" name="judge_id" class="form-control" required>
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
                    <label class="form-label">Score (1-100)</label>
                    <input type="number" name="points" class="form-control" min="1" max="100" required>
                </div>

                <button type="submit" class="btn btn-success">Submit Score</button>
            </form>
        </div>
    </div>
</body>
</html>
