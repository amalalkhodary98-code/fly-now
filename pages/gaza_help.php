<?php
session_start();
include "../lang.php";

$conn = mysqli_connect("localhost", "root", "", "travel-db");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if(!isset($_SESSION['user_id'])){
    header("Location: login.php?lang=".$langcod);
    exit();
}

if (!file_exists("../uploads")) {
    mkdir("../uploads", 0777, true);
}

if(isset($_POST['add'])){

    $id_file       = mysqli_real_escape_string($conn, $_FILES['id_file']['name']);
    $passport_file = mysqli_real_escape_string($conn, $_FILES['passport_file']['name']);
    $report_file   = mysqli_real_escape_string($conn, $_FILES['report_file']['name']);

    move_uploaded_file($_FILES['id_file']['tmp_name'], "../uploads/".$id_file);
    move_uploaded_file($_FILES['passport_file']['tmp_name'], "../uploads/".$passport_file);
    move_uploaded_file($_FILES['report_file']['tmp_name'], "../uploads/".$report_file);

    $name            = mysqli_real_escape_string($conn, $_POST['name']);
    $national_id     = mysqli_real_escape_string($conn, $_POST['national_id']);
    $passport        = mysqli_real_escape_string($conn, $_POST['passport']);
    $phone           = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender          = mysqli_real_escape_string($conn, $_POST['gender']);
    $birth_date      = mysqli_real_escape_string($conn, $_POST['birth_date']);
    $travel_reason   = mysqli_real_escape_string($conn, $_POST['travel_reason']);
    $destination     = mysqli_real_escape_string($conn, $_POST['destination']);
    $city            = mysqli_real_escape_string($conn, $_POST['city']);
    $companions      = mysqli_real_escape_string($conn, $_POST['companions']);
    $border_crossing = mysqli_real_escape_string($conn, $_POST['border_crossing']);
    $travel_date     = mysqli_real_escape_string($conn, $_POST['travel_date']);
    $travel_time     = mysqli_real_escape_string($conn, $_POST['travel_time']);
    $injured         = mysqli_real_escape_string($conn, $_POST['injured']);
    $notes           = mysqli_real_escape_string($conn, $_POST['notes']);

    $request_status = "قيد المراجعة";

    $sql = "INSERT INTO gaza_requests(
        name, national_id, passport, phone, gender, birth_date,
        travel_reason, destination, city, request_status,
        companions, border_crossing, travel_date, travel_time,
        injured, notes, id_file, passport_file, report_file
    ) VALUES (
        '$name', '$national_id', '$passport', '$phone', '$gender', '$birth_date',
        '$travel_reason', '$destination', '$city', '$request_status',
        '$companions', '$border_crossing', '$travel_date', '$travel_time',
        '$injured', '$notes', '$id_file', '$passport_file', '$report_file'
    )";

    if(mysqli_query($conn, $sql)){
        $alert_txt = ($langcod == 'ar') ? 'تم إرسال طلبك بنجاح للمراجعة' : 'Request submitted successfully';
        echo "<script>alert('$alert_txt');</script>";
    } else {
        echo mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="<?= $langcod == 'ar' ? 'ar' : 'en' ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'طلبات غزة' : 'Gaza Requests' ?></title>
    <link rel="stylesheet" href="../assets/css/gaza_help.css">
    <link rel="stylesheet" href="https://jsdelivr.net">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="booking-page">

<div class="gaza-form-container animated-fadeIn">

    <div class="form-header">
        <div class="flag-badge">🇵🇸</div>
        <h2><?= $langcod == 'ar' ? 'طلب تسجيل خاص بأهل غزة' : 'Special Gaza Travel Request' ?></h2>
        <p class="subtitle"><?= $langcod == 'ar' ? 'يرجى تعبئة كافة الحقول بدقة لضمان سرعة مراجعة وتنسيق الطلب البرمجي.' : 'Please fill all fields accurately for review coordination.' ?></p>
    </div>

    <form method="POST" enctype="multipart/form-data">

        <div class="section-title">
            <span>👤</span> <?= $langcod == 'ar' ? 'المعلومات الشخصية للمواطن' : 'Personal Information' ?>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <input type="text" name="name" placeholder="<?= $langcod == 'ar' ? 'الاسم الكامل رباعي' : 'Full Name' ?>" required>
            </div>

            <div class="form-group">
                <input type="text" name="national_id" placeholder="<?= $langcod == 'ar' ? 'رقم الهوية الوطنية' : 'National ID' ?>" required>
            </div>

            <div class="form-group">
                <input type="text" name="passport" placeholder="<?= $langcod == 'ar' ? 'رقم جواز السفر' : 'Passport Number' ?>" required>
            </div>

            <div class="form-group">
                <input type="text" name="phone" placeholder="<?= $langcod == 'ar' ? 'رقم الهاتف للتواصل' : 'Phone Number' ?>" required>
            </div>

            <div class="form-group">
               <label><?= $langcod == 'ar' ? 'تاريخ الميلاد' : 'Birth Date' ?></label>
               <input type="text" name="birth_date" class="date-picker" placeholder="<?= $langcod == 'ar' ? 'اختر تاريخ الميلاد' : 'Select Birth Date' ?>" required>
            </div>

            <div class="form-group">
                <select name="gender" required>
                    <option value=""><?= $langcod == 'ar' ? 'اختر الجنس' : 'Select Gender' ?></option>
                    <option value="ذكر"><?= $langcod == 'ar' ? 'ذكر' : 'Male' ?></option>
                    <option value="أنثى"><?= $langcod == 'ar' ? 'أنثى' : 'Female' ?></option>
                </select>
            </div>

            <div class="form-group full-width">
                <select name="city" required>
                    <option value=""><?= $langcod == 'ar' ? 'اختر المحافظة أو المدينة التابع لها' : 'Select City' ?></option>
                    <option value="غزة">غزة</option>
                    <option value="خانيونس">خانيونس</option>
                    <option value="رفح">رفح</option>
                    <option value="جباليا">جباليا</option>
                    <option value="دير البلح">دير البلح</option>
                </select>
            </div>
        </div>

        <div class="section-title">
            <span>✈️</span> <?= $langcod == 'ar' ? 'بيانات وتفاصيل السفر' : 'Travel Information' ?>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <select name="travel_reason" required>
                    <option value=""><?= $langcod == 'ar' ? 'سبب السفر الرئيسي' : 'Travel Reason' ?></option>
                    <option value="علاج/إصابة"><?= $langcod == 'ar' ? 'علاج / إصابة' : 'Medical' ?></option>
                    <option value="دراسة"><?= $langcod == 'ar' ? 'دراسة' : 'Study' ?></option>
                    <option value="إقامة"><?= $langcod == 'ar' ? 'إقامة' : 'Residence' ?></option>
                    <option value="زيارة"><?= $langcod == 'ar' ? 'زيارة' : 'Visit' ?></option>
                    <option value="حالة إنسانية"><?= $langcod == 'ar' ? 'حالة إنسانية' : 'Humanitarian' ?></option>
                </select>
            </div>

            <div class="form-group">
                <input type="text" name="destination" placeholder="<?= $langcod == 'ar' ? 'الوجهة النهائية (الدولة المستضيفة)' : 'Destination' ?>" required>
            </div>

            <div class="form-group">
                <input type="number" name="companions" placeholder="<?= $langcod == 'ar' ? 'عدد المرافقين معك' : 'Number of Companions' ?>" min="0" required>
            </div>

            <div class="form-group">
                <select name="border_crossing" required>
                    <option value=""><?= $langcod == 'ar' ? 'اختر المعبر المفترض' : 'Select Crossing' ?></option>
                    <option value="معبر رفح"><?= $langcod == 'ar' ? 'معبر رفح المطور' : 'Rafah Crossing' ?></option>
                    <option value="كرم أبو سالم"><?= $langcod == 'ar' ? 'كرم أبو سالم' : 'Kerem Shalom' ?></option>
                </select>
            </div>

            <div class="form-group">
               <label><?= $langcod == 'ar' ? 'تاريخ السفر المفترض' : 'Travel Date' ?></label>
               <input type="text" name="travel_date" class="date-picker" placeholder="<?= $langcod == 'ar' ? 'اختر تاريخ السفر' : 'Select Travel Date' ?>" required>
            </div>

            <div class="form-group">
                <label><?= $langcod == 'ar' ? 'وقت السفر المتوقع' : 'Travel Time' ?></label>
                <input type="time" name="travel_time" required>
            </div>
        </div>

        <div class="section-title">
            <span>🩺</span> <?= $langcod == 'ar' ? 'تفاصيل الحالة الصحية والإنسانية' : 'Case Details' ?>
        </div>

        <div class="form-grid">
            <div class="form-group full-width">
                <select name="injured" required>
                    <option value=""><?= $langcod == 'ar' ? 'هل يوجد إصابة ناجمة عن الأحداث؟' : 'Is there an injury?' ?></option>
                    <option value="نعم"><?= $langcod == 'ar' ? 'نعم (يوجد إصابة)' : 'Yes' ?></option>
                    <option value="لا"><?= $langcod == 'ar' ? 'لا (لا يوجد إصابة)' : 'No' ?></option>
                </select>
            </div>
        </div>

        <div class="section-title">
            <span>📁</span> <?= $langcod == 'ar' ? 'رفع الوثائق والمستندات الثبوتية' : 'Upload Documents' ?>
        </div>

        <div class="upload-grid">
            <div class="custom-upload-card">
                <label for="id_file" class="upload-area">
                    <div class="upload-icon">🪪</div>
                    <div class="upload-title"><?= $langcod == 'ar' ? 'صورة الهوية الوطنية' : 'Upload ID Card' ?></div>
                    <div class="upload-subtitle" id="id_file_name"><?= $langcod == 'ar' ? 'اضغط هنا لاختيار ملف' : 'Choose File' ?></div>
                </label>
                <input type="file" id="id_file" name="id_file" onchange="showFileName(this,'id_file_name')" required>
            </div>

            <div class="custom-upload-card">
                <label for="passport_file" class="upload-area">
                    <div class="upload-icon">📕</div>
                    <div class="upload-title"><?= $langcod == 'ar' ? 'صورة جواز السفر' : 'Upload Passport' ?></div>
                    <div class="upload-subtitle" id="passport_file_name"><?= $langcod == 'ar' ? 'اضغط هنا لاختيار ملف' : 'Choose File' ?></div>
                </label>
                <input type="file" id="passport_file" name="passport_file" onchange="showFileName(this,'passport_file_name')" required>
            </div>

            <div class="custom-upload-card full-row">
                <label for="report_file" class="upload-area">
                    <div class="upload-icon">📄</div>
                    <div class="upload-title"><?= $langcod == 'ar' ? 'التقارير الطبية أو الوثائق الداعمة' : 'Upload Medical Reports' ?></div>
                    <div class="upload-subtitle" id="report_file_name"><?= $langcod == 'ar' ? 'اضغط هنا لاختيار مستند (PDF/Images)' : 'Choose Document' ?></div>
                </label>
                <input type="file" id="report_file" name="report_file" onchange="showFileName(this,'report_file_name')" required>
            </div>
        </div>

        <div class="form-group full-width-textarea">
            <textarea name="notes" rows="4" placeholder="<?= $langcod == 'ar' ? 'اكتب الملاحظات أو تفاصيل الحالة الإنسانية هنا بالتفصيل...' : 'Write your notes or humanitarian details here...' ?>"></textarea>
        </div>

        <button type="submit" name="add" class="btn-submit-pill">
            🚀 <?= $langcod == 'ar' ? 'إرسال وثبت طلب السفر الآن' : 'Submit Registration' ?>
        </button>

    </form>

    <div class="form-footer-actions">
        <a href="../index.php?lang=<?= $langcod ?>" class="action-btn home-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>

        <a href="check_gaza_request.php?lang=<?= $langcod ?>" class="action-btn check-btn">
            🔍 <?= $langcod == 'ar' ? 'متابعة وتتبع حالة الطلب' : 'Track Request' ?>
        </a>
    </div>

</div>

<script src="https://jsdelivr.net"></script>
<script>
flatpickr(".date-picker", {
    dateFormat: "Y-m-d",
    locale: "<?= $langcod == 'ar' ? 'ar' : 'default' ?>"
});

function showFileName(input, targetId){
    let fileName = input.files[0] ? input.files[0].name : '<?= $langcod == 'ar' ? "لم يتم اختيار ملف" : "No file selected" ?>';
    document.getElementById(targetId).innerText = fileName;
    
    if(input.files[0]) {
        input.parentElement.classList.add("uploaded-success");
    }
}
</script>
</body>
</html>
