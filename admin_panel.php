<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Database connection
$conn = new mysqli("localhost", "appuser", "jackie1428", "scoreboard_app");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle form submission
$message = "";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $display_name = trim($_POST['display_name']);

    if ($username == "" || $display_name == "") {
        $message = "Please fill in both fields.";
    } else {
        // Prepare and bind to prevent SQL injection
        $stmt = $conn->prepare("INSERT INTO judges (username, display_name) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $display_name);

        if ($stmt->execute()) {
            $message = "Judge added successfully!";
        } else {
            if ($conn->errno === 1062) {
                $message = "Error: Username already exists.";
            } else {
                $message = "Error: " . $conn->error;
            }
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Add Judges</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <h2>Add a Judge</h2>
    <?php if ($message != "") echo "<p>$message</p>"; ?><body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Admin Panel – Add Judge</h2>

            <?php if ($message != ""): ?>
                <div class="alert alert-info"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" action="">
                <div class="mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Display Name</label>
                    <input type="text" name="display_name" class="form-control" required>
                </div>

                <button type="submit" class="btn btn-primary">Add Judge</button>
            </form>
        </div>
    </div>
</body>

    <form method="post" action="">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>

        <label>Display Name:</label><br>
        <input type="text" name="display_name" required><br><br>

        <input type="submit" value="Add Judge">
    </form>
</body>
</html>
