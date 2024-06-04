<?php
require_once 'BaseController.php';
class AppointmentController extends BaseController
{
    private $timeSlotModel;
    private $appointmentModel;
    private $doctorModel;
    private $specialtyModel;

    public function __construct()
    {
        $this->loadModel('TimeSlotModel');
        $this->timeSlotModel = new TimeSlotModel();

        $this->loadModel('AppointmentModel');
        $this->appointmentModel = new AppointmentModel();

        $this->loadModel('DoctorModel');
        $this->doctorModel = new DoctorModel();

        $this->loadModel('SpecialtyModel');
        $this->specialtyModel = new SpecialtyModel();
    }

    public function getByDateAndDoctor()
    {
        $date_slot = isset($_GET['dateSlot']) ? $_GET['dateSlot'] : null;
        $doctorId = isset($_GET['doctorId']) ? $_GET['doctorId'] : null;
        $listTimeSlot = $this->timeSlotModel->getByDateAndDoctor($date_slot, $doctorId);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($listTimeSlot);
            exit;
        } else {
            return $this->view('test', [
                'listTimeSlot' => $listTimeSlot
            ]);
        }
    }

    public function create(){
        $specialId = intval($_POST['specialId']);
        $doctorId = intval($_POST['doctorId']);
        $dateSlot = intval($_POST['dateSlot']);
        $timeSlotId = intval($_POST['timeSlotId']);
        $patientName = $_POST['patientName'];
        $patientGender = intval($_POST['patientGender']);
        $patientDob = $_POST['patientDob'];
        $patientPhone = $_POST['patientPhone'];
        $patientEmail = $_POST['patientEmail'];
        $patientDescription = $_POST['patientDescription'];
        $appointment = $this->appointmentModel->createAppointment(
            $specialId, $doctorId, $dateSlot, $timeSlotId,
            $patientName, $patientGender, $patientDob, $patientPhone, $patientEmail, $patientDescription);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($appointment);
            exit;
        } else {
            return $this->view('test', [
                'message' => $appointment
            ]);
        }
    }

    public function update()
    {
//        Truyen mang bị loi, ko fix duoc
//        $data = json_decode(file_get_contents("php://input"), true);
//        $appointmentUpdated = $data['appointmentUpdated'];
        $id = $_POST['id'];
        $employee_id = $_POST['employee_id'];
        $specialty_id = $_POST['specialty_id'];
        $date_slot = $_POST['date_slot'];
        $time_id = $_POST['time_id'];
        $patient_name = $_POST['patient_name'];
        $patient_gender = $_POST['patient_gender'];
        $patient_email = $_POST['patient_email'];
        $patient_description = $_POST['patient_description'];
        $status = $_POST['status'];



        $update = $this->appointmentModel->updateAppointment($id, $employee_id, $specialty_id, $date_slot, $time_id,
            $patient_name, $patient_gender, $patient_email, $patient_description, $status);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($update);
            exit;
        } else {
            return $this->view('test', [
                'message' => $update
            ]);
        }

    }

    public function homeAdmin(){
        $page = $_GET['page'] ?? 1;

        $listSpecialties = $this->specialtyModel->getSpecialtiesForAdmin();
        $listDoctors = $this->doctorModel->getDoctorForAdmin();

        $totalAppointment = $this->appointmentModel->getTotalAppointments();
        $listAppointments = $this->appointmentModel->getAllAppointmentsForAdmin(10, $page);

        $specialty= $_GET['specialty'] ?? null;
        $doctor = $_GET['doctor'] ?? null;
        $search = $_GET['search'] ?? null;
        $statusAppointment = $_GET['statusAppointment'] ?? null;

        if($specialty || $doctor || $search || (isset($statusAppointment) && $statusAppointment !== '')) {
            $listAppointments = $this->appointmentModel->getAllAppointmentsForAdmin(10, $page, $specialty, $doctor, $statusAppointment, $search);
            $totalAppointment = $this->appointmentModel->getTotalAppointmentsWithParam($specialty, $doctor, $statusAppointment,$search);
        }

        return $this->view('admin.appointments', [
            'listAppointments' => $listAppointments,
            'listSpecialties' => $listSpecialties,
            'listDoctors' => $listDoctors,
            'totalAppointment' => $totalAppointment,
            'specialtySelected' => $specialty,
            'doctorSelected' => $doctor,
            'statusAppointment' => $statusAppointment,
            'search' => $search,
//            co the bo cac bien, vi lay $_GET
        ]);
    }

    public function today(){
        $page = $_GET['page'] ?? 1;

        $listSpecialties = $this->specialtyModel->getSpecialtiesForAdmin();
        $listDoctors = $this->doctorModel->getDoctorForAdmin();



        $specialty= $_GET['specialty'] ?? null;
        $doctor = $_GET['doctor'] ?? null;
        $date = $_GET['date'] ?? null;
        $search = $_GET['search'] ?? null;


        $listAppointments = $this->appointmentModel->getAppointmentToday(10, $page, $specialty, $doctor,$date, $search);
        $totalAppointment = $this->appointmentModel->getTotalAppointmentsToday($specialty, $doctor, $date ,$search);

        return $this->view('admin.appointment-today', [
            'listAppointments' => $listAppointments,
            'listSpecialties' => $listSpecialties,
            'listDoctors' => $listDoctors,
            'totalAppointment' => $totalAppointment,
            'specialtySelected' => $specialty,
            'doctorSelected' => $doctor,
            'search' => $search,
//            co the bo cac bien, vi lay $_GET
        ]);
    }

    public function confirm(){
        $page = $_GET['page'] ?? 1;

        $listSpecialties = $this->specialtyModel->getSpecialtiesForAdmin();
        $listDoctors = $this->doctorModel->getDoctorForAdmin();

        $specialty= $_GET['specialty'] ?? null;
        $doctor = $_GET['doctor'] ?? null;
        $search = $_GET['search'] ?? null;

        $listAppointments = $this->appointmentModel->getAppointmentConfirm(10, $page, $specialty, $doctor, $search);
        $totalAppointment = $this->appointmentModel->getTotalAppointmentsConfirm($specialty, $doctor, $search);

        return $this->view('admin.appointment-confirm', [
            'listAppointments' => $listAppointments,
            'listSpecialties' => $listSpecialties,
            'listDoctors' => $listDoctors,
            'totalAppointment' => $totalAppointment,
            'specialtySelected' => $specialty,
            'doctorSelected' => $doctor,
            'search' => $search,
//            co the bo cac bien, vi lay $_GET
        ]);
    }
    public function get_one(){
        $appointmentId = $_GET['appointmentId'] ?? null;

        $appointment = $this->appointmentModel->getAppointmentById($appointmentId);
        if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            header('Content-Type: application/json');
            echo json_encode($appointment);
            exit;
        }
        return $this->view('admin.appointment-confirm', [
            'appointment' => $appointment,
        ]);
    }

    public function test()
    {
        $converter = new ConvertDate();
        $today = date('d/m/Y');
        $date = $converter->convertDateToDayTimestamp($today);

        $this->view('test', [
            'date' => $date,
            'today'=> $today
        ]);
    }
}