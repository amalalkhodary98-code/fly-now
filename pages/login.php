<?php
session_start();
include "../lang.php";
include "../config.php";

if (isset($_POST['login'])) {
    $email    = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        if ($row['role'] === 'admin') {
            
            $secret_token = "gaza_safe_gate_2026";
            
            if (!isset($_GET['secret']) || $_GET['secret'] !== $secret_token) {
                $error = $langcod == 'ar' ? "بيانات الدخول خاطئة ❌" : "Invalid login data ❌";
                $active_tab = "login";
                $display_tab = "login";
                goto display_html; 
            }
        }

        $_SESSION['user_id']   = $row['id'];
        $_SESSION['role']      = $row['role'];
        $_SESSION['user_name'] = $row['name'];

        if ($row['role'] === 'admin') {
            header("Location: ../admin/dashboard.php");
        } elseif (isset($_GET['gaza'])) {
            header("Location: gaza_help.php?lang=".$langcod);
        } else {
            header("Location: ../index.php?lang=".$langcod);
        }
        exit();
    } else {
        $error = $langcod == 'ar' ? "بيانات الدخول خاطئة ❌" : "Invalid login data ❌";
        $active_tab = "login";
    }
}

if (isset($_POST['register'])) {
    $name     = mysqli_real_escape_string($conn, $_POST['name']);
    $email    = mysqli_real_escape_string($conn, $_POST['register_email']);
    $password = mysqli_real_escape_string($conn, $_POST['register_password']);

    $check = mysqli_query($conn, "SELECT * FROM users WHERE email='$email'");
    if (mysqli_num_rows($check) > 0) {
        $register_error = $langcod == 'ar' ? "الإيميل مستخدم بالفعل ❌" : "Email already exists ❌";
        $active_tab = "register";
    } else {
        $insert = "INSERT INTO users(name,email,password,role) VALUES('$name','$email','$password','user')";
        if (mysqli_query($conn, $insert)) {
            $success = $langcod == 'ar' ? "تم إنشاء الحساب بنجاح ✅" : "Account created successfully ✅";
            $active_tab = "login";
        } else {
            $register_error = $langcod == 'ar' ? "حدث خطأ غير متوقع ❌" : "Something went wrong ❌";
            $active_tab = "register";
        }
    }
}

display_html:
$display_tab = isset($active_tab) ? $active_tab : (isset($_POST['register']) ? 'register' : 'login');
?>
<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'بوابة الحساب' : 'Authentication Portal' ?></title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link rel="stylesheet" href="https://cloudflare.com">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>
<body>

<div class="auth-portal-container">

    <div class="glass-auth-card animated-fadeIn">
        
        <div class="auth-tabs">
            <button class="tab-btn <?= $display_tab == 'login' ? 'active' : '' ?>" onclick="switchAuthTab('login')">
                <?= $langcod == 'ar' ? 'تسجيل الدخول' : 'Login' ?>
            </button>
            <button class="tab-btn <?= $display_tab == 'register' ? 'active' : '' ?>" onclick="switchAuthTab('register')">
                <?= $langcod == 'ar' ? 'إنشاء حساب' : 'Sign Up' ?>
            </button>
        </div>

        <div id="login-form-panel" class="auth-panel <?= $display_tab == 'login' ? 'active' : '' ?>">
            <p class="panel-subtitle"><?= $langcod == 'ar' ? 'مرحباً بعودتك! سجل دخولك لمتابعة رحلاتك' : 'Welcome back! Login to manage your trips' ?></p>
            
            <?php if(isset($error)): ?>
                <div class="auth-message error-msg"><?= $error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'البريد الإلكتروني' : 'Username' ?></label>
                    <input type="email" name="email" placeholder="<?= $langcod == 'ar' ? 'أدخل البريد الإلكتروني' : 'Enter Username' ?>" required>
                    <i class="fa-regular fa-user"></i>
                </div>
                
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'كلمة المرور' : 'Password' ?></label>
                    <input type="password" name="password" placeholder="<?= $langcod == 'ar' ? 'أدخل كلمة المرور' : 'Enter Password' ?>" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <div class="forgot-pass-link">
                    <a href="forgot_password.php?lang=<?= $langcod ?>">
                        <?= $langcod == 'ar' ? 'هل نسيت كلمة المرور؟' : 'Forgot Password?' ?>
                    </a>
                </div>
                
                <button type="submit" name="login" class="btn-auth-action">
                    <?= $langcod == 'ar' ? 'تسجيل الدخول' : 'Login' ?>
                </button>
            </form>
        </div>

        <div id="register-form-panel" class="auth-panel <?= $display_tab == 'register' ? 'active' : '' ?>">
            <p class="panel-subtitle"><?= $langcod == 'ar' ? 'انضم إلينا اليوم واستمتع بأفضل العروض' : 'Join us today and explore premium travel deals' ?></p>

            <?php if(isset($success)): ?>
                <div class="auth-message success-msg"><?= $success; ?></div>
            <?php endif; ?>

            <?php if(isset($register_error)): ?>
                <div class="auth-message error-msg"><?= $register_error; ?></div>
            <?php endif; ?>

            <form method="POST">
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'الاسم الكامل' : 'Full Name' ?></label>
                    <input type="text" name="name" placeholder="<?= $langcod == 'ar' ? 'أدخل اسمك الكامل' : 'Enter Your Full Name' ?>" required>
                    <i class="fa-regular fa-id-card"></i>
                </div>
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'البريد الإلكتروني' : 'Email Address' ?></label>
                    <input type="email" name="register_email" placeholder="<?= $langcod == 'ar' ? 'أدخل بريدك الإلكتروني' : 'Enter Email Address' ?>" required>
                    <i class="fa-regular fa-envelope"></i>
                </div>
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'رقم الهاتف' : 'Phone Number' ?></label>
                    <input type="tel" name="register_phone" placeholder="<?= $langcod == 'ar' ? 'أدخل رقم الهاتف' : 'Enter Phone Number' ?>" required>
                    <i class="fa-solid fa-phone"></i>
                </div>
                <div class="input-field-group">
                    <label><?= $langcod == 'ar' ? 'كلمة المرور' : 'Password' ?></label>
                    <input type="password" name="register_password" placeholder="<?= $langcod == 'ar' ? 'اختر كلمة مرور قوية' : 'Enter Strong Password' ?>" required>
                    <i class="fa-solid fa-lock"></i>
                </div>
                
                <button type="submit" name="register" class="btn-auth-action register-accent-btn">
                    <?= $langcod == 'ar' ? 'إنشاء حساب جديد' : 'Sign Up' ?>
                </button>
            </form>
        </div>

    </div>

    <div class="auth-back-nav">
        <a href="../index.php?lang=<?= $langcod ?>" class="nav-pill-btn home-pill">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>

        <a href="javascript:history.back()" class="nav-pill-btn back-pill">
            ⬅ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

<script>
function switchAuthTab(tabName) {
    document.querySelectorAll('.tab-btn').forEach(btn => btn.classList.remove('active'));
    document.querySelectorAll('.auth-panel').forEach(panel => panel.classList.remove('active'));
    
    if (tabName === 'login') {
        event.currentTarget.classList.add('active');
        document.getElementById('login-form-panel').classList.add('active');
    } else {
        event.currentTarget.classList.add('active');
        document.getElementById('register-form-panel').classList.add('active');
    }
}
</script>
</body>
</html>
