<?php
include 'db_connect.php';
//method 1
$username = "uoc";
$email = "uoc@example.com";
$password = password_hash("uoc", PASSWORD_DEFAULT);
$role = "Volunteer";
$nic = "000000000V";
$phone = "+0700000000";
$profile_pic = "images/Logo_of_the_University_of_Colombo.png";


$stmt = $conn->prepare("INSERT INTO users (username, email, password, role, nic, phone, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssss", $username, $email, $password, $role, $nic, $phone, $profile_pic);

if($stmt->execute()){
    echo "New volunteer added successfully!";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

/*//method 2
<?php
include 'db_connect.php';

// Array of users to insert
$users = [
    [
        "username" => "volunteer2",
        "email" => "volunteer2@gmail.com",
        "password" => "Vol@123",
        "role" => "Volunteer",
        "nic" => "200345678V",
        "phone" => "+94771234569",
        "profile_pic" => ""
    ],
    [
        "username" => "uoc",
        "email" => "uoc@example.com",
        "password" => "uoc",
        "role" => "Volunteer",
        "nic" => "000000000V",
        "phone" => "+94000000000",
        "profile_pic" => ""
    ]
];

$stmt = $conn->prepare("INSERT INTO users (username, email, password, role, nic, phone, profile_pic) VALUES (?, ?, ?, ?, ?, ?, ?)");

foreach ($users as $user) {
    $hashed_password = password_hash($user['password'], PASSWORD_DEFAULT);
    $stmt->bind_param(
        "sssssss",
        $user['username'],
        $user['email'],
        $hashed_password,
        $user['role'],
        $user['nic'],
        $user['phone'],
        $user['profile_pic']
    );
    $stmt->execute();
}

echo "Users inserted successfully!";

$stmt->close();
$conn->close();
?>
*/
?>

