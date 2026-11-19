<?php
/**
 * Entry Point: Mata Kuliah (Courses)
 * Menghubungkan HTTP Request dengan CourseController
 */

require_once "controllers/CourseController.php";

$courseController = new CourseController();

if (isset($_POST['add'])) {
    $courseController->add($_POST);
} else if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $courseController->update($id, $_POST);
} else if (isset($_GET['action'])) {
    $action = $_GET['action'];
    $id = $_GET['id'] ?? null;

    if ($action == 'edit' && $id) {
        $courseController->edit($id);
    } else if ($action == 'delete' && $id) {
        $courseController->delete($id);
    } else {
        $courseController->index();
    }
} else {
    $courseController->index();
}
?>
