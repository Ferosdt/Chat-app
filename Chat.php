<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

include 'config.php';
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_POST['message'])) {
    $message = $_POST['message'];
    $sql = "INSERT INTO messages (user_id, message) VALUES ('$user_id', '$message')";
    $conn->query($sql);
}

$messages = $conn->query("SELECT users.username, messages.message, messages.timestamp FROM messages JOIN users ON messages.user_id = users.id ORDER BY messages.timestamp DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Chat Room</h1>
        <form method="POST" action="">
            <input type="text" name="message" placeholder="Type your message" required><br>
            <button type="submit">Send</button>
        </form>
        <div class="messages">
            <?php while ($row = $messages->fetch_assoc()) { ?>
                <p><strong><?php echo $row['username']; ?>:</strong> <?php echo $row['message']; ?> <em><?php echo $row['timestamp']; ?></em></p>
            <?php } ?>
        </div>
    </div>
</body>
</html>
