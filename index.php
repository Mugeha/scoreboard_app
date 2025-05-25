<!DOCTYPE html>
<html>
<head>
    <title>Welcome to the Scoreboard App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="card p-4 shadow-sm">
            <h1 class="mb-4">Welcome to the Scoreboard App</h1>
            <p class="lead">Choose an action below:</p>

            <div class="list-group">
                <a href="add_participant.php" class="list-group-item list-group-item-action">➕ Add Participant</a>
                <a href="admin_panel.php" class="list-group-item list-group-item-action">👨‍⚖️ Add Judge (Admin Panel)</a>
                <a href="judge_portal.php" class="list-group-item list-group-item-action">📝 Submit Score (Judge Portal)</a>
                <a href="scoreboard.php" class="list-group-item list-group-item-action">📊 View Public Scoreboard</a>
            </div>
        </div>
    </div>
</body>
</html>
