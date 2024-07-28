<?php
function getNavigationLinks($role) {
    $links = [
        'student' => [
            'View Internships' => 'view_internships.php',
            'My Applications' => 'my_applications.php',
            'Upload CV' => 'upload_cv.php'
        ],
        'company' => [
            'Add Internship' => 'add_internship.php',
            'View Applications' => 'view_applications.php',
            'Manage Internships' => 'manage_internships.php'
        ],
        'supervisor' => [
            'View Students' => 'view_students.php',
            'View Companies' => 'view_companies.php'
        ],
        'admin' => [
            'Manage Users' => 'manage_users.php',
            'Assign Supervisors' => 'assign_supervisors.php'
        ]
    ];
    return $links[$role];
}
?>