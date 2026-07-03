<?php
session_start();

include("../config.php");
include("../lang.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email            = mysqli_real_escape_string($conn, $_POST['email'] ?? "");
    $new_password     = mysqli_real_escape_string($conn, $_POST['new_password'] ?? "");
    $confirm_password = mysqli_real_escape_string($conn, $_POST['confirm_password'] ?? "");

    if ($new_password != $confirm_password) {

        $error = $langcod == 'ar'
            ? "كلمتا المرور غير متطابقتين ❌"
            : "Passwords do not match ❌";

    } else {

        $sql = "
        UPDATE users
        SET password='$new_password'
        WHERE email='$email'
        ";

        if (mysqli_query($conn, $sql)) {

            $success = $langcod == 'ar'
                ? "تم تحديث كلمة المرور بنجاح ✅"
                : "Password updated successfully ✅";

            unset($_SESSION['reset_email']);

        } else {

            $error = $langcod == 'ar'
                ? "حدث خطأ غير متوقع ❌"
                : "Something went wrong ❌";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'كلمة مرور جديدة' : 'New Password' ?></title>
    <link rel="stylesheet" href="../assets/css/reset_password.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body>

<div class="box animated-fadeIn">

    <div class="lock-icon-badge">🔒</div>

    <h2><?= $langcod == 'ar' ? 'كلمة مرور جديدة' : 'New Password' ?></h2>
    <p class="subtitle"><?= $langcod == 'ar' ? 'قم بكتابة وتأكيد كلمة المرور الجديدة الخاصة بحسابك' : 'Enter and confirm your new account password' ?></p>

    <?php if($error): ?>
        <div class="message error-msg"><?= $error ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="message success-msg"><?= $success ?></div>
    <?php endif; ?>

    <form method="POST">

        <input type="hidden" name="email" value="<?= $_SESSION['reset_email'] ?? '' ?>">

        <div class="input-field-group">
            <input type="password" name="new_password" placeholder="<?= $langcod == 'ar' ? 'كلمة المرور الجديدة' : 'New Password' ?>" required>
        </div>

        <div class="input-field-group">
            <input type="password" name="confirm_password" placeholder="<?= $langcod == 'ar' ? 'تأكيد كلمة المرور الجديدة' : 'Confirm Password' ?>" required>
        </div>

        <button type="submit" class="btn-reset-action">
            <?= $langcod == 'ar' ? 'تحديث كلمة المرور' : 'Update Password' ?>
        </button>

    </form>

    <div class="reset-back-nav">
        <a href="../index.php?lang=<?= $langcod ?>" class="nav-pill-btn home-pill">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>
    </div>

</div>

</body>
</html>
