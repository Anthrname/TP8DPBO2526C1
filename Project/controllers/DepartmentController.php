<?php
/**
 * Controller DepartmentController
 * Menangani alur logika bisnis untuk Program Studi / Departemen
 */

require_once "models/Department.php";
require_once "views/DepartmentView.php";
require_once "config.php";

class DepartmentController {
    private $department;
    private $view;

    public function __construct() {
        $this->department = new Department(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
        $this->view = new DepartmentView();
    }

    public function index() {
        $this->department->open();

        $this->department->getDepartments();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }

        $this->department->close();

        $this->view->render($departments);
    }

    public function add($data) {
        $this->department->open();
        $this->department->addDepartment($data);
        $this->department->close();

        header("Location: department.php");
        exit();
    }

    public function edit($id) {
        $this->department->open();

        // Ambil data departemen yang diedit
        $this->department->getDepartmentById($id);
        $editData = $this->department->getResult();

        // Ambil list semua departemen untuk tabel
        $this->department->getDepartments();
        $departments = [];
        while ($row = $this->department->getResult()) {
            $departments[] = $row;
        }

        $this->department->close();

        $this->view->render($departments, $editData);
    }

    public function update($id, $data) {
        $this->department->open();
        $this->department->updateDepartment($id, $data);
        $this->department->close();

        header("Location: department.php");
        exit();
    }

    public function delete($id) {
        $this->department->open();
        $this->department->deleteDepartment($id);
        $this->department->close();

        header("Location: department.php");
        exit();
    }
}
?>
