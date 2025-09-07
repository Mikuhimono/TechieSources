<?php
session_start();

$password = "akairu"; // password
$lockTime = 60; // seconds (1 minute)

// Track attempts
if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}
if (!isset($_SESSION['last_attempt_time'])) {
    $_SESSION['last_attempt_time'] = 0;
}

// If locked out
if ($_SESSION['attempts'] >= 3 && (time() - $_SESSION['last_attempt_time']) < $lockTime) {
    $remaining = $lockTime - (time() - $_SESSION['last_attempt_time']);
    die("<div style='font-family: Arial; text-align:center; margin-top:50px; color:red;'>
        You attempted to put 3 wrong password.<br>
        Please try again after $remaining seconds.
    </div>");
}

// Handle login
if (!isset($_SESSION['authenticated'])) {
    if (isset($_POST['password'])) {
        if ($_POST['password'] === $password) {
            $_SESSION['authenticated'] = true;
            $_SESSION['attempts'] = 0; // reset attempts
        } else {
            $_SESSION['attempts']++;
            $_SESSION['last_attempt_time'] = time();
            $error = "Wrong password. Please try again.";
        }
    }

    if (!isset($_SESSION['authenticated'])) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <title>PDF Checker Login</title>
            <link rel="icon" type="image/png" href="../images/school.png">
            <style>
                body {
                    font-family: Arial, sans-serif;
                    background: #f5f7fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                }
                .login-box {
                    background: #fff;
                    padding: 30px;
                    border-radius: 12px;
                    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
                    text-align: center;
                    width: 300px;
                }
                h2 {
                    margin-bottom: 20px;
                    color: #333;
                }
                input[type="password"] {
                    width: 100%;
                    padding: 10px;
                    margin-bottom: 15px;
                    border: 1px solid #ccc;
                    border-radius: 6px;
                }
                button {
                    background: #4CAF50;
                    color: white;
                    border: none;
                    padding: 10px 20px;
                    border-radius: 6px;
                    cursor: pointer;
                    width: 100%;
                }
                button:hover {
                    background: #45a049;
                }
                .error {
                    color: red;
                    margin-bottom: 15px;
                }
            </style>
        </head>
        <body>
            <div class="login-box">
                <h2>Admin Login</h2>
                <?php if (isset($error)): ?>
                    <p class="error"><?php echo $error; ?></p>
                <?php endif; ?>
                <form method="post">
                    <input type="password" name="password" placeholder="Enter password" required>
                    <button type="submit">Login</button>
                </form>
            </div>
        </body>
        </html>
        <?php
        exit;
    }
}

// ==========================
// If authenticated, run duplicate check
// ==========================
$uploadDir = __DIR__ . '/../uploads';
$files = scandir($uploadDir);

$pdfs = [];
$duplicates = [];

foreach ($files as $file) {
    if (pathinfo($file, PATHINFO_EXTENSION) === 'pdf') {
        $hash = md5_file($uploadDir . '/' . $file);
        if (isset($pdfs[$hash])) {
            $duplicates[] = $file;
        } else {
            $pdfs[$hash] = $file;
        }
    }
}

file_put_contents(__DIR__ . '/../duplicate.json', json_encode($duplicates, JSON_PRETTY_PRINT));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Duplicate PDF Checker</title>
    <link rel="icon" type="image/png" href="../images/icon.png">
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f5f7fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            background: #fff;
            padding: 20px;
            margin: auto;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .status {
            text-align: center;
            font-size: 18px;
            margin-bottom: 20px;
        }
        .no-duplicates {
            color: green;
        }
        .duplicates {
            color: red;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            background: #ffe6e6;
            padding: 10px;
            margin: 8px 0;
            border-radius: 6px;
            border: 1px solid #ff9999;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 14px;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Duplicate PDF Checker</h1>

        <?php if (count($duplicates) > 0): ?>
            <p class="status duplicates">
                ⚠ Found <?php echo count($duplicates); ?> duplicate(s).
            </p>
            <ul>
                <?php foreach ($duplicates as $dup): ?>
                    <li><?php echo htmlspecialchars($dup); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="status no-duplicates">✅ No duplicates found!</p>
        <?php endif; ?>

        <div class="footer">
            Results saved in <b>duplicate.json</b>
        </div>
    </div>
</body>
</html>