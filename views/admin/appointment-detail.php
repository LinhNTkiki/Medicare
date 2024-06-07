<?php
session_start(); // Khởi động session
if (!isset($_SESSION['admin_name'])) {
    header('Location: http://localhost/Medicare/index.php?controller=auth&action=loginAdmin');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.png" rel="icon">
    <title>Chi tiết lịch khám</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php'?>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head py-0">
            <h2 class="page-head-title" style="font-size: 25px">Chi tiết lịch khám <?php echo $appointment['id'] ?></h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý đặt lịch</li>
                    <li class="breadcrumb-item active">Danh sách lịch khám</li>
                    <li class="breadcrumb-item active">Chi tiết</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid py-1">
            <div class="card card-table">
                <div class="main-content container-fluid row">
                    <div class="col-6">
                        <h3 class="mt-0">Thông tin cá nhân</h3>
                        <div class="mb-3 row">
                            <div class="col-5">
                                <label for="specialtyName" class="form-label">Tên bệnh nhân</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_name'] ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="specialtyName" class="form-label">Ngày sinh</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_dob'] ?>
                                </div></div>
                            <div class="col-3">
                                <label for="" class="form-label">Giới tính</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_gender'] == 0 ? 'Nữ' : "Nam" ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-6">
                                <label for="" class="form-label">Email</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_email'] ?>
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="" class="form-label">Số điện thoại</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['patient_phone'] ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <h3 class="mt-0">Thông tin khám bệnh</h3>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Tên bác sĩ</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['doctor_name'] ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Chuyên khoa khám</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['specialty_name'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Ngày đặt lịch khám</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['date_slot'] ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Giờ khám</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php echo $appointment['time_slot'] ?>
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="" class="form-label">Mô tả triệu chứng của bệnh nhân</label>
                            <textarea class="form-control" rows="3" disabled><?php echo $appointment['patient_description'] ?></textarea>
                        </div>
                        <div class="mb-3 row">
                            <div class="col-8">
                                <label for="" class="form-label">Trạng thái</label>
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php
                                    switch ($appointment['status']) {
                                        case 0:
                                            echo "Chưa xác nhận";
                                            break;
                                        case 1:
                                            echo "Đã xác nhận";
                                            break;
                                        case 2:
                                            echo "Đã hoàn thành";
                                            break;
                                        case 3:
                                            echo "Đã hủy";
                                            break;
                                        default:
                                            echo "Trạng thái không xác định";
                                            break;
                                    }
                                    ?>
                                </div>
                            </div>
                            <div class="col-4">
                                <label for="" class="form-label">Kết quả</label>
                                <!-- Liên kết để mở modal -->
                                <div class="form-control-sm" style="background-color: #eee; line-height: 30px">
                                    <?php if ($appointment['result'] === null): ?>
                                        Chưa có kết quả
                                    <?php else: ?>
                                        <a href="#" data-toggle="modal" data-target="#resultModal" data-result="<?php echo htmlspecialchars($appointment['result']); ?>">Xem kết quả</a>
                                    <?php endif; ?>
                                </div>

                                <!-- Modal để hiển thị PDF -->
                                <div class="modal fade" id="resultModal" tabindex="-1" role="dialog" aria-labelledby="resultModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-lg" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="resultModalLabel">Hồ sơ khám bệnh</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <iframe id="resultFrame" src="" style="width:100%; height:500px;" frameborder="0"></iframe>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-info" id="openInNewTab">
                                                    <a href="#" target="_blank" style="color: white; text-decoration: none;">Mở sang tab mới</a>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="mt-3 d-flex justify-content-between">
                        <a id="backButton" class="btn btn-danger"
                           href="http://localhost/Medicare/index.php?controller=appointment&action=index">Quay lại danh sách</a>
                        <form id="uploadForm" enctype="multipart/form-data">
                            <input type="file" id="pdfFile" name="pdfFile" accept=".pdf" hidden="hidden">
                            <input type="hidden" name="appointment_id" value="<?php echo $appointment['id']; ?>" hidden="hidden">
                            <button class="btn btn-primary" type="button" id="uploadButton">Tải lên kết quả</button>
                        </form>

                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--    pop-up sidebar-->
    <?php include 'pop-up-sidebar.php' ?>
</div>

<?php include 'import-script.php'?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        App.init();

        document.getElementById('uploadButton').addEventListener('click', function() {
            // Trigger click event on file input to open file dialog
            document.getElementById('pdfFile').click();
        });

        document.getElementById('pdfFile').addEventListener('change', function() {
            if (this.files.length === 0) {
                alert('Vui lòng chọn một file trước khi tải lên.');
                return;
            }
            var file = this.files[0];

            if (file.type !== 'application/pdf') {
                alert('Vui lòng chọn một file PDF.');
                return;
            }

            var appointmentId = document.querySelector('input[name="appointment_id"]').value;
            var formData = new FormData();
            formData.append('pdfFile', file);
            formData.append('appointment_id', appointmentId);

            // Gửi AJAX request
            $.ajax({
                url: 'http://localhost/Medicare/index.php?controller=appointment&action=update_result',
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    alert(response)
                    window.location.reload()
                },
                error: function() {
                    alert('Có lỗi xảy ra, vui lòng thử lại.');
                }
            });
        });

        var modal = $('#resultModal');
        var iframe = $('#resultFrame');
        var openInNewTabButton = $('#openInNewTab a');

        modal.on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget);
            var resultUrl = button.data('result');
            iframe.attr('src', resultUrl);
            openInNewTabButton.attr('href', resultUrl);
        });

        openInNewTabButton.on('click', function () {
            modal.modal('hide');
        });

    });
</script>
</body>
</html>