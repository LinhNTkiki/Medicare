<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.png" rel="icon">
    <title>Xác nhận lịch khám</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <?php include 'import-link-tag.php' ?>
    <link href="http://localhost/Medicio/assets/css/appointment.css" rel="stylesheet">
    <style>
        #btn-action:focus {
            outline: none;
            border: none;
            box-shadow: none;
        }

    </style>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title">Xác nhận lịch khám</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý đặt lịch</li>
                    <li class="breadcrumb-item active">Xác nhận lịch khám</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid pt-0">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="row table-filters-container">
                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <label class="control-label table-filter-title">Lọc chuyên khoa:</label>
                                    <form>
                                        <select class="select2" name="specialty">
                                            <option value="All" <?php echo($specialtySelected == 'All' ? 'selected' : ''); ?>>
                                                Tất cả chuyên khoa
                                            </option>
                                            <?php
                                            foreach ($listSpecialties as $specialty) {
                                                // Kiểm tra nếu id của chuyên khoa hiện tại trùng với $specialtySelected
                                                $selected = ($specialty['specialty_id'] == $specialtySelected) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($specialty['specialty_id']) . "' $selected>" . htmlspecialchars($specialty['name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <label class="control-label table-filter-title">Lọc bác sĩ:</label>
                                    <form>
                                        <select class="select2" name="doctor">
                                            <option value="All" <?php echo($doctorSelected == 'All' ? 'selected' : ''); ?>>
                                                Tất cả bác sĩ
                                            </option>
                                            <?php
                                            foreach ($listDoctors as $doctor) {
                                                // Kiểm tra nếu id của bác sĩ hiện tại trùng với $doctor_selected
                                                $selected = ($doctor['id'] == $doctorSelected) ? 'selected' : '';
                                                echo "<option value='" . htmlspecialchars($doctor['id']) . "' $selected>" . htmlspecialchars($doctor['name']) . "</option>";
                                            }
                                            ?>
                                        </select>
                                    </form>
                                </div>
                            </div>


                            <div class="col-3 table-filters pb-0">
                                <span class="table-filter-title">Tra cứu bệnh nhân </span>
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Nhập tên hoặc sđt ..."
                                                   class="form-control" value="<?php echo $_GET['search'] ?? '' ?>">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <span class="table-filter-title" style="opacity: 0">Tìm kiếm</span>
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <button id="button" class="btn btn-success form-control">Tìm kiếm</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="noSwipe">
                                <table class="table table-striped table-hover be-table-responsive" id="table1">
                                    <thead>
                                    <tr>
                                        <th style="width:2%;">STT</th>
                                        <th style="width:13%;">Bác sĩ</th>
                                        <th style="width:15%;">Bệnh nhân</th>
                                        <th style="width:12%;">Thông tin liên hệ</th>
                                        <th style="width:10%;">Chuyên khoa khám</th>
                                        <th style="width:10%;">Thời gian hẹn</th>
                                        <th style="width:10%;" class="text-center">Trạng thái</th>
                                        <th style="width:1%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    $currentPage = $_GET['page'] ?? 1;
                                    $counter = ($currentPage - 1) * 10 + 1;
                                    foreach ($listAppointments as $appointment): ?>
                                        <tr class="<?php
                                        switch ($appointment['status']) {
                                            case 0:
                                                echo 'warning in-progress';
                                                break;
                                            case 1:
                                                echo 'primary to-do';
                                                break;
                                            case 2:
                                                echo 'success done';
                                                break;
                                            case 3:
                                                echo 'danger in-review';
                                                break;
                                            default:
                                                echo '';
                                        }
                                        ?>">
                                            <td style="text-align: center">
                                                <?php echo $counter; ?>
                                            </td>
                                            <td class="user-avatar cell-detail user-info">
                                                <img class="mt-0 mt-md-2 mt-lg-0"
                                                     src="<?php echo htmlspecialchars($appointment['doctor_avt']); ?>"
                                                     alt="Avatar">
                                                <span><?php echo htmlspecialchars($appointment['doctor_name']); ?></span>
                                                <!--                                            <span class="cell-detail-description">Bác sĩ chuyên khoa 1</span>-->
                                            </td>
                                            <td class="cell-detail milestone" data-project="Bootstrap">
                                                <span class="completed"><?php echo htmlspecialchars($appointment['patient_dob']); ?></span>
                                                <span class="cell-detail-description"
                                                      style="font-size: 13px; color: black"><?php echo htmlspecialchars($appointment['patient_name']); ?></span>
                                                <span><?php echo htmlspecialchars($appointment['patient_gender'] == 1 ? 'Nam' : 'Nũ'); ?></span>
                                            </td>
                                            <td class="milestone">
                                                <div><?php echo htmlspecialchars($appointment['patient_phone']); ?></div>
                                                <span class="version"><?php echo htmlspecialchars($appointment['patient_email']); ?></span>

                                            </td>
                                            <td class="cell-detail">
                                                <span><?php echo htmlspecialchars($appointment['specialty_name']); ?></span>
                                                <!--                                            <span class="cell-detail-description">63e8ec3</span>-->
                                            </td>
                                            <td class="cell-detail">
                                                <span class="date"><?php echo date('H:i', strtotime($appointment['time_slot'])); ?></span>
                                                <span class="cell-detail-description">
                                                <?php
                                                //$appointment['date_slot'] là số ngày kể từ ngày 1/1/1970
                                                $timestamp = $appointment['date_slot'] * 86400; // Chuyển đổi số ngày thành giây

                                                // Đặt múi giờ sang "Asia/Ho_Chi_Minh" để đảm bảo chuyển đổi ngày chính xác theo giờ Việt Nam
                                                date_default_timezone_set('Asia/Ho_Chi_Minh');

                                                $date = date('d-m-Y', $timestamp); // Định dạng lại timestamp thành ngày tháng
                                                echo htmlspecialchars($date);
                                                ?>
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <?php
                                                $statusColors = [
                                                    0 => ['#fbbc05', 'Chờ xác nhận'],
                                                    1 => ['#4285f4', 'Đã xác nhận'],
                                                    2 => ['#34a853', 'Đã hoàn thành'],
                                                    3 => ['#ea4335', 'Đã hủy'],
                                                    'default' => ['#d3d3d3', 'Không xác định']
                                                ];

                                                // Lấy màu và tên trạng thái dựa trên $appointment['status']
                                                $statusInfo = $statusColors[$appointment['status']] ?? $statusColors['default'];
                                                ?>
                                                <div style="width: 150px; height: 35px; color: black; line-height: 35px;
                                                        font-weight: normal; background-color: <?php echo $statusInfo[0]; ?>;">
                                                    <?php echo $statusInfo[1]; ?>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <button id="btn-action"
                                                            style="border: none; background-color: transparent; "
                                                            class=" dropdown-toggle" type="button"
                                                            data-toggle="dropdown" aria-haspopup="true"
                                                            aria-expanded="false">
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                             fill="currentColor" class="bi bi-three-dots-vertical"
                                                             viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                        </svg>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <button type="button" data-bs-toggle="modal"
                                                                class="dropdown-item" data-bs-target="#staticBackdrop"
                                                                data-id="<?php echo $appointment['id'] ?>">Cập nhật
                                                        </button>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        $counter++;
                                    endforeach; ?>
                                    </tbody>
                                </table>

                                <div class="row be-datatable-footer">
                                    <div class="col-sm-10 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;">
                                        <nav aria-label="Page navigation example">
                                            <?php
                                            $currentPage = $_GET['page'] ?? 1;
                                            $queryString = $_SERVER['QUERY_STRING']; // Lấy chuỗi truy vấn hiện tại
                                            parse_str($queryString, $queryParams); // Phân tích chuỗi truy vấn thành mảng
                                            unset($queryParams['page']); // Loại bỏ tham số 'page' để tránh trùng lặp
                                            $newQueryString = http_build_query($queryParams); // Tạo lại chuỗi truy vấn mà không có 'page'
                                            ?>
                                            <ul class="pagination">
                                                <li class="page-item <?php if ($currentPage == 1) echo 'disabled'; ?>">
                                                    <a class="page-link" href="?<?php echo $newQueryString; ?>&page=1"
                                                       aria-label="Previous">
                                                        <span aria-hidden="true">&laquo;</span>
                                                    </a>
                                                </li>
                                                <?php
                                                $totalPages = ceil($totalAppointment / 10); // Tính tổng số trang
                                                for ($i = 1; $i <= $totalPages; $i++) {
                                                    $activeClass = ($i == $currentPage) ? 'active' : '';
                                                    echo '<li class="page-item ' . $activeClass . '">
                                                <a class="page-link" 
                                                   href="?' . $newQueryString . '&page=' . $i . '">' . $i . '</a></li>';
                                                }
                                                ?>
                                                <li class="page-item <?php if ($currentPage == $totalPages) echo 'disabled'; ?>">
                                                    <a class="page-link"
                                                       href="?<?php echo $newQueryString; ?>&page=<?php echo $totalPages; ?>"
                                                       aria-label="Next">
                                                        <span aria-hidden="true">&raquo;</span>
                                                    </a>
                                                </li>
                                            </ul>
                                        </nav>
                                    </div>
                                    <?php
                                    $recordsPerPage = 10;
                                    $currentPage = $_GET['page'] ?? 1;
                                    $totalPages = ceil($totalAppointment / $recordsPerPage);
                                    $startRecord = ($currentPage - 1) * $recordsPerPage + 1;
                                    $endRecord = $currentPage * $recordsPerPage;
                                    if ($endRecord > $totalAppointment) {
                                        $endRecord = $totalAppointment;
                                    }
                                    ?>
                                    <div class="col-sm-2 dataTables_info" id="sub-pagination" style="line-height: 48px">
                                        <?php echo $startRecord . " đến " . $endRecord . " trong số " . $totalAppointment; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
         aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl"
        ">
        <div class="modal-content" style="max-width: 900px!important;">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Cập nhật lịch khám bệnh nhân</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php include 'appointment-update.php' ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                <button type="button" class="btn btn-primary" id="update-appointment">Cập nhật</button>
            </div>
        </div>
    </div>
</div>

<!--    pop-up sidebar-->
<?php include 'pop-up-sidebar.php' ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<?php include 'import-script.php' ?>
<script src="http://localhost/Medicio/assets/js/appointment-update.js"></script>
<script src="http://localhost/Medicio/assets/js/validateAppointment.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var appointmentUpdate = [];
        $('.dropdown-item').click(function () {
            var appointmentId = $(this).data('id');
            console.log('Hiển thị thông tin cho appointment ID:', appointmentId);

            $.ajax({
                url: 'http://localhost/Medicio/index.php',
                type: 'GET',
                data: {
                    controller: 'appointment',
                    action: 'get_one',
                    appointmentId: appointmentId
                },
                success: function (response) {
                    buildAppointment(response);
                    showAppointmentUpdate(response)
                },
                error: function () {
                    alert('Có lỗi xảy ra khi lấy dữ liệu');
                }
            });
        });

        function buildAppointment(response) {
            appointmentUpdate['id'] = parseInt(response['id'], 10)
            appointmentUpdate['employee_id'] = parseInt(response['employee_id'], 10)
            appointmentUpdate['specialty_id'] = parseInt(response['specialty_id'], 10)
            appointmentUpdate['date_slot'] = parseInt(response['date_slot'], 10)
            appointmentUpdate['time_id'] = parseInt(response['time_id'], 10)
            appointmentUpdate['patient_name'] = response['patient_name']
            appointmentUpdate['patient_gender'] = parseInt(response['patient_gender'], 10)
            appointmentUpdate['patient_dob'] = response['patient_dob']
            appointmentUpdate['patient_phone'] = response['patient_phone']
            appointmentUpdate['patient_email'] = response['patient_email']
            appointmentUpdate['patient_description'] = response['patient_description']
            appointmentUpdate['status'] = parseInt(response['status'], 10)
            return appointmentUpdate;
        }

        document.getElementById('patient-name').addEventListener('change', function () {
            appointmentUpdate['patient_name'] = this.value;
        });

        document.getElementById('patient-dob').addEventListener('change', function () {
            appointmentUpdate['patient_dob'] = this.value;
        });

        document.getElementById('patient-phone').addEventListener('change', function () {
            appointmentUpdate['patient_phone'] = this.value;
        });

        document.getElementById('patient-email').addEventListener('change', function () {
            appointmentUpdate['patient_email'] = this.value;
        });

        document.getElementById('patient-description').addEventListener('change', function () {
            appointmentUpdate['patient_description'] = this.value;
        });

        document.getElementById('status-appointment').addEventListener('change', function () {
            appointmentUpdate['status'] = parseInt(this.value, 10);
        });

        var genderInputs = document.getElementsByName('gender');
        Array.from(genderInputs).forEach(function (input) {
            input.addEventListener('change', function () {
                if (this.checked) {
                    appointmentUpdate['patient_gender'] = parseInt(this.value, 10)
                }
            });
        });

        // event click Cập nhật
        document.getElementById('update-appointment').addEventListener('click', function () {
            var appointmentUpdated = appointmentUpdate;

            appointmentUpdated['specialty_id'] = isNaN(parseInt(document.getElementById('selected-specialty')?.value, 10))
                ? appointmentUpdate['specialty_id']
                : parseInt(document.getElementById('selected-specialty')?.value, 10);

            appointmentUpdated['employee_id'] = isNaN(parseInt(document.getElementById('selected-doctor')?.value, 10))
                ? appointmentUpdate['employee_id']
                : parseInt(document.getElementById('selected-doctor')?.value, 10);

            appointmentUpdated['date_slot'] = isNaN(parseInt(document.getElementById('date-slot')?.value, 10))
                ? appointmentUpdate['date_slot']
                : parseInt(document.getElementById('date-slot')?.value, 10);

            appointmentUpdated['time_id'] = isNaN(parseInt(document.getElementById('time-slot')?.value, 10))
                ? appointmentUpdate['time_id']
                : parseInt(document.getElementById('time-slot')?.value, 10);

            console.log('appointmentUpdated', appointmentUpdated)

            $.ajax({
                url: 'http://localhost/Medicio/index.php?controller=appointment&action=update',
                type: 'POST',
                // contentType: 'application/json', // Thêm header này nếu bạn gửi JSON
                data: {
                    id: appointmentUpdated['id'],
                    employee_id: appointmentUpdate['employee_id'],
                    specialty_id: appointmentUpdate['specialty_id'],
                    date_slot: appointmentUpdate['date_slot'],
                    time_id: appointmentUpdate['time_id'],
                    patient_name: appointmentUpdate['patient_name'],
                    patient_gender: appointmentUpdate['patient_gender'],
                    patient_email: appointmentUpdate['patient_email'],
                    patient_description: appointmentUpdate['patient_description'],
                    status: appointmentUpdate['status'],
                },
                success: function (response) {
                    location.reload()
                },
                error: function () {
                    alert('Có lỗi xảy ra khi gửi dữ liệu');
                }
            });
        });

        // in thong tin len man update
        function showAppointmentUpdate(appointment) {
            var specialty = document.getElementById('dropdownMenuButton');
            var doctor = document.getElementById('dropdownMenuButtonDoctor');
            var date_selected = document.getElementById('date_selected');
            var patient_name = document.getElementById('patient-name');
            var gender = document.getElementsByName('gender');
            var patient_dob = document.getElementById('patient-dob');
            var patient_phone = document.getElementById('patient-phone');
            var patient_email = document.getElementById('patient-email');
            var patient_description = document.getElementById('patient-description')
            var status_appointment = document.getElementById('status-appointment');

            // Hiển thị các khung giờ
            displayTimeSlots([], appointment['time_slot']);

            // Cập nhật thông tin chuyên khoa và bác sĩ
            specialty.textContent = 'Chuyên khoa: ' + appointment['specialty_name'];
            doctor.textContent = 'Bác sĩ: ' + appointment['doctor_name'];

            patient_name.value = appointment['patient_name']
            for (var i = 0; i < gender.length; i++) {
                // Kiểm tra nếu giá trị của radio button trùng với 'patient_gender'
                if (gender[i].value == appointment['patient_gender']) {
                    gender[i].checked = true; // Đặt radio button này là checked
                    break; // Thoát vòng lặp sau khi đã tìm thấy và đặt checked
                }
            }
            patient_dob.value = appointment['patient_dob']
            patient_phone.value = appointment['patient_phone']
            patient_email.value = appointment['patient_email']
            patient_description.value = appointment['patient_description']
            status_appointment.value = parseInt(appointment['status'], 10);

            // Tính toán timestamp từ số ngày kể từ ngày 1/1/1970
            var timestamp = appointment['date_slot'] * 86400 * 1000; // Nhân với 1000 để chuyển từ giây sang miligiây

            // Tạo đối tượng Date mới từ timestamp
            var date = new Date(timestamp);

            // Định dạng ngày tháng
            var formattedDate = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date.getMonth() + 1)).slice(-2) + '-' + date.getFullYear();

            // Hiển thị ngày đã định dạng
            date_selected.textContent = formattedDate;
        }


        App.init();
        App.tableFilters();

        function showSuccessNotification() {
            $.gritter.add({
                title: "Success",
                text: "This is a simple Gritter Notification.",
                class_name: "color success"
            });
        }
    });
</script>
<script>
    var url_appointment = 'http://localhost/Medicio/index.php?controller=appointment&action=confirm&page=1'

    document.getElementById('button').addEventListener('click', function () {
        var specialty = document.querySelector('.select2[name="specialty"]').value === 'All'
            ? null
            : document.querySelector('.select2[name="specialty"]').value;
        var doctor = document.querySelector('.select2[name="doctor"]').value === 'All'
            ? null
            : document.querySelector('.select2[name="doctor"]').value;
        var searchInput = document.getElementById('searchInput').value.trim();


        if (specialty) {
            url_appointment += '&specialty=' + encodeURIComponent(specialty);
        }
        if (doctor) {
            url_appointment += '&doctor=' + encodeURIComponent(doctor);
        }
        if (searchInput.length > 0) {
            url_appointment += '&search=' + encodeURIComponent(searchInput);
        }

        console.log(url_appointment)

        window.location.href = url_appointment
    });

    function getRowClass(status) {
        switch (status) {
            case 0:
                return 'warning in-progress';
            case 1:
                return 'primary to-do';
            case 2:
                return 'success done';
            case 3:
                return 'danger in-review';
            default:
                return '';
        }
    }

    function formatDate(timestamp) {
        var date = new Date(timestamp * 1000);
        return date.getDate() + '-' + (date.getMonth() + 1) + '-' + date.getFullYear();
    }

    function convertDateToDayTimestamp(dateString) {
        if (!dateString) return null;
        var parts = dateString.split('/');
        var day = parseInt(parts[0], 10);
        var month = parseInt(parts[1], 10) - 1;
        var year = parseInt(parts[2], 10);
        var date = new Date(Date.UTC(year, month, day));

        // Chuyển đổi ngày sang timestamp và chia cho số giây trong một ngày
        return Math.floor(date.getTime() / 86400000); // 86400000 là số miligiây trong một ngày
    }
</script>
</body>
</html>