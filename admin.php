<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) 
{
    header("Location: login.php");
    exit;
}
require 'config.php';

// --- بخش مدیریت حذف ---
if (isset($_GET['delete']))
{
    $id = (int)$_GET['delete'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: admin.php");
    exit;
}

// --- بخش خروج ---
if (isset($_GET['action']) && $_GET['action'] == 'logout') 
{
    session_destroy();
    header("Location: login.php");
    exit;
}

// --- بخش جستجو و دریافت اطلاعات ---
$search = $_GET['search'] ?? '';

$sql = "SELECT * FROM users
        WHERE first_name LIKE :search1
        OR student_number LIKE :search2
        OR phone LIKE :search3
        ORDER BY id DESC";
        
$stmt = $pdo->prepare($sql);
$stmt->execute([
    ':search1' => "%$search%",
    ':search2' => "%$search%",
    ':search3' => "%$search%"
]);

// نکته مهم: ابتدا باید اطلاعات را Fetch کنیم، سپس در متغیر بریزیم
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
$totalUsers = count($users);

?>
<!DOCTYPE html>
<html lang="fa">
<head>
    <meta charset="UTF-8">
    <title>پنل ادمین</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        table, th, td { border:1px solid #ccc; padding:10px; text-align:center; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body style="direction: rtl; text-align: right; padding: 20px;">
<div class="container mt-4">
<a href="?action=logout" class="btn btn-danger float-start">
    خروج از پنل
</a>
<h2>لیست دانشجویان ثبت نام شده</h2>
<p>خوش آمدید، <?= htmlspecialchars($_SESSION['admin_user'] ?? 'مدیر') ?> عزیز</p>
   
   <div class="card mb-3">
       <div class="card-body">
           <h5 class="card-title">آمار سیستم</h5>
           <p class="card-text">
               تعداد کل دانشجویان ثبت‌نام شده:
               <strong><?= $totalUsers ?></strong>
           </p>
       </div>
   </div>
   
<form method="GET" class="row g-2 mb-3">
    <div class="col-md-4">
        <input type="text" name="search" class="form-control" placeholder="جستجو نام یا شماره دانشجویی" value="<?= htmlspecialchars($search) ?>">
    </div>
    <div class="col-auto">
        <button type="submit" class="btn btn-primary">جستجو</button>
    </div>
</form>

<table class="table table-bordered table-striped table-hover">
    <tr>
        <th>ردیف</th>
        <th>نام</th>
        <th>نام خانوادگی</th>
        <th>تلفن</th>
        <th>شماره دانشجویی</th>
        <th>مهارت ها</th>
        <th>زمان ثبت</th>
        <th>ویرایش</th>
        <th>حذف</th>
    </tr>

    <?php $row = 1; 
    // حالا آرایه $users پر شده است و حلقه کار می‌کند
    foreach($users as $user): ?>
    <tr>
        <td><?= $row++ ?></td>
        
        <td><?= htmlspecialchars($user['first_name']) ?></td>
        <td><?= htmlspecialchars($user['last_name']) ?></td>
        
        <td>
            <?php 
            // فرمت‌دهی شماره تلفن داخل جدول
            $phone = $user['phone'];
            if (strlen($phone) == 11) {
                $formatted_phone = substr($phone, 0, 4) . '-' . 
                                 substr($phone, 4, 3) . '-' . 
                                 substr($phone, 7, 4);
            } else {
                $formatted_phone = $phone;
            }
            echo htmlspecialchars($formatted_phone);
            ?>
        </td>

        <td><?= htmlspecialchars($user['student_number']) ?></td>
        <td><?= htmlspecialchars($user['skills']) ?></td>
        <td><?= $user['created_at'] ?></td>
        
        <td>
             <a href="edit.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">ویرایش</a>
        </td>
        <td>
            <a href="?delete=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('آیا از حذف این رکورد مطمئن هستید؟')">حذف</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
</div>
</body>
</html> 