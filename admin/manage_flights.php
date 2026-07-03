<?php
session_start();

include "../config.php";

$langcod = $_SESSION['lang'] ?? 'ar';

if (!isset($_SESSION['role'])) {
    die($langcod=='ar' ? "🚫 يجب تسجيل الدخول" : "🚫 Login required");
}

if ($_SESSION['role'] !== 'admin') {
    die($langcod=='ar' ? "🚫 لا تملك صلاحية الوصول" : "🚫 No permission");
}

if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    mysqli_query(
        $conn,
        "DELETE FROM flights WHERE id='$id'"
    );

    echo "<script>
        alert('".($langcod=='ar' ? 'تم حذف الرحلة' : 'Flight deleted')."');
        window.location.href='manage_flights.php';
    </script>";

    exit();
}

$sql = "
SELECT * FROM flights
ORDER BY id DESC
";

$result = mysqli_query($conn,$sql);
?>

<!DOCTYPE html>
<html lang="<?= $langcod ?>" dir="<?= $langcod=='ar' ? 'rtl' : 'ltr' ?>">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $langcod=='ar' ? 'إدارة الرحلات' : 'Manage Flights' ?></title>
    <link rel="stylesheet" href="../assets/css/admin/manage_flights.css">
    <link rel="preconnect" href="https://googleapis.com">
    <link rel="preconnect" href="https://gstatic.com" crossorigin>
    <link href="https://googleapis.com/css2?family=Cairo:wght@400;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
</head>

<body class="admin-page">

<div class="dashboard-container animated-fadeIn">

    <h1>
        <?= $langcod=='ar' ? 'إدارة الرحلات' : 'Flights Management' ?>
    </h1>

    <div class="table-responsive-wrapper">
        <table class="flights-table">
            <thead>
                <tr>
                    <th>#</th>
                    <th><?= $langcod=='ar' ? 'من' : 'From' ?></th>
                    <th><?= $langcod=='ar' ? 'إلى' : 'To' ?></th>
                    <th><?= $langcod=='ar' ? 'السعر' : 'Price' ?></th>
                    <th><?= $langcod=='ar' ? 'المقاعد' : 'Seats' ?></th>
                    <th><?= $langcod=='ar' ? 'الحالة' : 'Status' ?></th>
                    <th><?= $langcod=='ar' ? 'إجراءات' : 'Actions' ?></th>
                </tr>
            </thead>
            
            <tbody>
            <?php
            while($row = mysqli_fetch_assoc($result)){
                $status_raw = $row['status'] ?? '';
                $status_class = "pending";
                if ($status_raw == 'في الموعد' || strtolower($status_raw) == 'on time') { $status_class = "approved"; }
                if ($status_raw == 'ملغية' || strtolower($status_raw) == 'cancelled' || $status_raw == 'ملغي') { $status_class = "rejected"; }
            ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['from_city']); ?></td>
                    <td><?php echo htmlspecialchars($row['to_city']); ?></td>
                    <td class="price-text"><?php echo htmlspecialchars($row['price']); ?>$</td>
                    <td><?php echo htmlspecialchars($row['seats']); ?></td>
                    <td>
                        <span class="status-badge <?= $status_class ?>">
                            <?php echo htmlspecialchars($status_raw); ?>
                        </span>
                    </td>
                    <td>
                        <div class="table-actions-row">
                            <a href="edit_flight.php?id=<?php echo $row['id']; ?>" class="edit-btn">
                                ✏️ <?= $langcod=='ar' ? 'تعديل' : 'Edit' ?>
                            </a>

                            <a href="manage_flights.php?delete=<?php echo $row['id']; ?>" class="delete-btn"
                               onclick="return confirm('<?= $langcod=='ar' ? 'هل أنت متأكد من حذف الرحلة؟' : 'Are you sure?' ?>')">
                                ❌ <?= $langcod=='ar' ? 'حذف' : 'Delete' ?>
                            </a>
                        </div>
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
