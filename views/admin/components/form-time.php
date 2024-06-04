<style>
    #format-btn-date {
        padding : 0 !important;
        margin : 0 0 10px 0 !important;
        float: left;
    }

    .btn-select-day {
        height: 50px !important;
        width: 100px !important;
        text-align: center;
        margin: 0!important;
    }
</style>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<div class="col-6">
    <h5 class="mb-4 mt-0">Chọn thông tin khám bệnh</h5>
    <div class="row">
        <div class="mb-3 col-sm-11">
            <?php include "select-specialty.php" ?>
            <input type="text" hidden="hidden" id="selected-specialty"/>
        </div>
        <div class="mb-3 col-sm-11">
            <?php include "select-doctor.php" ?>
            <input type="text" hidden="hidden" id="selected-doctor"/>
        </div>
    </div>
</div>
<div class="col-6">
    <h5 class="mt-0">Ngày khám <strong id="date_selected"></strong></h5>
    <div class="row">
        <div class="btn-select-day col-10" id="otherDay" style="margin-left: 12px!important;" onclick="selectDateSlot(this)">
            <div class="input-group">
                <input type="date" class="form-control" id="input-otherDate" placeholder="Chọn ngày khác" autocomplete="off">
            </div>
            <input type="text" id="date-slot" hidden="hidden">
        </div>
    </div>
    <span id="error-date" class="ml-2" style="color: red;"></span>
</div>
<div class="row">
    <p>Giờ khám (*)</p>
    <div class="col-12" id="display-time-slot">
    </div>
    <input type="text" id="time-slot" hidden="hidden">
    <span id="error-time" class="ml-2" style="color: red;"></span>
</div>