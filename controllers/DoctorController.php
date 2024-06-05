<?php
class DoctorController extends BaseController {
    private $doctorModel;
    private $specialtyModel;
    private $positionModel;

    public function __construct()
    {
        $this->loadModel('DoctorModel');
        $this->doctorModel = new DoctorModel();

        $this->loadModel('SpecialtyModel');
        $this->specialtyModel = new SpecialtyModel();

        $this->loadModel('PositionModel');
        $this->positionModel = new PositionModel();
    }

    public function index()
    {
        $listDoctors = $this->doctorModel->getDoctorForAdmin();
        $listSpecialties = $this->specialtyModel->getSpecialtiesForAppointment();
        return $this->view('admin.doctors', [
            'listDoctors' => $listDoctors,
            'listSpecialties' => $listSpecialties,
        ]);
    }

    public function detail()
    {
        $doctor_id = $_GET['doctor_id'] ?? '';
        $doctor = $this->doctorModel->getById($doctor_id);
//        $listPositions = $this->positionModel->getAll();
        $listSpecialties = $this->specialtyModel->getSpecialtiesForAppointment();
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($doctor);
            exit;
        }
        return $this->view('admin.employee-detail', [
            'doctor' => $doctor,
//            'listPositions' => $listPositions,
            'listSpecialties' => $listSpecialties,
        ]);
    }
    public function update()
    {
        $doctor_id = $_POST['id'];
        $specialty_id = $_POST['specialty_id'];
        $name = $_POST['name'];
        $phone  = $_POST['phone'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address  = $_POST['address'];
        $status  = $_POST['status'];

        // Xử lý upload ảnh đại diện
        if (isset($_FILES['avtUpdate']) && $_FILES['avtUpdate']['error'] == 0) {
            $avt = $this->uploadImageToCloudinary($this->escapeBackslashes($_FILES['avtUpdate']['tmp_name']));
        } else {
            $avt = $_POST['avt'];
        }

        $result = $this->doctorModel->updateDoctor($doctor_id, $name, $dob, $email, $phone, $gender, $address, $specialty_id, $status, $avt);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
        return $this->view('admin.employee-detail', [
            'result' => $result,
        ]);
    }


    public function add()
    {
        $specialty_id = $_POST['specialty_id'];
        $position_id = $_POST['position_id'];
        $name = $_POST['name'];
        $phone  = $_POST['phone'];
        $email = $_POST['email'];
        $dob = $_POST['dob'];
        $gender = $_POST['gender'];
        $address  = $_POST['address'];
        $status  = $_POST['status'];

        // Xử lý upload ảnh đại diện
        if (isset($_FILES['avt']) && $_FILES['avt']['error'] == 0) {
            $avt = $this->uploadImageToCloudinary($this->escapeBackslashes($_FILES['avt']['tmp_name']));
        } else {
            $avt = 'looi'; // Hoặc đặt một URL ảnh mặc định nếu cần
        }

        $result = $this->doctorModel->addDoctor($name, $dob, $email, $phone, $gender, $address, $specialty_id, $position_id, $status, $avt);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($result);
            exit;
        }
        return $this->view('test', [
            'result' => $result,
        ]);
    }

    public function uploadImageToCloudinary($imagePath): string
    {
        try {
            // Truy cập đối tượng Cloudinary từ biến toàn cục
            $cloudinary = $GLOBALS['cloudinary'];

            // Upload ảnh lên Cloudinary sử dụng đối tượng Cloudinary
            $result = $cloudinary->uploadApi()->upload($imagePath);

            // Trả về URL an toàn của ảnh đã upload
            return $result['secure_url'];
        } catch (Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    private function escapeBackslashes($string): array|string
    {
        return str_replace("\\", "\\\\", $string);
    }

    public function test()
    {
        // Đường dẫn file cần được escape ký tự \
        $test = 'C:\Users\anhvt\OneDrive\Hình ảnh\Ảnh chụp màn hình\11.png';

        // Gọi phương thức uploadImageToCloudinary bằng $this-> để chỉ định rằng đó là phương thức của class hiện tại
        $uploadedImageUrl = $this->uploadImageToCloudinary($test);

        // Truyền kết quả vào view
        return $this->view('test', [
            'test' => $uploadedImageUrl,
        ]);
    }
}
