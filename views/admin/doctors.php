<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.png" rel="icon">
    <title>Danh sách bác sĩ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
          href="http://localhost/Medicio/views/admin/assets/lib\perfect-scrollbar\css\perfect-scrollbar.css">
    <link rel="stylesheet" type="text/css"
          href="http://localhost/Medicio/views/admin/assets/lib\material-design-icons\css\material-design-iconic-font.min.css">
    <link rel="stylesheet" type="text/css"
          href="http://localhost/Medicio/views/admin/assets/lib\select2\css\select2.min.css">
    <link rel="stylesheet" type="text/css"
          href="http://localhost/Medicio/views/admin/assets/lib\bootstrap-slider\css\bootstrap-slider.min.css">
    <link rel="stylesheet" type="text/css"
          href="http://localhost/Medicio/views/admin/assets/lib\datetimepicker\css\bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="http://localhost/Medicio/views/admin/assets/css\app.css" type="text/css">
    <!--    icon-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw=="
          crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Danh sách bác sĩ</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý bác sĩ</li>
                    <li class="breadcrumb-item active">Danh sách bác sĩ</li>
                </ol>
            </nav>
        </div>
        <div class="main-content container-fluid" style="margin-top: -30px ">
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-table">
                        <div class="row table-filters-container">
                            <div class="col-2 table-filters pb-0">
                                <div class="filter-container">
                                    <button id="btnAddDoctor" type="button" class="btn btn-success form-control"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Thêm mới</button>
                                </div>
                            </div>

                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                </div>
                            </div>


                            <div class="col-3 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <form>
                                                <select class="form-select form-control" id="selectSpecialty">
                                                    <option value="All" selected>Tất cả chuyên khoa</option>
                                                    <?php
                                                    foreach ($listSpecialties as $specialty) {
                                                        echo "<option value='" . htmlspecialchars($specialty['name']) . "'>" . htmlspecialchars($specialty['name']) . "</option>";
                                                    }
                                                    ?>
                                                </select>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Nhập tên bác sĩ..."
                                                   class="form-control">
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
                                        <th style="width:20%;">Tên bác sĩ</th>
                                        <th style="width:17%;">Chức vụ</th>
                                        <th style="width:17%;">Chuyên khoa</th>
                                        <th style="width:15%;">Thông tin liên hệ</th>
                                        <th style="width:15%;">Đánh giá</th>
                                        <th style="width:10%;"></th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody" style="font-size: 15px">
                                    </tbody>
                                </table>
                                <div class="row be-datatable-footer">
                                    <div class="col-sm-10 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;"></div>
                                    <div class="col-sm-2 dataTables_info" id="sub-pagination"
                                         style="line-height: 48px"> 1 đến 5 trong số 100 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include "doctor-add.php"; ?>
    <!--    pop-up sidebar-->
    <?php include 'pop-up-sidebar.php' ?>
</div>
<?php include 'import-script.php' ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // App.init();
        // App.tableFilters();

        let listDoctors = <?php echo json_encode($listDoctors); ?>;
        const doctorsPerPage = 5;
        let currentPage = 1;

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', searchDoctor);

        const selectSpecialty = document.getElementById('selectSpecialty');
        selectSpecialty.addEventListener('change', filterBySpecialty);

        function searchDoctor() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const filteredDoctors = listDoctors.filter(doctor => doctor.name.toLowerCase().includes(input));
            currentPage = 1; // Reset lại trang hiện tại về trang đầu tiên
            setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
            renderDoctors(currentPage, filteredDoctors); // Cập nhật lại hàm renderDoctors để nhận thêm tham số filteredDoctors
        }

        function renderDoctors(page, items = listDoctors) {
            const start = (page - 1) * doctorsPerPage;
            const end = start + doctorsPerPage;
            const paginatedItems = items.slice(start, end);
            const tableBody = document.getElementById('tableBody');

            tableBody.innerHTML = '';
            paginatedItems.forEach((doctor, index) => {
                const rowNumber = start + index + 1; // Tính số thứ tự cho mỗi hàng
                const row = `<tr>
                        <td>${rowNumber}</td>
                        <td class='user-avatar cell-detail user-info'>
                            <img class='mt-0 mt-md-2 mt-lg-0'
                                 src='${doctor.avt}'
                                 alt='Avatar'>
                            <span>${doctor.name}</span>
                            <span class='cell-detail-description'>${doctor.specialty}</span>
                        </td>
                        <td class='cell-detail milestone' data-project='Bootstrap'>
                            <span style='font-size: 13px; color: black'>${doctor.position}</span>
                        </td>
                        <td class='cell-detail'>
                            <span>${doctor.specialty}</span>
                        </td>
                        <td class='milestone'>
                            <span class='version'>${doctor.email}</span>
                            <div>${doctor.phone}</div>
                        </td>
                        <td class='cell-detail'></td>
                        <td class='text-right'>
                            <div class='btn-group btn-hspace'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' style='border: none; background-color: transparent;'
                                        data-toggle='dropdown'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                        </svg>
                                </button>
                                <div class='dropdown-menu dropdown-menu-right' role='menu'>
                                    <a href='http://localhost/Medicio/index.php?controller=doctor&action=detail&doctor_id=${doctor.id}'
                                       type='button' class='dropdown-item'>Xem chi tiết</a>
                                </div>
                            </div>
                        </td>
                    </tr>`;
                tableBody.innerHTML += row;
            });

            const paginationInfo = document.getElementById('sub-pagination');
            paginationInfo.innerHTML = `${start + 1} - ${end} trong số ${items.length} bác sĩ`;
        }

        function setupPagination(items, wrapper, rowsPerPage) {
            wrapper.innerHTML = ""; // Xóa nội dung hiện tại của wrapper
            let pageCount = Math.ceil(items.length / rowsPerPage);
            let ul = document.createElement('ul');
            ul.className = 'pagination';

            // Tạo và thêm nút "Previous"
            let prevLi = document.createElement('li');
            prevLi.className = 'page-item';
            if (currentPage === 1) prevLi.classList.add('disabled');
            let prevLink = document.createElement('a');
            prevLink.className = 'page-link';
            prevLink.href = '#';
            prevLink.innerText = 'Trang trước';
            prevLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage > 1) {
                    changePage(currentPage - 1);
                }
            });
            prevLi.appendChild(prevLink);
            ul.appendChild(prevLi);

            // Tạo các nút số trang
            for (let i = 1; i <= pageCount; i++) {
                let li = paginationButton(i, items);
                ul.appendChild(li);
            }

            // Tạo và thêm nút "Next"
            let nextLi = document.createElement('li');
            nextLi.className = 'page-item';
            if (currentPage === pageCount) nextLi.classList.add('disabled');
            let nextLink = document.createElement('a');
            nextLink.className = 'page-link';
            nextLink.href = '#';
            nextLink.innerText = 'Trang tiếp';
            nextLink.addEventListener('click', function (e) {
                e.preventDefault();
                if (currentPage < pageCount) {
                    changePage(currentPage + 1);
                }
            });
            nextLi.appendChild(nextLink);
            ul.appendChild(nextLi);

            wrapper.appendChild(ul);
        }

        function paginationButton(page, items) {
            let li = document.createElement('li');
            li.className = 'page-item';
            if (currentPage === page) li.classList.add('active');

            let link = document.createElement('a');
            link.className = 'page-link';
            link.href = '#';
            link.innerText = page;
            link.addEventListener('click', function (e) {
                e.preventDefault();
                currentPage = page;
                renderDoctors(currentPage);

                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                li.classList.add('active');
            });

            li.appendChild(link);
            return li;
        }

        function filterBySpecialty() {
            const selectedSpecialty = document.getElementById('selectSpecialty').value;
            const filteredDoctors = selectedSpecialty === 'All' ? listDoctors : listDoctors.filter(doctor => doctor.specialty === selectedSpecialty);
            currentPage = 1; // Reset lại trang hiện tại về trang đầu tiên
            setupPagination(filteredDoctors, paginationElement, doctorsPerPage);
            renderDoctors(currentPage, filteredDoctors);
        }

        function changePage(page) {
            currentPage = page;
            renderDoctors(currentPage);
            setupPagination(listDoctors, document.getElementById('pagination'), doctorsPerPage);
        }

        const paginationElement = document.getElementById('pagination');
        setupPagination(listDoctors, paginationElement, doctorsPerPage);
        renderDoctors(currentPage);

        // Xu ly them moi
        const errorMessages = {
            emName: 'Tên không được để trống và không vượt quá 50 ký tự',
            emDob: 'Vui lòng nhập ngày sinh',
            emDobAge: 'Nhân viên phải trên 18 tuổi',
            emEmail: 'Email không hợp lệ',
            emPhone: 'Số điện thoại không hợp lệ',
            emAddress: 'Địa chỉ không được để trống và không vượt quá 255 ký tự',
            emSpecialty: 'Vui lòng chọn chuyên khoa '
        };

        document.getElementById('btnAddEm').addEventListener('click', function() {
            const emName = document.getElementById('emName');
            const emGender = document.getElementById('emGender');
            const emDob = document.getElementById('emDob');
            const emEmail = document.getElementById('emEmail');
            const emPhone = document.getElementById('emPhone');
            const emAddress = document.getElementById('emAddress');
            const emSpecialty = document.getElementById('emSpecialty');
            const emStatus= document.getElementById('emStatus');
            const emAvt = document.getElementById('emAvt');
            let isValid = true;

            // Xóa thông báo lỗi trước
            const errorEmName = document.getElementById('errorEmName');
            const errorEmDob = document.getElementById('errorEmDob');
            const errorEmEmail = document.getElementById('errorEmEmail');
            const errorEmPhone = document.getElementById('errorEmPhone');
            const errorEmAddress = document.getElementById('errorEmAddress');
            const errorEmSpecialty = document.getElementById('errorEmSpecialty');
            const errorEmAvt = document.getElementById('errorEmAvt');

            document.querySelectorAll('.form-control').forEach(input => {
                input.classList.remove('is-invalid');
                let errorElement;

                switch (input.id) {
                    case 'emName':
                        errorElement = errorEmName;
                        break;
                    case 'emDob':
                        errorElement = errorEmDob;
                        break;
                    case 'emEmail':
                        errorElement = errorEmEmail;
                        break;
                    case 'emPhone':
                        errorElement = errorEmPhone;
                        break;
                    case 'emAddress':
                        errorElement = errorEmAddress;
                        break;
                    case 'emSpecialty':
                        errorElement = errorEmSpecialty;
                        break;
                    case 'errorEmAvt':
                        errorElement = errorEmAvt;
                        break;
                    default:
                        console.error('Không tìm thấy phần tử lỗi cho:', input.id);
                        return; // Skip the rest of the loop if no error element is found
                }

                if (errorElement) {
                    errorElement.textContent = ''; // Xóa nội dung lỗi hiện tại
                }
            });

            // Kiểm tra tên nhân viên
            if (emName.value.trim() === '' || emName.value.length > 50) {
                document.getElementById('errorEmName').textContent = errorMessages.emName;
                emName.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra ngày sinh
            if (emDob.value.trim() === '') {
                document.getElementById('errorEmDob').textContent = errorMessages.emDob;
                emDob.classList.add('is-invalid');
                isValid = false;
            } else {
                const dob = new Date(emDob.value);
                const today = new Date();
                const age = today.getFullYear() - dob.getFullYear();
                if (age < 18 || (age === 18 && today < new Date(dob.setFullYear(today.getFullYear())))) {
                    document.getElementById('errorEmDob').textContent = errorMessages.emDobAge;
                    emDob.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Kiểm tra email
            const emailRegex = /^[a-zA-Z0-9._%+-]+@gmail.com$/;
            if (emEmail.value.trim() === '' || !emailRegex.test(emEmail.value)) {
                document.getElementById('errorEmEmail').textContent = errorMessages.emEmail;
                emEmail.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra số điện thoại
            const phoneRegex = /^(0|\+84)(3[2-9]|5[689]|7[06-9]|8[1-689]|9[0-46-9])[0-9]{7}$/;
            if (emPhone.value.trim() === '' || !phoneRegex.test(emPhone.value)) {
                document.getElementById('errorEmPhone').textContent = errorMessages.emPhone;
                emPhone.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra địa chỉ
            if (emAddress.value.trim() === '' || emAddress.value.length > 255) {
                document.getElementById('errorEmAddress').textContent = errorMessages.emAddress;
                emAddress.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra chuyên khoa làm việc
            if (emSpecialty.value === '0') {
                document.getElementById('errorEmSpecialty').textContent = errorMessages.emSpecialty;
                emSpecialty.classList.add('is-invalid');
                isValid = false;
            }

            // Kiểm tra file ảnh
            if (emAvt.files.length === 0) {
                errorEmAvt.textContent = 'Vui lòng tải lên ảnh.';
                emAvt.classList.add('is-invalid');
                isValid = false;
            } else {
                const file = emAvt.files[0];
                const fileType = file['type'];
                const validImageTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (!validImageTypes.includes(fileType)) {
                    errorEmAvt.textContent = 'Chỉ chấp nhận file ảnh (JPEG, PNG, GIF).';
                    emAvt.classList.add('is-invalid');
                    isValid = false;
                }
            }

            // Nếu tất cả thông tin hợp lệ
            if (isValid) {
                var formData = new FormData();
                formData.append('name', emName.value);
                formData.append('gender', parseInt(emGender.value, 10));
                formData.append('dob', emDob.value);
                formData.append('email', emEmail.value);
                formData.append('phone', emPhone.value);
                formData.append('address', emAddress.value);
                formData.append('position_id', 1); // Giả sử 1 là chức vụ bác sĩ
                formData.append('specialty_id', parseInt(emSpecialty.value, 10));
                formData.append('status', parseInt(emStatus.value, 10));
                formData.append('avt', emAvt.files[0]); // Thêm file vào FormData

                var file = emAvt.files[0];
                console.log('File Name: ' + file.name);
                console.log('File Size: ' + file.size + ' bytes');
                console.log('File Type: ' + file.type);
                console.log('Last Modified: ' + new Date(file.lastModified));

                $.ajax({
                    url: 'http://localhost/Medicio/index.php?controller=doctor&action=add',
                    type: 'POST',
                    data: formData,
                    contentType: false, // Không set contentType
                    processData: false, // Không xử lý dữ liệu
                    success: function(response) {
                        console.log(response);
                        $('#staticBackdrop').modal('hide');
                        location.reload();
                    },
                    error: function() {
                        alert('Có lỗi xảy ra, vui lòng thử lại.');
                    }
                });
            }
        });

        App.init();
        App.tableFilters();
    });
</script>
</body>
</html>