<?php
/**
 * Controller LecturerController
 * Menangani alur logika bisnis untuk entitas Lecturer (Dosen)
 */

require_once "models/Lecturer.php";
require_once "models/Department.php";
require_once "views/LecturerView.php";
require_once "config.php";

class LecturerController {
    private $lecturer;
    private $department;
    private $view;

    public function __construct() {
        $this->lecturer = new Lecturer(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
        $this->department = new Department(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
        $this->view = new LecturerView();
    }

    public function index() {
        $this->lecturer->open();
        $this->department->open();

        $this->lecturer->getLecturers();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }

        $this->department->getDepartments();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }

        $this->lecturer->close();
        $this->department->close();

        $this->view->render($lecturers, $departments);
    }

    public function add($data) {
        $this->lecturer->open();
        $this->lecturer->addLecturer($data);
        $this->lecturer->close();

        header("Location: index.php");
        exit();
    }

    public function edit($id) {
        $this->lecturer->open();
        $this->department->open();

        // Ambil data dosen yang akan diedit
        $this->lecturer->getLecturerById($id);
        $editData = $this->lecturer->getResult();

        // Ambil seluruh data dosen untuk tabel
        $this->lecturer->getLecturers();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }

        // Ambil seluruh data jurusan untuk dropdown
        $this->department->getDepartments();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }

        $this->lecturer->close();
        $this->department->close();

        $this->view->render($lecturers, $departments, $editData);
    }

    public function update($id, $data) {
        $this->lecturer->open();
        $this->lecturer->updateLecturer($id, $data);
        $this->lecturer->close();

        header("Location: index.php");
        exit();
    }

    public function delete($id) {
        $this->lecturer->open();
        $this->lecturer->deleteLecturer($id);
        $this->lecturer->close();

        header("Location: index.php");
        exit();
    }
}
?>
