<?php
session_start();
require 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // اعتبارسنجی شماره تلفن
    $phone = $_POST['phone'];
    $phoneRegex = '/^[0-9]{10,11}$/';
    
    if (!preg_match($phoneRegex, $phone)) {
        echo "<script>
                alert('شماره تلفن باید فقط اعداد و ۱۰ یا ۱۱ رقم باشد');
                window.location.href = 'index.php';
              </script>";
        exit;
    }
    
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $student_number = $_POST['student_number'];
    $skills = $_POST['skills'];
    $created_at = date('Y-m-d H:i:s');

    try {
        // کوئری SQL صحیح با نام‌های دقیق ستون‌ها
          $sql = "INSERT INTO users (first_name, last_name, phone, student_number, skills) 
            VALUES (:first_name, :last_name, :phone, :student_number, :skills)";
    
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':first_name' => $first_name,
            ':last_name' => $last_name,
            ':phone' => $phone,
            ':student_number' => $student_number,
            ':skills' => $skills,
            ':created_at' => $created_at
        ]);

        echo "<script>
                alert('اطلاعات با موفقیت ثبت شد!');
                echo "ثبت نام با موفقیت انجام شد.";
                header("Refresh: 2; url=admin.php"); // هدایت خودکار به پنل ادمین
                window.location.href = 'index.php';
              </script>";
        exit;

    } catch (PDOException $e) {
        echo "<script>
                alert('خطا در ثبت اطلاعات: " . $e->getMessage() . "');
                window.location.href = 'index.php';
              </script>";
        exit;
    }
} else {
    header("Location: index.php");
    exit;
}
?>