<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.png" rel="icon">
    <title>Danh sách lịch khám</title>
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
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Danh sách chuyên khoa</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý chuyên khoa</li>
                    <li class="breadcrumb-item active">Danh sách chuyên khoa</li>
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
                                    <button id="btnAdd" type="button" class="btn btn-success form-control"
                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Thêm mới</button>
                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                </div>
                            </div>


                            <div class="col-2 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-4 table-filters pb-0">
                                <div class="filter-container">
                                    <div class="row">
                                        <div class="col-12">
                                            <input id="searchInput" placeholder="Tìm kiếm tên chuyên khoa..."
                                                   class="form-control" autocomplete="off">
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
                                        <th style="width:20%;">Tên chuyên khoa</th>
                                        <th style="width:60%;">Mô tả</th>
                                        <th style="width:15%;">Trạng thái</th>
                                    </tr>
                                    </thead>
                                    <tbody id="tableBody" style="font-size: 15px">
                                    </tbody>
                                </table>
                                <div class="row be-datatable-footer">
                                    <div class="col-sm-9 dataTables_paginate" id="pagination"
                                         style="margin-bottom: 0px!important;"></div>
                                    <div class="col-sm-3 dataTables_info" id="sub-pagination"
                                         style="line-height: 48px"> 1 đến 5 trong số 100 </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Thêm mới chuyên khoa khám</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="specialtyName" class="form-label">Tên chuyên khoa</label>
                        <input type="text" class="form-control" id="specialtyName" placeholder="Nhập tên chuyên khoa mới">
                        <span style="margin-left: 10px; color: red" id="errorSpecialtyName"></span>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyDescription" class="form-label">Mô tả ngắn</label>
                        <textarea class="form-control" id="specialtyDescription" rows="5"></textarea>
                        <span style="margin-left: 10px; color: red" id="errorSpecialtyDesciption"></span>
                    </div>
                    <div class="mb-3">
                        <label for="specialtyStatus" class="form-label">Trạng thái</label>
                        <select id="specialtyStatus" class="form-select mb-3" aria-label="Large select example">
                            <option value="0" >Đóng</option>
                            <option value="1" selected>Mở</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Thêm mới</button>
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

        const listSpecialties = JSON.parse('<?php echo json_encode($listSpecialties); ?>');
        const itemsPerPage = 6;
        let currentPage = 1;

        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', searchSpecialty);


        function searchSpecialty() {
            const input = document.getElementById('searchInput').value.toLowerCase();
            const filteredDoctors = listSpecialties.filter(doctor => doctor.name.toLowerCase().includes(input));
            currentPage = 1;
            setupPagination(filteredDoctors, paginationElement, itemsPerPage);
            renderSpecialties(currentPage, filteredDoctors); 
        }

        function renderSpecialties(page, items = listSpecialties) {
            const start = (page - 1) * itemsPerPage;
            var end = start + itemsPerPage;
            const paginatedItems = items.slice(start, end);
            const tableBody = document.getElementById('tableBody');

            tableBody.innerHTML = '';
            paginatedItems.forEach((specialty, index) => {
                const rowNumber = start + index + 1; // Tính số thứ tự cho mỗi hàng
                const row = `<tr>
                        <td>${rowNumber}</td>
                        <td>
                            <span>${specialty.name}</span>
                        </td>
                        <td>
                            <span style='font-size: 15px; color: black'>${specialty.description ?? 'Không có mô tả'}</span>
                        </td>
                        <td class='milestone'>
                            <div>${specialty.status == 1 ? 'Đang hoạt động' : 'Đã đóng'}</div>
                        </td>
                        <td class='text-right'>
                            <div class='btn-group btn-hspace'>
                                <button class='btn btn-secondary dropdown-toggle' type='button' style='border: none; background-color: transparent;'
                                        data-toggle='dropdown'>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-three-dots-vertical" viewBox="0 0 16 16">
                                                            <path d="M3 9.5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0-5a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0zm0 10a1.5 1.5 0 1 1 3 0 1.5 1.5 0 0 1-3 0z"/>
                                                        </svg>
                                </button>
                                <div class='dropdown-menu dropdown-menu-right' role='menu'>
                                    <a class='dropdown-item '
                                       href='http://localhost/Medicio/index.php?controller=specialty&action=get_one&specialtyId=${specialty.specialty_id}'>Xem chi tiết</a>
<!--                                    <a class='dropdown-item' href='#'>Xóa</a>-->
                                </div>
                            </div>
                        </td>
                    </tr>`;
                tableBody.innerHTML += row;
            });


            const paginationInfo = document.getElementById('sub-pagination');
            if(currentPage === Math.ceil(listSpecialties.length / itemsPerPage)) {
                end = listSpecialties.length
            }
            paginationInfo.innerHTML = `${start + 1} - ${end} trong số ${items.length} chuyên khoa`;
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
                renderSpecialties(currentPage);

                document.querySelectorAll('.pagination .page-item').forEach(item => {
                    item.classList.remove('active');
                });
                li.classList.add('active');
            });

            li.appendChild(link);
            return li;
        }

        function changePage(page) {
            currentPage = page;
            renderSpecialties(currentPage);
            setupPagination(listSpecialties, document.getElementById('pagination'), itemsPerPage);
        }

        const paginationElement = document.getElementById('pagination');
        setupPagination(listSpecialties, paginationElement, itemsPerPage);
        renderSpecialties(currentPage);

        // xu ly them moi
        const specialtyName = document.getElementById('specialtyName');
        const specialtyDescription = document.getElementById('specialtyDescription');
        const specialtyStatus = document.getElementById('specialtyStatus');
        const errorSpecialtyName = document.getElementById('errorSpecialtyName');
        const errorSpecialtyDescription = document.getElementById('errorSpecialtyDesciption');

        const addButton = document.querySelector('.btn-primary'); // Nút Thêm mới
        addButton.addEventListener('click', function() {
            let valid = true;

            // Xóa thông báo lỗi cũ
            errorSpecialtyName.textContent = '';
            errorSpecialtyDescription.textContent = '';

            // Kiểm tra tên chuyên khoa
            if (!specialtyName.value || specialtyName.value.length > 150) {
                errorSpecialtyName.textContent = 'Tên chuyên khoa không được để trống và không quá 150 kí tự.';
                valid = false;
            }

            // Kiểm tra mô tả chuyên khoa
            if (!specialtyDescription.value) {
                errorSpecialtyDescription.textContent = 'Mô tả không được để trống.';
                valid = false;
            }

            // Nếu dữ liệu hợp lệ, gửi dữ liệu
            if (valid) {
                console.log('specialtyName: ', specialtyName.value);
                console.log('specialtyDescription: ', specialtyDescription.value);
                console.log('specialtyStatus: ', specialtyStatus.value);

                $.ajax({
                    url: 'http://localhost/Medicio/index.php?controller=specialty&action=add',
                    type: 'GET',
                    data: {
                        specialtyName: specialtyName.value,
                        specialtyDescription: specialtyDescription.value,
                        specialtyStatus: specialtyStatus.value
                    },
                    success: function(response) {
                        alert('Thêm mới chuyên khoa thành công!');
                        $('#staticBackdrop').modal('hide'); // Đóng modal
                        location.reload()
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