<?php
include("../config.php");
include("../lang.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['reset_email'] = $email;

        header("Location: reset_password.php");
        exit();
    } else {
        $error = $langcod == 'ar'
            ? "الإيميل غير موجود ❌"
            : "Email not found ❌";
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'استرجاع كلمة المرور' : 'Password Recovery' ?></title>
    <link rel="stylesheet" href="../assets/css/forgot_password.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="box animated-fadeIn">

    <div class="lock-icon-badge">🔑</div>

    <h2><?= $langcod == 'ar' ? 'استرجاع كلمة المرور' : 'Password Recovery' ?></h2>
    <p class="subtitle"><?= $langcod == 'ar' ? 'أدخل بريدك الإلكتروني المسجل لإعادة تعيين كلمة السر الخاصة بك' : 'Enter your registered email to reset your password' ?></p>

    <?php if(isset($error)) { ?>
        <div class="error-msg">
            <?= $error ?>
        </div>
    <?php } ?>

    <form method="POST">
        <div class="form-group">
            <input type="email" name="email" placeholder="<?= $langcod == 'ar' ? 'أدخل الإيميل' : 'Enter Your Email' ?>" required>
        </div>

        <button type="submit" class="recover-btn">
            <?= $langcod == 'ar' ? 'استرجاع الحساب' : 'Recover' ?>
        </button>
    </form>

    <div class="navigation-buttons">
        <a href="../index.php" class="nav-btn home-btn">
            🏠 <?= $langcod == 'ar' ? 'الرئيسية' : 'Home' ?>
        </a>

        <button onclick="history.back()" class="nav-btn back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'السابق' : 'Back' ?>
        </button>
    </div>

</div>

</body>
</html>
