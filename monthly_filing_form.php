<?php
include('connection.php');
$members = [];
$sql = "SELECT member_number, name FROM members";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $members[] = $row;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $memberId = $_POST['member_id'];
    $month = $_POST['month'];
    $amountPaid = $_POST['amount_paid'];
    $paymentMode = $_POST['payment_mode'];
    $remarks = $_POST['remarks'];
    $due = $_POST['due'];
    $date = $_POST['date'];
    $referenceNumber = ($_POST['payment_mode'] === 'rtgs') ? $_POST['reference_number'] : null;
    $sql = "INSERT INTO monthlyfilings (member_number, month, amount_paid, payment_mode, reference_number, date, remarks, due) 
            VALUES ('$memberId', '$month', '$amountPaid', '$paymentMode', '$referenceNumber', '$date', '$remarks', '$due')";


    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Monthly filing submitted successfully');</script>";
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Monthly Filing Form - SUNREY CHITS</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    function fetchMemberName() {
      const memberSelect = document.getElementById("member-number");
      const selectedOption = memberSelect.options[memberSelect.selectedIndex];
      const memberName = selectedOption.getAttribute("data-name");
      document.getElementById("member-name").value = memberName || "";
    }

    function toggleReferenceNumberField() {
      const paymentMode = document.querySelector('input[name="payment_mode"]:checked').value;
      const referenceNumberField = document.getElementById('reference-number');
      if (paymentMode === "rtgs") {
        referenceNumberField.disabled = false;
      } else {
        referenceNumberField.disabled = true;
        referenceNumberField.value = ''; 
      }
    }
  </script>
</head>
<body class="bg-gray-100 text-gray-800">

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

<div class="container mx-auto mt-24 p-6">
  <h1 class="text-3xl font-bold mb-6 text-center">Monthly Filing Form</h1>

  <!-- Form Container -->
  <div class="bg-white p-6 rounded-lg shadow-lg max-w-3xl mx-auto">
    <form class="space-y-6" method="POST">
      <!-- Member ID -->
      <div>
        <label for="member-number" class="block text-lg font-medium">Member Number</label>
        <select id="member-number" name="member_id" class="w-full p-2 border border-gray-300 rounded" onchange="fetchMemberName()" required>
          <option value="" disabled selected>Select a member</option>
          <?php foreach ($members as $member): ?>
            <option value="<?= $member['member_number'] ?>" data-name="<?= $member['name'] ?>">
              <?= $member['member_number'] ?>
            </option>
          <?php endforeach; ?>
        </select>
      </div>

      <!-- Member Name (Read-Only) -->
      <div>
        <label for="member-name" class="block text-lg font-medium">Member Name</label>
        <input type="text" id="member-name" class="w-full p-2 border border-gray-300 rounded" readonly />
      </div>

      <!-- Month -->
      <div>
        <label for="month" class="block text-lg font-medium">Month</label>
        <input type="text" id="month" name="month" class="w-full p-2 border border-gray-300 rounded" placeholder="XX/25" required />
      </div>

      <!-- Amount Paid -->
      <div>
        <label for="amount-paid" class="block text-lg font-medium">Amount Paid</label>
        <input type="number" id="amount-paid" name="amount_paid" class="w-full p-2 border border-gray-300 rounded" required />
      </div>

      <!-- Payment Mode -->
      <div>
  <label class="block text-lg font-medium mb-2">Payment Mode</label>
  <div class="grid grid-cols-2 gap-y-2 gap-x-4">
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="mobile-netbanking" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>Mobile/Netbanking</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="G-PAY" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>G-PAY</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="PhonePe" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>PhonePe</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="cred-pay" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>Cred-Pay</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="amazon-pay" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>Amazon-Pay</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="rtgs" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>RTGS</span>
    </label>
    <label class="flex items-center">
      <input type="radio" name="payment_mode" value="cash" onclick="toggleReferenceNumberField()" class="mr-2">
      <span>Cash</span>
    </label>
  </div>
</div>

      <!-- Reference Number (Conditional) -->
      <div>
        <label for="reference-number" class="block text-lg font-medium">Reference Number</label>
        <input type="text" id="reference-number" name="reference_number" class="w-full p-2 border border-gray-300 rounded" disabled />
      </div>

      <!-- Remarks -->
<div>
  <label for="remarks" class="block text-lg font-medium">Remarks</label>
  <textarea id="remarks" name="remarks" class="w-full p-2 border border-gray-300 rounded" rows="4"></textarea>
</div>


      <!-- Due -->
      <div>
        <label for="due" class="block text-lg font-medium">Due</label>
        <input type="number" id="due" name="due" class="w-full p-2 border border-gray-300 rounded" />
      </div>

      <!-- Date -->
      <div>
        <label for="date" class="block text-lg font-medium">Date</label>
        <input type="date" id="date" name="date" class="w-full p-2 border border-gray-300 rounded" required />
      </div>

      <!-- Submit Button -->
      <div>
        <button type="submit" class="w-full bg-blue-600 text-white p-2 rounded hover:bg-blue-700 transition">Submit</button>
      </div>
    </form>
  </div>
</div>
</body>
</html>
