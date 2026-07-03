<?php
include "../includes/db.php";

if(isset($_POST['add'])){

    $title = $_POST['title'];
    $points = $_POST['points'];
    $date = $_POST['travel_date'];
    $priority = $_POST['priority'];

    $sql = "INSERT INTO crossing_cases
    (title,points,travel_date,priority)

    VALUES
    ('$title','$points','$date','$priority')";

    mysqli_query($conn,$sql);

    echo $langcod == 'ar'
        ? "✅ تمت إضافة الحالة"
        : "Case added successfully";
}
?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<form method="POST">

<input type="text" name="title"
placeholder="<?= $langcod == 'ar' ? 'عنوان الحالة' : 'Case Title' ?>">

<input type="number" name="points"
placeholder="<?= $langcod == 'ar' ? 'عدد النقاط' : 'Points' ?>">

<input type="date" name="travel_date">

<select name="priority">

<option>
<?= $langcod == 'ar' ? 'عاجل جدا' : 'Very Urgent' ?>
</option>

<option>
<?= $langcod == 'ar' ? 'عاجل' : 'Urgent' ?>
</option>

<option>
<?= $langcod == 'ar' ? 'متوسط' : 'Medium' ?>
</option>

</select>

<button name="add">
<?= $langcod == 'ar' ? 'إضافة الحالة' : 'Add Case' ?>
</button>

</form>