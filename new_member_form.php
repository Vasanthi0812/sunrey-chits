<?php
include('connection.php'); // Ensure this file contains the $conn variable for DB connection

// If the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $memberNumber = $_POST['memberNumber'];
    $name = $_POST['name'];
    $phone = $_POST['phone'];

    // Prepare an SQL query to insert the data into the 'members' table
    $sql = "INSERT INTO members (member_number, name, phone, created_at) 
            VALUES (?, ?, ?, NOW())";

    // Use prepared statements to avoid SQL injection
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $memberNumber, $name, $phone);

    // Execute the query and check if the data was inserted successfully
    if ($stmt->execute()) {
        echo "<script>alert('New member registered successfully!');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }

    // Close the statement and database connection
    $stmt->close();
    $conn->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>New Member Registration - SUNREY CHITS</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

  <!-- Navbar -->
  <div class="fixed top-0 left-0 w-full bg-blue-600 text-white shadow-md z-50">
    <div class="container mx-auto flex justify-between items-center py-3 px-4">
      <h1 class="text-xl font-bold">SUNREY CHITS</h1>
      <ul class="flex space-x-6">
        <li><a href="Homepage.php" class="hover:text-blue-200 transition-colors">Home</a></li>
        <li><a href="new_member_form.php" class="hover:text-blue-200 transition-colors">New Member Registration</a></li>
        <li><a href="monthly_filing_form.php" class="hover:text-blue-200 transition-colors">Monthly Filing Form</a></li>
        <li><a href="existing_info.php" class="hover:text-blue-200 transition-colors">Existing Info</a></li>
      </ul>
    </div>
  </div>

  <!-- Main Content -->
  <div class="flex items-center justify-center min-h-screen mt-16">
    <div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
      <h1 class="text-center text-2xl font-bold text-gray-800 mb-6">New Member Registration</h1>
      <form id="membershipForm" class="space-y-4" method="POST" action="">
        <div>
          <label for="member-number" class="block text-sm font-medium text-gray-700">Member Number</label>
          <input 
            type="text" 
            id="member-number" 
            name="memberNumber" 
            placeholder="Enter Member Number"
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
            required
          />
        </div>
        <div>
          <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
          <input 
            type="text" 
            id="name" 
            name="name" 
            placeholder="Enter Name"
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
            required
          />
        </div>
        <div>
          <label for="phone" class="block text-sm font-medium text-gray-700">Phone Number</label>
          <input 
            type="tel" 
            id="phone" 
            name="phone" 
            placeholder="Enter Phone Number"
            class="w-full px-4 py-2 mt-1 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-sm"
            required
            pattern="[0-9]{10}"
          />
        </div>
        <button 
          type="submit" 
          class="w-full bg-blue-600 text-white py-2 rounded-md text-sm font-medium hover:bg-blue-700 transition">
          Submit
        </button>
      </form>
    </div>
  </div>
</body>
</html>
