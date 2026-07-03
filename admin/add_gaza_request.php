<?php
session_start();
include "../config.php";
include "../lang.php";

if (!isset($_SESSION['role'])) {
    die($langcod == 'ar' ? "🚫 يجب تسجيل الدخول" : "🚫 Login required");
}

$query = "SELECT * FROM gaza_requests ORDER BY id DESC";
$result = mysqli_query($conn,$query);
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod == 'ar' ? 'rtl' : 'ltr' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod == 'ar' ? 'طلبات غزة' : 'Gaza Requests' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/add_gaza_request.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="dashboard-container animated-fadeIn">

    <h1>
        🇵🇸 <?= $langcod == 'ar' ? 'طلبات غزة' : 'Gaza Requests' ?>
    </h1>

    <div class="table-responsive-wrapper">
        <table class="gaza-table">
            <thead>
                <tr>
                    <th><?= $langcod == 'ar' ? 'الاسم' : 'Name' ?></th>
                    <th><?= $langcod == 'ar' ? 'الهاتف' : 'Phone' ?></th>
                    <th><?= $langcod == 'ar' ? 'المدينة' : 'City' ?></th>
                    <th><?= $langcod == 'ar' ? 'الوجهة' : 'Destination' ?></th>
                    <th><?= $langcod == 'ar' ? 'نوع السفر' : 'Travel Type' ?></th>
                    <th><?= $langcod == 'ar' ? 'عدد المسافرين' : 'Passengers' ?></th>
                    <th><?= $langcod == 'ar' ? 'الحالة' : 'Status' ?></th>
                    <th><?= $langcod == 'ar' ? 'تاريخ الطلب' : 'Date' ?></th>
                    <th><?= $langcod == 'ar' ? 'إدارة' : 'Manage' ?></th>
                </tr>
            </thead> 
            
            <tbody> 
            <?php while($row = mysqli_fetch_assoc($result)){ 
                $status_class = "pending";
                if ($row['request_status'] == 'مقبول' || strtolower($row['request_status']) == 'approved') { $status_class = "approved"; }
                if ($row['request_status'] == 'مرفوض' || strtolower($row['request_status']) == 'rejected') { $status_class = "rejected"; }
            ?>
                <tr>
                    <td data-label="<?= $langcod == 'ar' ? 'الاسم' : 'Name' ?>"><?php echo htmlspecialchars($row['name']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'الهاتف' : 'Phone' ?>"><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'المدينة' : 'City' ?>"><?php echo htmlspecialchars($row['location']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'الوجهة' : 'Destination' ?>"><?php echo htmlspecialchars($row['destination']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'نوع السفر' : 'Travel Type' ?>"><?php echo htmlspecialchars($row['travel_reason']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'عدد المسافرين' : 'Passengers' ?>"><?php echo htmlspecialchars($row['passengers']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'الحالة' : 'Status' ?>">
                        <span class="status-badge <?= $status_class ?>">
                            <?php echo htmlspecialchars($row['request_status']); ?>
                        </span>
                    </td>
                    <td data-label="<?= $langcod == 'ar' ? 'تاريخ الطلب' : 'Date' ?>"><?php echo htmlspecialchars($row['created_at']); ?></td>
                    <td data-label="<?= $langcod == 'ar' ? 'إدارة' : 'Manage' ?>">
                        <a href="edit_gaza_request.php?id=<?php echo $row['id']; ?>&lang=<?= $langcod ?>" class="edit-btn">
                            <?= $langcod == 'ar' ? 'إدارة' : 'Manage' ?>
                        </a>
                    </td>
                </tr>
            <?php } ?>
            </tbody>
        </table>
    </div>

    <div class="back-buttons">
        <a href="../index.php" class="back-btn">
            🏠 <?= $langcod == 'ar' ? 'العودة للرئيسية' : 'Home' ?>
        </a>

        <a href="javascript:history.back()" class="back-btn">
            ⬅️ <?= $langcod == 'ar' ? 'العودة للسابق' : 'Back' ?>
        </a>
    </div>

</div>

</body>
</html>
