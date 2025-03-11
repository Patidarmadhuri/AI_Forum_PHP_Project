<?php
// Define the password you want to hash
$plainPassword = "admin123"; // Change this to your desired password

// Generate the hash
$hashedPassword = password_hash($plainPassword, PASSWORD_DEFAULT);

// Output the hash
echo "Plain Password: " . $plainPassword . "<br>";
echo "Hashed Password: " . $hashedPassword . "<br>";
echo "Length: " . strlen($hashedPassword);
?>