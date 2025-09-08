<?php
session_start();
include 'db_connect.php';
$login_error = '';
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Prepare and execute query
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password'])) {

            // Normalize role
            $role = ucfirst(strtolower(trim($user['role'])));

            // Set session variables
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $role;
            $_SESSION['nic'] = $user['nic'];
            $_SESSION['phone'] = $user['phone'];
            $_SESSION['profile_pic'] = $user['profile_pic'];

            // Role-based redirect
            switch ($role) {
                case 'Volunteer':
                    header("Location: volunteer.php");
                    exit();
                case 'Organization':
                    header("Location: organization_dashboard.php");
                    exit();
                case 'Admin':
                    header("Location: admin.php");
                    exit();
                default:
                    // If role is unrecognized, redirect to home
                    $_SESSION['login_error'] = "Invalid user role.";
                    header("Location: index.php");
                    exit();
            }

        } else {
            // Incorrect password
            $_SESSION['login_error'] = "Incorrect password.";
            header("Location: index.php");
            exit();
        }
    } else {
        // Username not found
        $_SESSION['login_error'] = "Username not found.";
        header("Location: index.php"); 
        exit();
    }
}
?>
