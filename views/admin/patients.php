<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="assets/img/logo.png" rel="icon">
    <title>Danh sách bệnh nhân</title>
    <?php include 'import-link-tag.php' ?>
</head>
<body>
<div class="be-wrapper">
    <!--    Navbar-->
    <?php include 'navbar.php' ?>
    <!--    left sidebar-->
    <?php include 'sidebar.php' ?>
    <div class="be-content">
        <div class="page-head">
            <h2 class="page-head-title" style="font-size: 25px">Danh sách bệnh nhân</h2>
            <nav aria-label="breadcrumb" role="navigation">
                <ol class="breadcrumb page-head-nav">
                    <li class="breadcrumb-item"><a href="index.php">Trang chủ</a></li>
                    <li class="breadcrumb-item">Quán lý bệnh nhân</li>
                    <li class="breadcrumb-item active">Danh sách bệnh nhân</li>
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
<!--                                    <button id="btnAdd" type="button" class="btn btn-success form-control"-->
<!--                                            data-bs-toggle="modal" data-bs-target="#staticBackdrop">Thêm mới</button>-->
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
                                            <input id="searchInput" placeholder="Nhập tên bệnh nhân..."
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
                                        <th style="width:10%;">Tên bệnh nhân</th>
                                        <th style="width:7%;">Tên tài khoản</th>
                                        <th style="width:7%;">Thông tin</th>
                                        <th style="width:10%;">Liên hệ</th>
                                        <th style="width:15%;">Địa chỉ</th>
                                        <th style="width:10%;"></th>
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
    <!--    pop-up sidebar-->
    <?php include 'pop-up-sidebar.php' ?>
</div>
<?php include 'import-script.php' ?>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        const listSpecialties = JSON.parse('<?php echo json_encode($listPatients); ?>');
        const itemsPerPage = 5;
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
            paginatedItems.forEach((patient, index) => {
                const rowNumber = start + index + 1; // Tính số thứ tự cho mỗi hàng
                const row = `<tr>
                    <td>${rowNumber}</td>
                    <td>
                        <span>${patient.name}</span>
                    </td>
                    <td>
                        <span style='font-size: 13px; color: black'>${patient.username}</span>
                    </td>
                    <td class='milestone'>
                        <span class='version'>${patient.dob}</span>
                        <div>${patient.gender == 1 ? 'Nam' : 'Nữ'}</div>
                    </td>
                    <td class='milestone'>
                        <span class='version'>${patient.email}</span>
                        <div>${patient.phone}</div>
                    </td>
                    <td class='cell-detail'>
                    <span style='font-size: 13px; color: black'>${patient.address}</span>
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
                                <a href="http://localhost/Medicio/index.php?controller=patient&action=detail&patient_id=${patient.patient_id}"
                                   type='button' class='dropdown-item'>Xem chi tiết</a>
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

        App.init();
        App.tableFilters();
    });
</script>
</body>
</html>