<?php
include 'db_connect.php';
//method 1
$username = "helpinghands";
$email = "contact@helpinghands.org";
$password = password_hash("#Org123", PASSWORD_DEFAULT);
$role = "Organization";
$registration_number = "NGO-2025-003";
$phone = "+94771234573";
$profile_pic = "";
$is_verified = 0;

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role, nic, registration_number, phone, profile_pic, is_verified) VALUES (?, ?, ?, ?, NULL, ?, ?, ?, ?)");
$stmt->bind_param("sssssssi", $username, $email, $password, $role, $registration_number, $phone, $profile_pic, $is_verified);

if($stmt->execute()){
    echo "New organization added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

/*//method 2
<?php
include 'db_connect.php'; // your database connection

// Array of sample organizations
$organizations = [
    [
        "username" => "greenhands_ngo",
        "email" => "contact@greenhands.org",
        "password" => "Green@1234",
        "role" => "Organization",
        "registration_number" => "NGO-2025-001",
        "phone" => "0712345678",
        "profile_pic" => ""
        "is_verified" => 0
    ],
    [
        "username" => "organization2",
        "email" => "org2@gmail.com",
        "password" => "#org234",
        "role" => "Organization",
        "registration_number" => "200445873V",
        "phone" => "+94771234572",
        "profile_pic" => ""
        "is_verified" => 0
    ]
];

// Prepare statement
$stmt = $conn->prepare("
    INSERT INTO users (username, email, password, role, nic, phone, profile_pic) 
    VALUES (?, ?, ?, ?, ?, ?, ?)
    ON DUPLICATE KEY UPDATE username=username
");

foreach ($organizations as $org) {
    $hashed_password = password_hash($org['password'], PASSWORD_DEFAULT);
    $stmt->bind_param(
        "sssssss",
        $org['username'],
        $org['email'],
        $hashed_password,
        $org['role'],
        $org['nic'],
        $org['phone'],
        $org['profile_pic']
    );
    $stmt->execute();
}

echo "Sample organizations inserted successfully!";

$stmt->close();
$conn->close();
?>
*/
?>
