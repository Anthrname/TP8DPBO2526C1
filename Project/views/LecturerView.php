<?php
/**
 * View LecturerView
 * Menangani rendering tampilan Dosen menggunakan Template engine
 */

require_once "Template.php";

class LecturerView {
    public function render($lecturers, $departments, $editData = null) {
        $template = new Template("templates/lecturer.html");

        $template->replace("DATA_PAGE_TITLE", "Data Dosen");
        $template->replace("DATA_NAV_LECTURER", "active fw-bold text-white");
        $template->replace("DATA_NAV_DEPARTMENT", "");
        $template->replace("DATA_NAV_COURSE", "");

        // Menentukan mode Form (Tambah / Edit)
        if ($editData != null) {
            $template->replace("DATA_FORM_TITLE", "Edit Data Dosen");
            $template->replace("DATA_FORM_ACTION", "index.php");
            $template->replace("DATA_FORM_INPUT_ID", '<input type="hidden" name="id" value="' . htmlspecialchars($editData['id']) . '">');
            $template->replace("DATA_NAME_VALUE", htmlspecialchars($editData['name']));
            $template->replace("DATA_NIDN_VALUE", htmlspecialchars($editData['nidn']));
            $template->replace("DATA_PHONE_VALUE", htmlspecialchars($editData['phone']));
            $template->replace("DATA_JOIN_DATE_VALUE", htmlspecialchars($editData['join_date']));
            $template->replace("DATA_BUTTON_NAME", "update");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-save me-1"></i> Simpan Perubahan');
            $template->replace("DATA_BUTTON_CANCEL", '<a href="index.php" class="btn btn-outline-secondary">Batal Edit</a>');
            $selectedDept = $editData['department_id'];
        } else {
            $template->replace("DATA_FORM_TITLE", "Tambah Dosen Baru");
            $template->replace("DATA_FORM_ACTION", "index.php");
            $template->replace("DATA_FORM_INPUT_ID", "");
            $template->replace("DATA_NAME_VALUE", "");
            $template->replace("DATA_NIDN_VALUE", "");
            $template->replace("DATA_PHONE_VALUE", "");
            $template->replace("DATA_JOIN_DATE_VALUE", "");
            $template->replace("DATA_BUTTON_NAME", "add");
            $template->replace("DATA_BUTTON_TEXT", '<i class="bi bi-plus-circle me-1"></i> Tambah Dosen');
            $template->replace("DATA_BUTTON_CANCEL", "");
            $selectedDept = null;
        }

        // Render Options Department
        $deptOptions = "";
        foreach ($departments as $dept) {
            $isSelected = ($selectedDept !== null && $selectedDept == $dept['id']) ? "selected" : "";
            $deptOptions .= '<option value="' . $dept['id'] . '" ' . $isSelected . '>' . htmlspecialchars($dept['name']) . ' (' . htmlspecialchars($dept['faculty']) . ')</option>' . "\n";
        }
        $template->replace("DATA_DEPARTMENT_OPTIONS", $deptOptions);

        // Render Baris Tabel Dosen
        $tableContent = "";
        $count = 0;
        foreach ($lecturers as $row) {
            $count++;
            $deptBadge = !empty($row['department_name']) 
                ? '<span class="badge-dept"><i class="bi bi-tag-fill me-1"></i>' . htmlspecialchars($row['department_name']) . '</span>'
                : '<span class="text-muted fst-italic">Belum Ditentukan</span>';

            $formattedDate = date('d M Y', strtotime($row['join_date']));

            $tableContent .= '<tr>
                <td class="text-center fw-bold">' . $row['id'] . '</td>
                <td><span class="fw-bold text-dark">' . htmlspecialchars($row['name']) . '</span></td>
                <td><code class="fw-semibold">' . htmlspecialchars($row['nidn']) . '</code></td>
                <td>' . htmlspecialchars($row['phone']) . '</td>
                <td>' . $formattedDate . '</td>
                <td>' . $deptBadge . '</td>
                <td class="text-center">
                    <a href="index.php?action=edit&id=' . $row['id'] . '" class="btn btn-warning btn-action text-dark me-1" title="Edit">
                        <i class="bi bi-pencil-square"></i> Edit
                    </a>
                    <a href="index.php?action=delete&id=' . $row['id'] . '" class="btn btn-danger btn-action" onclick="return confirm(\'Apakah Anda yakin ingin menghapus dosen ini?\')" title="Hapus">
                        <i class="bi bi-trash-fill"></i> Hapus
                    </a>
                </td>
            </tr>' . "\n";
        }

        if ($count === 0) {
            $tableContent = '<tr><td colspan="7" class="text-center text-muted py-4">Belum ada data dosen tersimpan.</td></tr>';
        }

        $template->replace("DATA_TOTAL_COUNT", $count);
        $template->replace("DATA_TABLE_CONTENT", $tableContent);

        $template->write();
    }
}
?>
