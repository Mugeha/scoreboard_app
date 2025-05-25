<?php
require_once 'db.php';

// Fetch participants with total scores
$sql = "
    SELECT p.id, p.name, COALESCE(SUM(s.score), 0) AS total_score
    FROM participants p
    LEFT JOIN scores s ON p.id = s.participant_id
    GROUP BY p.id, p.name
    ORDER BY total_score DESC
";
$result = $conn->query($sql);

$participants = [];
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $participants[] = $row;
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Public Scoreboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .gold { background-color: #ffd700 !important; }    /* Gold */
        .silver { background-color: #c0c0c0 !important; }  /* Silver */
        .bronze { background-color: #cd7f32 !important; }  /* Bronze */
    </style>
    <meta http-equiv="refresh" content="10"> <!-- Auto-refresh every 10 seconds -->
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
        <h2 class="mb-4">Public Scoreboard</h2>
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Participant</th>
                    <th>Total Points</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $rank = 1;
                foreach ($participants as $participant):
                    $class = '';
                    if ($rank === 1) $class = 'gold';
                    elseif ($rank === 2) $class = 'silver';
                    elseif ($rank === 3) $class = 'bronze';
                ?>
                <tr class="<?php echo $class; ?>">
                    <td><?php echo $rank; ?></td>
                    <td><?php echo htmlspecialchars($participant['name']); ?></td>
                    <td><?php echo $participant['total_score']; ?></td>
                </tr>
                <?php
                $rank++;
                endforeach;
                if (empty($participants)) {
                    echo '<tr><td colspan="3" class="text-center">No participants found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
        <small class="text-muted">Page auto-refreshes every 10 seconds.</small>
    </div>
</div>

</body>
</html>
