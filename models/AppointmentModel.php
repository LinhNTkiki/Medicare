<?php
require_once __DIR__ . '/../core/Database.php';
require 'utils/convertDate.php';

class AppointmentModel extends Database {
    protected $connection = null;

    public function __construct() {
        $this->connection = $this->connect();
    }

    private function _query($sql): mysqli_result|bool
    {
        return mysqli_query($this->connection, $sql);
    }

    public function updateAppointment($id, $employee_id, $specialty_id, $date_slot, $time_id, $patient_name, $patient_gender, $patient_email, $patient_description, $status): bool {

        if ($id === null) {
            return false;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $updatedAt = date('Y-m-d H:i:s');

        $sql = "UPDATE appointments SET 
            date_slot = ?,
            employee_id = ?,
            patient_description = ?,
            patient_email = ?,
            patient_gender = ?,
            patient_name = ?,
            specialty_id = ?,
            status = ?,
            time_id = ?,
            update_at = ?
        WHERE appointment_id = ?";

        // Chuẩn bị và thực thi truy vấn
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param('iissisiiisi',
                $date_slot,
                $employee_id,
                $patient_description,
                $patient_email,
                $patient_gender,
                $patient_name,
                $specialty_id,
                $status,
                $time_id,
                $updatedAt,
                $id
            );
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi
            error_log('Lỗi cập nhật cuộc hẹn: ' . $e->getMessage());
            return false;
        }
    }

    public function updateResultAppointment($id, $result): bool {

        if ($id === null) {
            return false;
        }

        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $updatedAt = date('Y-m-d H:i:s');

        $sql = "UPDATE appointments SET
                    result = ?,
                    update_at = ?
                WHERE appointment_id = ?";

        // Chuẩn bị và thực thi truy vấn
        try {
            $stmt = $this->connection->prepare($sql);
            $stmt->bind_param('ssi',$result,$updatedAt, $id);
            $stmt->execute();

            if ($stmt->affected_rows > 0) {
                return true;
            }
            return false;
        } catch (mysqli_sql_exception $e) {
            // Xử lý lỗi
            error_log('Lỗi cập nhật kết quả: ' . $e->getMessage());
            return false;
        }
    }

    public function getAppointmentById($appointmentId = null): array
    {
        $sql = "SELECT a.appointment_id AS id,
                       e.name AS doctor_name,
                       e.employee_id AS employee_id,
                       a.patient_name AS patient_name,
                       a.patient_dob AS patient_dob,
                       a.patient_gender AS patient_gender,
                       a.patient_phone AS patient_phone,
                       a.patient_email AS patient_email,
                       a.patient_description AS patient_description,
                       s.name AS specialty_name,
                       s.specialty_id AS specialty_id,
                       a.date_slot AS date_slot,
                       ts.slot_time AS time_slot,
                       ts.time_id AS time_id,
                       a.result AS result,
                       a.status AS status
                FROM appointments AS a
                         JOIN employees AS e ON e.employee_id = a.employee_id
                         JOIN time_slots AS ts ON ts.time_id = a.time_id
                         JOIN specialties AS s ON s.specialty_id = a.specialty_id
                WHERE a.appointment_id = " . $appointmentId;

        $query = $this->_query($sql);
        return mysqli_fetch_assoc($query);
    }

    public function getAppointmentConfirm($limit = 10, $page = 1, $specialty = null, $doctor = null, $search = null): array
    {

        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor') AND a.status =  0 ";
        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.date_slot, ts.slot_time ASC LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getTotalAppointmentsConfirm($specialty = null, $doctor = null, $search = null) {
        $sql = "SELECT COUNT(*) AS total 
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor') AND a.status =  0";

        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getAppointmentToday($limit = 10, $page = 1, $specialty = null, $doctor = null, $date = null, $search = null): array
    {
        $converter = new ConvertDate();

        $offset = ($page - 1) * $limit;
        $today = date('d/m/Y');
        $date = $converter->convertDateToDayTimestamp($today);

        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor') AND a.status =  1 AND a.date_slot = " . $date;

        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY ts.slot_time, a.date_slot LIMIT $limit OFFSET $offset";

        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getAllAppointmentsForAdmin($limit = 10, $page = 1, $specialty = null, $doctor = null, $statusAppointment = null, $search = null): array {
        $offset = ($page - 1) * $limit;
        $sql = "SELECT a.appointment_id AS id, 
                    e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   a.patient_name AS patient_name,
                   a.patient_dob AS patient_dob,
                   a.patient_gender AS patient_gender,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   s.name AS specialty_name,
                   a.date_slot AS date_slot,
                   ts.slot_time AS time_slot,
                   a.status AS status
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor')";

        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }
        if (isset($statusAppointment) && $statusAppointment !== '') {
            $statusArray = explode(',', $statusAppointment);
            $statusArray = array_filter($statusArray, function($value) {
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            });

            if (count($statusArray) > 0) {
                $statusList = implode("','", $statusArray);
                $sql .= " AND a.status IN ('$statusList')";
            }
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY a.created_at DESC LIMIT $limit OFFSET $offset";
        error_log("Giá trị của biến: " . $sql);
        $query = $this->_query($sql);
        $data = [];
        while ($result = mysqli_fetch_assoc($query)) {
            $data[] = $result;
        }
        return $data;
    }

    public function getTotalAppointmentsToday($specialty = null, $doctor = null, $date = null, $search = null)
    {
        $converter = new ConvertDate();

        $today = date('d/m/Y');
        $date = $converter->convertDateToDayTimestamp($today);

        $sql = "SELECT COUNT(*) AS total
            FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor') AND a.status =  1 AND a.date_slot = " . $date;

        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }

        $sql .= " ORDER BY ts.slot_time, a.date_slot";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointments() {
        $sql = "SELECT COUNT(*) AS total FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            WHERE r.role_name = LOWER('doctor')";

        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function getTotalAppointmentsWithParam($specialty = null, $doctor = null, $statusAppointment = null, $search = null) {
        $sql = "SELECT COUNT(*) AS total FROM appointments AS a
            JOIN employees AS e ON e.employee_id = a.employee_id
            JOIN roles AS r ON r.role_id = e.role_id
            JOIN time_slots AS ts ON ts.time_id = a.time_id
            JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE r.role_name = LOWER('doctor')";

        if ($specialty) {
            $sql .= " AND s.specialty_id = " . $specialty;
        }
        if ($doctor) {
            $sql .= " AND e.employee_id = " . $doctor;
        }

        if (isset($statusAppointment) && $statusAppointment !== '') {
            // Chuyển đổi chuỗi thành mảng
            $statusArray = explode(',', $statusAppointment);

            // Lọc và xác thực mỗi giá trị trong mảng
            $statusArray = array_filter($statusArray, function($value) {
                return filter_var($value, FILTER_VALIDATE_INT) !== false;
            });

            if (count($statusArray) > 0) {
                // Sử dụng implode() để tạo chuỗi cho câu lệnh SQL
                $statusList = implode("','", $statusArray);
                $sql .= " AND a.status IN ('$statusList')";
            }
        }

        if ($search) {
            // SQL injection
            $sql .= " AND (a.patient_name LIKE '%$search%' OR a.patient_phone LIKE '%$search%')";
        }
        $query = $this->_query($sql);
        $result = mysqli_fetch_assoc($query);
        return $result['total'];
    }

    public function createAppointment($specialId, $doctorId, $dateSlot, $timeSlotId, $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription): int|string {
        // Đặt múi giờ sang "Asia/Ho_Chi_Minh" để đảm bảo thời gian chính xác theo giờ Việt Nam
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        // Lấy thời gian hiện tại
        $createdAt = date('Y-m-d H:i:s');

        $sql = "INSERT INTO appointments (
                specialty_id, employee_id, date_slot, time_id,
                patient_name, patient_gender, patient_dob, patient_phone, patient_email, patient_description,
                status, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->connection->prepare($sql);
        if (!$stmt) {
            throw new Exception("Prepare failed: " . $this->connection->error);
        }

        // Thêm trạng thái và ngày tạo vào bind_param
        $status = 0;  // Giả sử trạng thái mặc định là 0
        $stmt->bind_param("iiiissssssis", $specialId, $doctorId, $dateSlot, $timeSlotId,
            $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription,
            $status, $createdAt);

        $stmt->execute();
        if ($stmt->error) {
            throw new Exception("Execute failed: " . $stmt->error);
        }
        return $stmt->insert_id; // Trả về ID của bản ghi mới được chèn
    }

    public function getAppointmentsByPhone($phone = null): array
    {
        $sql = "SELECT a.appointment_id AS id,
                   a.status AS status,
                   a.result AS result,
                   a.patient_name AS patient_name,
                   a.patient_phone AS patient_phone,
                   a.patient_email AS patient_email,
                   a.date_slot AS date_slot,
                   e.name AS doctor_name,
                   e.avt AS doctor_avt,
                   s.name AS specialty_name,
                   ts.slot_time AS time_slot
            FROM appointments AS a
                     JOIN employees AS e ON e.employee_id = a.employee_id
                     JOIN time_slots AS ts ON ts.time_id = a.time_id
                     JOIN specialties AS s ON s.specialty_id = a.specialty_id
            WHERE a.patient_phone = ?
            ORDER BY a.date_slot ASC";

        if ($stmt = $this->connection->prepare($sql)) {
            $stmt->bind_param("s", $phone);
            $stmt->execute();
            $result = $stmt->get_result();
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            $stmt->close();
            return $data;
        } else {
            return [];
        }
    }
}