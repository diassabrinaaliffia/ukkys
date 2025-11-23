<?php
// login.php
session_start();
require_once 'koneksi.php';
require_once 'helpers.php';

if (is_logged_in()) {
    header('Location: index.php');
    exit;
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $mysqli->prepare("SELECT id, password, fullname FROM users WHERE username = ?");
    $stmt->bind_param('s', $username);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['fullname'] ?? $username;
            header('Location: index.php');
            exit;
        }
    }
    $error = "Username atau password salah.";
}
?>
<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Login - Inventaris</title>
    <style>
        /* Reset dasar */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #0d1b2a, #1b263b);
            color: #fff;
        }

        .container {
            background-color: #1b263b;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            width: 350px;
            text-align: center;
        }

        h2 {
            margin-bottom: 30px;
            color: #e0e0e0;
            font-size: 28px;
            letter-spacing: 1px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: 500;
            color: #c0c0c0;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            background-color: #0d1b2a;
            color: #fff;
            font-size: 16px;
            transition: 0.3s;
        }

        input[type="text"]:focus,
        input[type="password"]:focus {
            outline: none;
            box-shadow: 0 0 10px #415a77;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 10px;
            background: linear-gradient(45deg, #1e3c72, #2a5298);
            color: #fff;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        button:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            background: linear-gradient(45deg, #2a5298, #1e3c72);
        }

        button:active {
            transform: translateY(0);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .error {
            background-color: #ff4d4f;
            padding: 10px;
            border-radius: 8px;
            margin-bottom: 20px;
            color: #fff;
            font-weight: 500;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h2>Login</h2>
        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="post">
            <label>Username</label>
            <input type="text" name="username" required>

            <label>Password</label>
            <input type="password" name="password" required>

            <button type="submit">Login</button>
        </form>
    </div>
</body>

</html>
