<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $phone = $_POST['phone'];
    $student_number = $_POST['student_number'];
    $skills = $_POST['skills'];

// اعتبارسنجی شماره تلفن هنگام ویرایش
if (isset($_POST['update'])) {
    $phone = $_POST['phone'];
    $phoneRegex = '/^[0-9]{10,11}$/';
    
    if (!preg_match($phoneRegex, $phone)) {
        $error = "شماره تلفن باید فقط اعداد و ۱۰ یا ۱۱ رقم باشد";
    }
}
} else {
    echo "دسترسی غیرمجاز!";
}
?>
<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>ویرایش اطلاعات دانشجو</title>
    <style>
        body {
            font-family: 'Tahoma', sans-serif;
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            width: 400px;
            text-align: right;
        }
        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 25px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
            color: #555;
        }
        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-sizing: border-box;
            font-family: 'Tahoma';
            text-align: right;
        }
        textarea {
            height: 100px;
            resize: none;
        }
        .btn-submit {
            width: 100%;
            padding: 12px;
            background-color: #2563eb;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            font-weight: bold;
            transition: background 0.3s;
        }
        .btn-submit:hover {
            background-color: #1d4ed8;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>ویرایش اطلاعات دانشجو</h2>
    <form action="update.php" method="POST">
        <div class="form-group">
            <label>نام:</label>
            <input type="text" name="first_name" value="" required>
        </div>

        <div class="form-group">
            <label>نام خانوادگی:</label>
            <input type="text" name="last_name" value="" required>
        </div>

        <div class="form-group">
            <label>تلفن:</label>
            <!-- استفاده از pattern برای محدودیت اعداد و تعداد ارقام -->
            <input type="tel" name="phone" value="" pattern="[0-9]{11}" title="لطفاً ۱۱ رقم عدد وارد کنید" required>
        </div>
        
        <div class="form-group">
            <label>شماره دانشجویی:</label>
            <input type="text" name="student_number" value="" required>
        </div>
        
        <div class="form-group">
            <label>مهارت‌ها:</label>
            <textarea name="skills"></textarea>
        </div>
        
        <button type="submit" class="btn-submit">ذخیره تغییرات</button>
    </form>
</div>

</body>
</html>