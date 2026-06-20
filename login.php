<?php
// Memulai session untuk mengecek status login user
session_start();
include 'koneksi.php';

// Jika user ternyata sudah login, langsung alihkan ke halaman utama user (home.php)
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

$error_message = "";

// Proses ketika tombol login ditekan
if (isset($_POST['login'])) {
    // PERBAIKAN 1: Mengubah $conn menjadi $koneksi sesuai file koneksi.php
    $email = mysqli_real_escape_string($koneksi, $_POST['email']);
    $password = $_POST['password']; 

    if (!empty($email) && !empty($password)) {
        // PERBAIKAN 2: Menyamakan nama tabel 'Users' (Huruf U besar) sesuai register.php
        $query = "SELECT * FROM Users WHERE email = '$email' OR username = '$email' LIMIT 1";
        // PERBAIKAN 3: Mengubah $db menjadi $koneksi
        $result = mysqli_query($koneksi, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            
            // PERBAIKAN 4: Mengubah perbandingan teks biasa '===' menjadi password_verify() karena password di-hash
            if (password_verify($password, $user_data['password'])) {
                
                // Menetapkan session data login dengan aman
                $_SESSION['username'] = $user_data['username'];
                $_SESSION['nama'] = $user_data['nama']; 
                
                // Alihkan langsung ke halaman dashboard utama
                header("Location: home.php");
                exit();
            } else {
                $error_message = "Password yang Anda masukkan salah.";
            }
        } else {
            $error_message = "Email atau Username tidak terdaftar.";
        }
    } else {
        $error_message = "Silakan isi semua kolom.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookLens - Login</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }
        body {
            background-color: #f4f7f9; 
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 20px;
        }

        /* Tombol Back di Pojok Kiri Atas */
        .back-link {
            position: absolute;
            top: 40px;
            left: 40px;
            text-decoration: none;
            color: #1e293b;
            font-size: 0.9rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Wrapper Header Tengah */
        .header-container {
            text-align: center;
            margin-bottom: 30px;
        }
        .header-icon {
            font-size: 3.5rem;
            color: #1e293b;
            margin-bottom: 12px;
        }
        .header-container h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #0f172a;
        }
        .header-container p {
            color: #64748b;
            font-size: 0.9rem;
            margin-top: 4px;
        }

        /* Kotak Form Utama Putih di Tengah */
        .login-box-card {
            background-color: #ffffff;
            width: 100%;
            max-width: 460px;
            border-radius: 8px;
            padding: 40px;
            border: 1px solid #e2e8f0;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        /* Form Group */
        .form-group {
            margin-bottom: 22px;
            text-align: left;
        }
        .form-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .input-inner-wrapper {
            position: relative;
            width: 100%;
        }
        .input-inner-wrapper input {
            width: 100%;
            padding: 12px 40px 12px 45px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 0.9rem;
            outline: none;
            color: #334155;
            background-color: #fbfbfb;
            font-family: 'Poppins', sans-serif;
        }
        .input-inner-wrapper input::placeholder {
            color: #94a3b8;
        }
        
        /* Ikon Sisi Kiri Input */
        .field-icon-left {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
            font-size: 1rem;
        }

        /* Ikon Mata Sisi Kanan Input Password */
        .eye-toggle-right {
            position: absolute;
            right: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #64748b;
            cursor: pointer;
            font-size: 1rem;
        }

        /* Baris Forgot Password di Bawah Input */
        .forgot-wrapper {
            text-align: right;
            margin-top: 6px;
        }
        .forgot-wrapper a {
            font-size: 0.75rem;
            color: #334155;
            text-decoration: none;
            font-weight: 500;
        }

        /* Checkbox Remember Me */
        .remember-wrapper {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-top: 15px;
            margin-bottom: 24px;
        }
        .remember-wrapper input {
            cursor: pointer;
        }
        .remember-wrapper label {
            font-size: 0.8rem;
            color: #475569;
            cursor: pointer;
        }

        /* Tombol Utama Login Dengan Panah Sesuai Desain */
        .btn-blue-login {
            width: 100%;
            background-color: #2b3a4a; 
            color: #ffffff;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 0.95rem;
            font-weight: 500;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-bottom: 25px;
        }
        .btn-blue-login:hover {
            background-color: #1e2936;
        }

        /* Garis Pembatas "Or continue with" */
        .or-divider {
            display: flex;
            align-items: center;
            text-align: center;
            color: #94a3b8;
            font-size: 0.75rem;
            margin-bottom: 25px;
        }
        .or-divider::before, .or-divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #e2e8f0;
        }
        .or-divider:not(:empty)::before { margin-right: .8em; }
        .or-divider:not(:empty)::after { margin-left: .8em; }

        /* Kumpulan Tombol Social Media */
        .social-row {
            display: flex;
            gap: 16px;
        }
        .btn-social-auth {
            flex: 1;
            background: #ffffff;
            border: 1px solid #cbd5e1;
            padding: 10px;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            font-size: 0.85rem;
            font-weight: 500;
            color: #334155;
            cursor: pointer;
        }
        .btn-social-auth img {
            width: 16px;
            height: 16px;
        }

        /* Teks Redirect Register di Paling Bawah */
        .bottom-register-text {
            text-align: center;
            margin-top: 35px;
            font-size: 0.85rem;
            color: #475569;
        }
        .bottom-register-text a {
            text-decoration: none;
            color: #2b3a4a;
            font-weight: 600;
        }

        /* Alert Merah Jika Salah Password/Email */
        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fee2e2;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.8rem;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>
<body>

    <a href="index.php" class="back-link">
        <i class="fa-solid fa-chevron-left"></i> Back
    </a>

    <div class="header-container">
        <div class="header-icon">
            <img src="assets/images/ui/boxicons_book.png" alt="BookLens Logo" class="login-custom-logo" style="width: 60px; height: 60px; object-fit: contain;">
        </div>
        <h1>Welcome Back</h1>
        <p>Please Log in to your BookLens account</p>
    </div>

    <div class="login-box-card">
        
        <?php if (!empty($error_message)): ?>
            <div class="alert-error"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <div class="form-group">
                <label>Email or Username</label>
                <div class="input-inner-wrapper">
                    <i class="fa-regular fa-envelope field-icon-left"></i>
                    <input type="text" name="email" placeholder="yourname@example.com / username" required>
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div class="input-inner-wrapper">
                    <i class="fa-solid fa-lock field-icon-left"></i>
                    <input type="password" id="inputPass" name="password" placeholder="********" required>
                    <i class="fa-regular fa-eye eye-toggle-right" onclick="viewPasswordToggle()"></i>
                </div>
                <div class="forgot-wrapper">
                    <a href="#">Forgot Password?</a>
                </div>
            </div>

            <div class="remember-wrapper">
                <input type="checkbox" id="remCheck" name="remember">
                <label for="remCheck">Remember me</label>
            </div>

            <button type="submit" name="login" class="btn-blue-login">
                Login <i class="fa-solid fa-arrow-right-long"></i>
            </button>

            <div class="or-divider">Or continue with</div>

            <div class="social-row">
                <button type="button" class="btn-social-auth">
                    <img src="https://www.google.com/images/branding/googleg/1x/googleg_standard_color_128dp.png" alt="Google Logo"> Google
                </button>
                <button type="button" class="btn-social-auth">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b9/2023_Facebook_icon.svg" alt="Facebook Logo"> Facebook
                </button>
            </div>
        </form>
    </div>

    <div class="bottom-register-text">
        Don't have an account? <a href="register.php">Register</a>
    </div>

    <script>
        function viewPasswordToggle() {
            var inputPass = document.getElementById("inputPass");
            var eyeIcon = document.querySelector(".eye-toggle-right");
            if (inputPass.type === "password") {
                inputPass.type = "text";
                eyeIcon.classList.remove("fa-regular", "fa-eye");
                eyeIcon.classList.add("fa-solid", "fa-eye-slash");
            } else {
                inputPass.type = "password";
                eyeIcon.classList.remove("fa-solid", "fa-eye-slash");
                eyeIcon.classList.add("fa-regular", "fa-eye");
            }
        }
    </script>
</body>
</html>