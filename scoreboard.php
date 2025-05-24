<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// DB connection
require_once "db.php";
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$scores = [];
$sql = "
    SELECT p.name AS participant_name, SUM(s.score) AS total_score
    FROM participants p
    LEFT JOIN scores s ON p.id = s.participant_id
    GROUP BY p.id
    ORDER BY total_score DESC
";
$result = $conn->query($sql);
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $scores[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Public Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h2 class="mb-4">Public Scoreboard</h2>

            <?php if (count($scores) > 0): ?>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Participant</th>
                            <th>Total Score</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($scores as $index => $row): ?>
                            <tr>
                                <td><?php echo $index + 1; ?></td>
                                <td><?php echo htmlspecialchars($row['participant_name']); ?></td>
                                <td><?php echo $row['total_score'] ?? 0; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">No scores have been submitted yet.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
