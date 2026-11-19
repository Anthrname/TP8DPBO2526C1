<?php
/**
 * Controller CourseController
 * Menangani alur logika bisnis untuk Mata Kuliah (Courses)
 */

require_once "models/Course.php";
require_once "models/Lecturer.php";
require_once "views/CourseView.php";
require_once "config.php";

class CourseController {
    private $course;
    private $lecturer;
    private $view;

    public function __construct() {
        $this->course = new Course(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
        $this->lecturer = new Lecturer(Config::$hostname, Config::$username, Config::$password, Config::$dbname);
        $this->view = new CourseView();
    }

    public function index() {
        $this->course->open();
        $this->lecturer->open();

        $this->course->getCourses();
        $courses = [];
        while ($row = $this->course->getResult()) {
            $courses[] = $row;
        }

        $this->lecturer->getLecturers();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }

        $this->course->close();
        $this->lecturer->close();

        $this->view->render($courses, $lecturers);
    }

    public function add($data) {
        $this->course->open();
        $this->course->addCourse($data);
        $this->course->close();

        header("Location: course.php");
        exit();
    }

    public function edit($id) {
        $this->course->open();
        $this->lecturer->open();

        // Ambil data mata kuliah yang diedit
        $this->course->getCourseById($id);
        $editData = $this->course->getResult();

        // Ambil list semua mata kuliah untuk tabel
        $this->course->getCourses();
        $courses = [];
        while ($row = $this->course->getResult()) {
            $courses[] = $row;
        }

        // Ambil list semua dosen untuk dropdown
        $this->lecturer->getLecturers();
        $lecturers = [];
        while ($row = $this->lecturer->getResult()) {
            $lecturers[] = $row;
        }

        $this->course->close();
        $this->lecturer->close();

        $this->view->render($courses, $lecturers, $editData);
    }

    public function update($id, $data) {
        $this->course->open();
        $this->course->updateCourse($id, $data);
        $this->course->close();

        header("Location: course.php");
        exit();
    }

    public function delete($id) {
        $this->course->open();
        $this->course->deleteCourse($id);
        $this->course->close();

        header("Location: course.php");
        exit();
    }
}
?>
