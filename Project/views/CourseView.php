<?php
/**
 * View CourseView
 * Menangani rendering tampilan Mata Kuliah (Courses)
 */

require_once "Template.php";

class CourseView {
    public function render($courses, $lecturers, $editData = null) {
        $template = new Template("templates/course.html");

        $template->replace("DATA_PAGE_TITLE", "Data Mata Kuliah");
        $template->replace("DATA_NAV_LECTURER", "");
        $template->replace("DATA_NAV_DEPARTMENT", "");
        $template->replace("DATA_NAV_COURSE", "active fw-bold text-white");

        // Menentukan mode Form (Tambah / Edit)
        if ($editData != null) {
            $template->replace("DATA_FORM_TITLE", "Edit Mata Kuliah");
            $template->replace("DATA_FORM_ACTION", "course.php");
            $template->replace("DATA_FORM_INPUT_ID", '<input type="hidden" name="id" value="' . htmlspecialchars($editData['id']) . '">');
            $template->replace("DATA_CODE_VALUE", htmlspecialchars($editData['code']));
            $template->replace("DATA_NAME_VALUE", htmlspecialchars($editData['name']));
            $template->replace("DATA_CREDITS_VALUE", htmlspecialchars($editData['credits']));
            $template->replace("DATA_SEMESTER_VALUE", htmlspecialchars($editData['semester']));
            $template->replace("DATA_BUTTON_NAME", "update");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-save me-1"></i> Simpan Perubahan');
            $template->replace("DATA_BUTTON_CANCEL", '<a href="course.php" class="btn btn-outline-secondary">Batal Edit</a>');
            $selectedLecturer = $editData['lecturer_id'];
        } else {
            $template->replace("DATA_FORM_TITLE", "Tambah Mata Kuliah");
            $template->replace("DATA_FORM_ACTION", "course.php");
            $template->replace("DATA_FORM_INPUT_ID", "");
            $template->replace("DATA_CODE_VALUE", "");
            $template->replace("DATA_NAME_VALUE", "");
            $template->replace("DATA_CREDITS_VALUE", "3");
            $template->replace("DATA_SEMESTER_VALUE", "1");
            $template->replace("DATA_BUTTON_NAME", "add");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-plus-circle me-1"></i> Tambah Mata Kuliah');
            $template->replace("DATA_BUTTON_CANCEL", "");
            $selectedLecturer = null;
        }

        // Render Options Lecturer
        $lectOptions = "";
        foreach ($lecturers as $lect) {
            $isSelected = ($selectedLecturer !== null && $selectedLecturer == $lect['id']) ? "selected" : "";
            $deptInfo = !empty($lect['department_name']) ? " (" . $lect['department_name'] . ")" : "";
            $lectOptions .= '<option value="' . $lect['id'] . '" ' . $isSelected . '>' . htmlspecialchars($lect['name']) . $deptInfo . '</option>' . "\n";
        }
        $template->replace("DATA_LECTURER_OPTIONS", $lectOptions);

        // Render Baris Tabel Mata Kuliah
        $tableContent = "";
        $count = 0;
        foreach ($courses as $row) {
            $count++;
            $lecturerBadge = !empty($row['lecturer_name']) 
                ? '<span class="fw-semibold text-dark"><i class="bi bi-person-badge me-1"></i>' . htmlspecialchars($row['lecturer_name']) . '</span>'
                : '<span class="text-muted fst-italic">Belum Ditentukan</span>';

            $tableContent .= '<tr>
                <td class="text-center fw-bold">' . $row['id'] . '</td>
                <td><span class="badge-dept fw-bold">' . htmlspecialchars($row['code']) . '</span></td>
                <td><span class="fw-bold text-dark">' . htmlspecialchars($row['name']) . '</span></td>
                <td class="text-center"><span class="badge bg-primary">' . $row['credits'] . ' SKS</span></td>
                <td class="text-center"><span class="badge bg-secondary">Sem ' . $row['semester'] . '</span></td>
                <td>' . $lecturerBadge . '</td>
                <td class="text-center">
                    <a href="course.php?action=edit&id=' . $row['id'] . '" class="btn btn-warning btn-action text-dark me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="course.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger btn-action" onclick="return confirm(\'Apakah Anda yakin ingin menghapus mata kuliah ini?\')" title="Hapus">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </a>
                </td>
            </tr>' . "\n";
        }

        if ($count === 0) {
            $tableContent = '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data mata kuliah tersimpan.</td></tr>';
        }

        $template->replace("DATA_TOTAL_COUNT", $count);
        $template->replace("DATA_TABLE_CONTENT", $tableContent);

        $template->write();
    }
}
?>
