<?php
session_start();
// Kiểm tra xem người dùng đã đăng nhập hay chưa
if (isset($_SESSION['user_phone'])) {
    header("Location: http://localhost/Medicio/index.php?controller=home&action=home");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <title>Đăng nhập</title>
    <link href="assets/img/logo.png" rel="icon">
    <link href="assets/img/favicon.png" rel="apple-touch-icon">
    <!-- Favicons -->
    <link rel="stylesheet" href="https://unpkg.com/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/bs-brain@2.0.4/components/logins/login-9/assets/css/login-9.css">
    <link href="assets/css/style.css" rel="stylesheet">

    <style>
        .toast {
            visibility: hidden; /* Ẩn toast */
            min-width: 250px; /* Đặt chiều rộng tối thiểu */
            margin-left: -125px; /* Đẩy toast sang trái một nửa chiều rộng của nó */
            background-color: #ff0000; /* Màu nền */
            color: white; /* Màu chữ */
            text-align: center; /* Căn giữa chữ */
            border-radius: 10px; /* Bo góc */
            padding: 16px; /* Đệm */
            position: fixed; /* Đặt vị trí cố định */
            z-index: 1; /* Đảm bảo toast nằm trên các thành phần khác */
            left: 50%; /* Đặt ở giữa màn hình theo chiều ngang */
            bottom: 30px; /* Khoảng cách từ dưới cùng */
            font-size: 17px; /* Cỡ chữ */
        }

        .toast.show {
            visibility: visible; /* Hiển thị toast */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        @-webkit-keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @keyframes fadein {
            from {
                bottom: 0;
                opacity: 0;
            }
            to {
                bottom: 30px;
                opacity: 1;
            }
        }

        @-webkit-keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }

        @keyframes fadeout {
            from {
                bottom: 30px;
                opacity: 1;
            }
            to {
                bottom: 0;
                opacity: 0;
            }
        }


        .error-message {
            color: red;
            font-size: 0.8rem;
            margin-top: 5px;
        }

        .invalid-input {
            border-color: red;
        }
    </style>
</head>
<body>
<!-- Login 9 - Bootstrap Brain Component -->
<section class=" py-3 py-md-5 py-xl-8" style="background-color: #3fbbc0; overflow-y: hidden ">
    <div class="container">
        <div class="row gy-4 align-items-center">
            <div class="col-12 col-md-6 col-xl-7">
                <div class="d-flex justify-content-center" style="background-color: #3fbbc0; color: white">
                    <div class="col-12 col-xl-9">
                        <a href="http://localhost/Medicio/index.php?controller=home&action=home#hero"
                           class="logo me-auto">
                            <img class="img-fluid rounded mb-4" loading="lazy" src="assets/img/Medicare.png" width="345"
                                 alt="BootstrapBrain Logo">
                        </a>
                        <hr class="border-primary-subtle mb-4">
                        <h2 class="h1 mb-4">Chào mừng đến với Medicare.</h2>
                        <p class="lead mb-5">Chúng tôi rất vui được chăm sóc sức khỏe của quý vị. Tại đây, chúng tôi cam
                            kết cung cấp dịch vụ y tế chất lượng, chu đáo và chuyên nghiệp nhất để mang lại sự an tâm và
                            hài lòng cho quý khách.</p>
                        <div class="text-endx">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="currentColor"
                                 class="bi bi-grip-horizontal" viewBox="0 0 16 16">
                                <path d="M2 8a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm3 3a1 1 0 1 1 0 2 1 1 0 0 1 0-2zm0-3a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="card border-0 rounded-4">
                    <div class="card-body p-3 p-md-4 p-xl-4 mb-5">
                        <div class="row mb-1">
                            <div class="col-12">
                                <div>
                                    <h3>Đăng Nhập</h3>
                                    <p>Bạn không có tài khoản? <a
                                                href="http://localhost/Medicio/index.php?controller=register&action=register">Đăng
                                            kí</a></p>
                                </div>
                            </div>
                        </div>
                        <form method="post" onsubmit="return false;">
                            <div class="row gy-3 overflow-hidden">
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="tel" class="form-control" name="phone" id="phone"
                                               placeholder="name@example.com" required>
                                        <label for="phone" class="form-label">Số điện thoại</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating mb-2">
                                        <input type="password" class="form-control" name="password" id="password"
                                               value="" placeholder="Password" required>
                                        <label for="password" class="form-label">Mật khẩu</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <span id="login-false"></span>
                                </div>
                                <div class="col-12">
                                    <div class="form-check mb-3">
                                        <input class="form-check-input" type="checkbox" value="" name="remember_me"
                                               id="remember_me">
                                        <label class="form-check-label text-secondary" for="remember_me">
                                            Giữ tôi luôn đăng nhập
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12 mt-4">
                                    <div class="d-grid">
                                        <button id="loginButton"
                                                class="btn btn-lg" style="background-color: #3fbbc0; color: white"
                                                type="submit">Đăng nhập ngay
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex gap-2 gap-md-4 flex-column flex-md-row justify-content-md-end mt-3">
                                    <a href="#!">Quên mật khẩu</a>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <p class="mt-4 mb-4">Hoặc tiếp tục với</p>
                                <div class="d-flex gap-2 gap-sm-3 justify-content-centerX">
                                    <a href="#!" class="btn btn-outline-danger bsb-btn-circle bsb-btn-circle-l">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             fill="currentColor" class="bi bi-google" viewBox="0 0 16 16">
                                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"/>
                                        </svg>
                                    </a>
                                    <a href="#!" class="btn btn-outline-primary bsb-btn-circle bsb-btn-circle-l">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             fill="currentColor" class="bi bi-facebook" viewBox="0 0 16 16">
                                            <path d="M16 8.049c0-4.446-3.582-8.05-8-8.05C3.58 0-.002 3.603-.002 8.05c0 4.017 2.926 7.347 6.75 7.951v-5.625h-2.03V8.05H6.75V6.275c0-2.017 1.195-3.131 3.022-3.131.876 0 1.791.157 1.791.157v1.98h-1.009c-.993 0-1.303.621-1.303 1.258v1.51h2.218l-.354 2.326H9.25V16c3.824-.604 6.75-3.934 6.75-7.951z"/>
                                        </svg>
                                    </a>
                                    <a href="#!" class="btn btn-outline-dark bsb-btn-circle bsb-btn-circle-l">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                             fill="currentColor" class="bi bi-apple" viewBox="0 0 16 16">
                                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z"/>
                                            <path d="M11.182.008C11.148-.03 9.923.023 8.857 1.18c-1.066 1.156-.902 2.482-.878 2.516.024.034 1.52.087 2.475-1.258.955-1.345.762-2.391.728-2.43Zm3.314 11.733c-.048-.096-2.325-1.234-2.113-3.422.212-2.189 1.675-2.789 1.698-2.854.023-.065-.597-.79-1.254-1.157a3.692 3.692 0 0 0-1.563-.434c-.108-.003-.483-.095-1.254.116-.508.139-1.653.589-1.968.607-.316.018-1.256-.522-2.267-.665-.647-.125-1.333.131-1.824.328-.49.196-1.422.754-2.074 2.237-.652 1.482-.311 3.83-.067 4.56.244.729.625 1.924 1.273 2.796.576.984 1.34 1.667 1.659 1.899.319.232 1.219.386 1.843.067.502-.308 1.408-.485 1.766-.472.357.013 1.061.154 1.782.539.571.197 1.111.115 1.652-.105.541-.221 1.324-1.059 2.238-2.758.347-.79.505-1.217.473-1.282Z"/>
                                        </svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div id="toast" class="toast">Thông báo ở đây!</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var inputs = document.querySelectorAll('.form-control');

        inputs.forEach(function (input) {
            input.addEventListener('input', function () {
                // Xóa thông báo lỗi nếu có
                var errorMessage = input.parentElement.querySelector('.error-message');
                if (errorMessage) {
                    errorMessage.remove();
                }
                // Xóa viền đỏ
                input.classList.remove('invalid-input');
            });
        });

        document.getElementById('loginButton').addEventListener('click', validateAndSubmit);
    });

    function validateAndSubmit() {
        var isValid = true;
        var formData = new FormData();
        var inputs = document.querySelectorAll('.form-control');

        // Xóa các thông báo lỗi trước đó
        document.querySelectorAll('.error-message').forEach(function (message) {
            message.remove();
        });

        inputs.forEach(function (input) {
            var error = null;
            if (!input.value) {
                error = 'Trường này không được để trống';
            } else if (input.name === 'phone' && !/^\d{10}$/.test(input.value)) {
                error = 'Số điện thoại phải là 10 chữ số';
            }

            if (error) {
                var errorMessage = document.createElement('div');
                errorMessage.classList.add('error-message');
                errorMessage.textContent = error;
                input.classList.add('invalid-input');
                input.parentElement.appendChild(errorMessage);
                isValid = false;
            } else {
                formData.append(input.name, input.value);
                input.classList.remove('invalid-input');
            }
        });

        if (isValid) {
            fetch('services/loginService.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Đăng nhập thành công!', '#28a745', 800, redirectToHome);
                    } else {
                        showToast('Đăng nhập thất bại: ' + data.message, 'dc3545', 3000);
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    }

    function showToast(message, color, time, callback) {
        var toast = document.getElementById("toast");
        toast.textContent = message; // Cập nhật thông điệp
        toast.style.backgroundColor = color; // Cập nhật màu nền
        toast.className = "toast show";
        setTimeout(function () {
            toast.className = toast.className.replace("show", "");
            if (callback) callback(); // Gọi callback sau khi Toast ẩn
        }, time);
    }

    function redirectToHome() {
        window.location.href = 'http://localhost/Medicio/index.php?controller=home&action=home'; // Điều hướng đến trang chủ sau khi đăng nhập thành công
    }
</script>
</body>
</html>