<?php
include "../lang.php";
include "../config.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");

    if(mysqli_num_rows($check) > 0){

        $message = $langcod == 'ar'
            ? "❌ الايميل مستخدم بالفعل"
            : "❌ Email already exists";

    } else {

        $sql = "INSERT INTO users(name,email,password,role,phone)
                VALUES('$name','$email','$password','user','$phone')";

        if(mysqli_query($conn,$sql)){

            $message = $langcod == 'ar'
                ? "✅ تم إنشاء الحساب بنجاح"
                : "✅ Account created successfully";

        } else {

            $message = $langcod == 'ar'
                ? "❌ صار خطأ"
                : "❌ Something went wrong";
        }
    }
}
?>

<!DOCTYPE html>

<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">

<head>

<meta charset="UTF-8">

<title>
<?= $langcod == 'ar' ? 'إنشاء حساب' : 'Register' ?>
</title>

<link rel="stylesheet" href="../assets/css/style.css">

</head>

<body>

<div class="register-box">

<h2>
✈️ <?= $langcod == 'ar' ? 'إنشاء حساب' : 'Create Account' ?>
</h2>

<?php if($message != ""): ?>

<div class="message">
    <?= $message ?>
</div>

<?php endif; ?>

<form method="POST">

<input type="text" name="name"
placeholder="<?= $langcod == 'ar' ? 'الاسم' : 'Name' ?>" required>

<input type="text" name="phone"
placeholder="<?= $langcod == 'ar' ? 'الهاتف' : 'Phone' ?>" required>

<input type="email" name="email"
placeholder="<?= $langcod == 'ar' ? 'البريد الإلكتروني' : 'Email' ?>" required>

<input type="password" name="password"
placeholder="<?= $langcod == 'ar' ? 'كلمة المرور' : 'Password' ?>" required>

<button type="submit">
<?= $langcod == 'ar' ? 'إنشاء الحساب' : 'Sign Up' ?>
</button>

</form>

</div>

</body>

</html>