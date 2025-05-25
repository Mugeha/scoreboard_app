<?php
require_once 'db.php';

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    if ($name === "") {
        $message = "Please enter a participant name.";
    } else {
        $stmt = $conn->prepare("INSERT INTO participants (name) VALUES (?)");
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            $message = "Participant added successfully!";
        } else {
            $message = "Error: " . $stmt->error;
        }
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Participant</title>
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
        <h2 class="mb-4">Add Participant</h2>
        <?php if ($message): ?>
            <div class="alert alert-info"><?php echo $message; ?></div>
        <?php endif; ?>
        <form method="post" action="">
            <div class="mb-3">
                <label class="form-label">Participant Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Participant</button>
        </form>
    </div>
</div>

</body>
</html>
