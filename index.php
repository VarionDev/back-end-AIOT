<!DOCTYPE html>
<html lang="fa" dir="rtl">
<head>
    <meta charset="UTF-8">
    <style>
        /* استایل کلی صفحه */
        body {
            font-family: Tahoma, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center; /* وسط چین افقی */
            padding-top: 50px;
        }

        /* باکس فرم */
        .form-container {
            background-color: white;
            width: 400px; /* عرض فرم */
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        /* استایل ورودی‌ها */
        input[type="text"], 
        input[type="tel"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box; /* برای محاسبه دقیق عرض */
        }

        /* استایل برچسب‌ها */
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* استایل دکمه */
        button[type="submit"] {
            width: 100%;
            padding: 12px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button[type="submit"]:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

    <!-- شروع باکس فرم برای وسط چین شدن -->
    <div class="form-container">
        <h2>فرم ثبت نام</h2>
        
        <form method="POST" action="index.php" class="row g-3 needs-validation" novalidate>
            
            <label>نام:</label>
            <input type="text" name="first_name">
            
            <label>نام خانوادگی:</label>
            <input type="text" name="last_name">
            
            <!-- تغییر تگ input شماره تلفن -->
            <div class="col-md-6 mb-3">
            <label for="phone" class="form-label">شماره تلفن</label>
            <input 
                type="tel" 
                class="form-control" 
                id="phone" 
                name="phone" 
                pattern="[0-9]{10,11}" 
                title="شماره تلفن باید فقط عدد و ۱۰ یا ۱۱ رقم باشد"
                placeholder="مثال: 09123456789"
             required>
             <div class="form-text">فقط اعداد مجاز هستند (۱۰ یا ۱۱ رقم)</div>
            </div>

            <!-- اضافه کردن جاوااسکریپت برای اعتبارسنجی در سمت کاربر -->
            <script>
               document.querySelector('form').addEventListener('submit', function(e) {
               const phone = document.getElementById('phone').value;
               const phoneRegex = /^[0-9]{10,11}$/;
    
            if (!phoneRegex.test(phone)) {
                e.preventDefault();
                alert('شماره تلفن باید فقط اعداد و ۱۰ یا ۱۱ رقم باشد');
            }
            });   
           </script>
            
            <label>شماره دانشجویی:</label>
            <input type="text" name="student_number">
            
            <label>مهارت‌ها:</label>
            <textarea name="skills" rows="4" placeholder="مهارت خود را بنویسید..."></textarea>
            
            <br>
            
            <!-- دکمه ثبت -->
            <button type="submit">ثبت اطلاعات</button>

        </form>
    </div>

</body>
</html>