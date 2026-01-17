<?php
// --- PHP Booking Form Handler ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['car_type'])) {
    header('Content-Type: application/json');
    $errors = [];
    // Collect and sanitize input
    $car_type = trim($_POST['car_type'] ?? '');
    $package = trim($_POST['package'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $mobile = trim($_POST['mobile'] ?? '');
    $from_location = trim($_POST['from_location'] ?? '');
    $to_location = trim($_POST['to_location'] ?? '');
    $pickup_datetime = trim(date('Y-m-d H:i:s', strtotime($_POST['pickup_datetime'] ?? '')));
    // echo json_encode($_POST);exit;
    // Server-side validation
    if ($car_type === '') $errors[] = 'Car type is required.';
    if ($package === '') $errors[] = 'Package is required.';
    if ($name === '' || !preg_match('/^[a-zA-Z\s]{2,}$/', $name)) $errors[] = 'Valid name is required.';
    if ($mobile === '' || !preg_match('/^[0-9]{10,15}$/', $mobile)) $errors[] = 'Valid mobile number is required.';
    if ($from_location === '') $errors[] = 'Pickup location is required.';
    if ($to_location === '') $errors[] = 'Drop location is required.';
    if ($pickup_datetime === '' || strtotime($pickup_datetime) === false) $errors[] = 'Valid pickup date & time is required.';

    if (!empty($errors)) {
        echo json_encode(['success' => false, 'errors' => $errors]);
        exit;
    }

    // Database connection (update credentials)
    $mysqli = new mysqli('localhost', 'root', '', 'ntll_booking');
    if ($mysqli->connect_errno) {
        echo json_encode(['success' => false, 'errors' => ['Database connection failed.']]);
        exit;
    }

    $stmt = $mysqli->prepare("INSERT INTO tbl_car_booking (car_type, package, name, mobile, from_location, to_location, pickup_datetime) VALUES (?, ?, ?, ?, ?, ?, ?)");
    if (!$stmt) {
        echo json_encode(['success' => false, 'errors' => ['Database error.']]);
        exit;
    }
    $stmt->bind_param('sssssss', $car_type, $package, $name, $mobile, $from_location, $to_location, $pickup_datetime);
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Booking successful!']);
    } else {
        echo json_encode(['success' => false, 'errors' => ['Failed to save booking.']]);
    }
    $stmt->close();
    $mysqli->close();
    exit;
}
?>