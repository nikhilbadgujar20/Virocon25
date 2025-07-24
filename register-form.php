<?php
include 'INCLUDE/header.php';
include 'conn.php';
include 'includes/PHPMailer-master/PHPMailerAutoload.php';
?>
<section>
    <div class="container mt-5 mb-5">
        <h2 class="mb-4 text-center">Delegate Registration Form</h2>
        <form action="register-now.php" method="POST" id="registrationForm">
            <!-- Title, Gender, First & Last Name -->
            <div class="row mb-3">
                <!-- Title Dropdown -->
                <div class="col-md-2">
                    <label for="titleDropdown" class="form-label">Title</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="titleDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose...
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="titleDropdown">
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Mr.', 'titleDropdown', 'titleInput')">Mr.</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Mrs.', 'titleDropdown', 'titleInput')">Mrs.</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Ms.', 'titleDropdown', 'titleInput')">Ms.</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Dr.', 'titleDropdown', 'titleInput')">Dr.</a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="title" id="titleInput" required>
                </div>

                <!-- Gender Dropdown -->
                <div class="col-md-2">
                    <label for="genderDropdown" class="form-label">Gender</label>
                    <div class="dropdown">
                        <button class="btn btn-outline-secondary dropdown-toggle w-100" type="button" id="genderDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                            Choose...
                        </button>
                        <ul class="dropdown-menu w-100" aria-labelledby="genderDropdown">
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Male', 'genderDropdown', 'genderInput')">Male</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Female', 'genderDropdown', 'genderInput')">Female</a></li>
                            <li><a class="dropdown-item" href="#" onclick="selectDropdown('Other', 'genderDropdown', 'genderInput')">Other</a></li>
                        </ul>
                    </div>
                    <input type="hidden" name="gender" id="genderInput" required>
                </div>

                <!-- First Name -->
                <div class="col-md-4">
                    <label for="firstName" class="form-label">First Name</label>
                    <input type="text" class="form-control" id="firstName" name="first_name" required>
                </div>

                <!-- Last Name -->
                <div class="col-md-4">
                    <label for="lastName" class="form-label">Last Name</label>
                    <input type="text" class="form-control" id="lastName" name="last_name" required>
                </div>
            </div>

            <!-- Organization -->
            <div class="mb-3">
                <label for="organization" class="form-label">Organization</label>
                <input type="text" class="form-control" id="organization" name="organization">
            </div>

            <!-- Delegate Type -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="delegateType" class="form-label">Delegate Type</label>
                    <input type="text" class="form-control" id="delegateType" name="delegate_type" required>
                </div>
                <div class="col-md-8">
                    <label for="natureOfDelegate" class="form-label">Nature of Delegate</label>
                    <input type="text" class="form-control" id="natureOfDelegate" name="nature_of_delegate" required>
                </div>
            </div>

            <!-- Postal Address -->
            <div class="mb-3">
                <label for="postalAddress" class="form-label">Postal Address</label>
                <textarea class="form-control" id="postalAddress" name="postal_address" rows="2"></textarea>
            </div>

            <!-- City, Pin, State -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="city" class="form-label">City</label>
                    <input type="text" class="form-control" id="city" name="city">
                </div>
                <div class="col-md-4">
                    <label for="pincode" class="form-label">Pin Code</label>
                    <input type="text" class="form-control" id="pincode" name="pin_code" pattern="\d{6}" title="Enter a valid 6-digit pin code">
                </div>
                <div class="col-md-4">
                    <label for="state" class="form-label">State</label>
                    <input type="text" class="form-control" id="state" name="state">
                </div>
            </div>

            <!-- Country, Telephone, Mobile -->
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="country" class="form-label">Country</label>
                    <input type="text" class="form-control" id="country" name="country">
                </div>
                <div class="col-md-4">
                    <label for="telephone" class="form-label">Telephone No</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone_no">
                </div>
                <div class="col-md-4">
                    <label for="mobile" class="form-label">Mobile No</label>
                    <input type="tel" class="form-control" id="mobile" name="mobile_no" required>
                </div>
            </div>

            <!-- Accompanying Persons -->
            <div class="mb-3">
                <label for="accompanyingPersons" class="form-label">No. of Accompanying Persons</label>
                <input type="number" class="form-control" id="accompanyingPersons" name="no_of_accompanying_persons" min="0" max="3">
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="person1" class="form-label">Accompanying Person 1</label>
                    <input type="text" class="form-control" id="person1" name="person1">
                </div>
                <div class="col-md-6">
                    <label for="relation1" class="form-label">Relation 1</label>
                    <input type="text" class="form-control" id="relation1" name="relation1">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="person2" class="form-label">Accompanying Person 2</label>
                    <input type="text" class="form-control" id="person2" name="person2">
                </div>
                <div class="col-md-6">
                    <label for="relation2" class="form-label">Relation 2</label>
                    <input type="text" class="form-control" id="relation2" name="relation2">
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="person3" class="form-label">Accompanying Person 3</label>
                    <input type="text" class="form-control" id="person3" name="person3">
                </div>
                <div class="col-md-6">
                    <label for="relation3" class="form-label">Relation 3</label>
                    <input type="text" class="form-control" id="relation3" name="relation3">
                </div>
            </div>

            <!-- Email and OTP -->
            <div class="row mb-3 align-items-end">
                <div class="col-md-9">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" class="btn btn-outline-primary mt-md-4" id="sendOtpBtn">Send OTP</button>
                </div>
            </div>

            <div class="row mb-3 align-items-end">
                <div class="col-md-9">
                    <label for="otp" class="form-label">Enter OTP</label>
                    <input type="text" class="form-control" id="otp" name="otp" required>
                </div>
                <div class="col-md-3 d-grid">
                    <button type="button" class="btn btn-outline-success mt-md-4" id="verifyOtpBtn">Verify OTP</button>
                </div>
            </div>

            <div class="mb-3 text-center text-success fw-bold" id="otpStatus"></div>

            <!-- Submit -->
            <div class="text-center">
                <button type="submit" class="btn btn-primary" id="submitBtn" disabled>Submit</button>
            </div>
        </form>
    </div>
</section>


<section class="section pt-0 pb-0">
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title white">
                    <h2>Conference <span class="alternate">Fee</span></h2>
                </div>
            </div>
        </div>
        <!-- Registration Timeline -->
        <div class="container text-center mt-4">
            <div class="btn-group mb-4" role="group">
                <button type="button" class="btn btn-outline-primary active" onclick="selectPeriod('early')">Early (Till 30th Sept 2025)</button>
                <button type="button" class="btn btn-outline-primary" onclick="selectPeriod('regular')">Regular (Till 20th Oct 2025)</button>
                <button type="button" class="btn btn-outline-primary" onclick="selectPeriod('late')">Late/On-Spot</button>
            </div>
        </div>

        <!-- Table (Keep your existing table here) -->
        <div class="row">
            <div class="col-md-12">
                <table class="table table-bordered text-center table-striped" id="feeTable">
                    <thead class="thead-light">
                        <tr>
                            <th>Select</th>
                            <th>Categories of Delegates</th>
                            <th>Early Registration<br>INR</th>
                            <th>Regular Registration<br>INR</th>
                            <th>Late/On Spot Registration<br>INR</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><input type="radio" name="feeOption"></td>
                            <td>IVS Members</td>
                            <td>7000</td>
                            <td>8000</td>
                            <td>8500</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="feeOption"></td>
                            <td>Non IVS Members</td>
                            <td>8000</td>
                            <td>9000</td>
                            <td>9500</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="feeOption"></td>
                            <td>Students/Research Fellows</td>
                            <td>4000</td>
                            <td>5000</td>
                            <td>5500</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="feeOption"></td>
                            <td>Industry/Corporate</td>
                            <td>12000</td>
                            <td>15000</td>
                            <td>20000</td>
                        </tr>
                        <tr>
                            <td><input type="radio" name="feeOption"></td>
                            <td>Accompanying Person (kit will not be provided)</td>
                            <td>4000</td>
                            <td>5000</td>
                            <td>5500</td>
                        </tr>
                    </tbody>
                </table>
                <label id="dateLabel" class="d-block text-center font-weight-bold">Loading current date...</label>
            </div>
        </div>
    </div>


    <!-- Pay Button -->
    <div class="text-center mt-4">
        <button id="payButton" class="btn btn-success btn-lg" disabled>Pay Now</button>
    </div>

    <!-- Razorpay script -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>
    <script>
        document.getElementById('registrationForm').addEventListener('submit', function(e) {
            const submitBtn = document.getElementById('submitBtn');
            submitBtn.disabled = true;
            submitBtn.innerText = 'Submitting...';
        });
        let otpVerified = false;

        document.getElementById('sendOtpBtn').addEventListener('click', () => {
            const email = document.getElementById('email').value;
            if (!email) return alert('Please enter your email');

            fetch('send_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'email=' + encodeURIComponent(email)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'OTP Sent') {
                        alert('OTP sent to your email.');
                    } else {
                        alert(data.error);
                    }
                });
        });

        document.getElementById('verifyOtpBtn').addEventListener('click', () => {
            const otp = document.getElementById('otp').value;
            const email = document.getElementById('email').value;

            fetch('verify_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: 'otp=' + encodeURIComponent(otp) + '&email=' + encodeURIComponent(email)
                })
                .then(res => res.json())
                .then(data => {
                    const statusDiv = document.getElementById('otpStatus');
                    if (data.status === 'verified') {
                        otpVerified = true;
                        statusDiv.textContent = 'OTP Verified';
                        document.getElementById('submitBtn').disabled = false;
                    } else {
                        statusDiv.textContent = 'OTP Incorrect';
                        document.getElementById('submitBtn').disabled = true;
                    }
                });
        });
    </script>

    <script>
        let selectedPeriod = 'early';
        let selectedAmount = 0;
        let selectedCategory = '';

        // Called on page load
        window.onload = function() {
            const today = new Date();
            const earlyDeadline = new Date("2025-09-30");
            const regularDeadline = new Date("2025-10-20");
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            const formattedDate = today.toLocaleDateString('en-IN', options);
            document.getElementById("dateLabel").textContent = "Today: " + formattedDate;

            // Determine current period
            if (today <= earlyDeadline) {
                selectedPeriod = 'early';
            } else if (today <= regularDeadline) {
                selectedPeriod = 'regular';
            } else {
                selectedPeriod = 'late';
            }

            // Set active button
            const buttons = document.querySelectorAll(".btn-group .btn");
            buttons.forEach(btn => {
                btn.classList.remove("active");
                if (btn.textContent.toLowerCase().includes(selectedPeriod)) {
                    btn.classList.add("active");
                } else {
                    btn.disabled = true;
                }
            });

            const periodIndex = {
                early: 2,
                regular: 3,
                late: 4
            };

            const currentIndex = periodIndex[selectedPeriod];

            // Handle radio selection
            const rows = document.querySelectorAll("#feeTable tbody tr");
            rows.forEach(row => {
                const radio = row.querySelector("input[type='radio']");
                const amountCell = row.children[currentIndex];

                // Style non-current period cells
                for (let i = 2; i <= 4; i++) {
                    if (i !== currentIndex) {
                        row.children[i].style.color = "#999";
                        row.children[i].style.pointerEvents = "none";
                    } else {
                        row.children[i].style.fontWeight = "bold";
                    }
                }

                radio.addEventListener("change", function() {
                    // Clear highlight from all rows
                    rows.forEach(r => r.classList.remove("table-primary"));

                    // Highlight selected row
                    if (radio.checked) {
                        row.classList.add("table-primary");
                        selectedAmount = parseInt(amountCell.innerText);
                        selectedCategory = row.children[1].innerText;
                        document.getElementById("payButton").disabled = false;
                    }
                });
            });
        };


        // Pay button handler
        document.getElementById("payButton").addEventListener("click", function() {
            if (selectedAmount <= 0) {
                alert("Please select a valid category.");
                return;
            }

            const options = {
                "key": "rzp_test_aRRY41tkiwfWbk", // Replace with your Razorpay key
                "amount": selectedAmount * 100,
                "currency": "INR",
                "name": "VIROCON 2025",
                "description": selectedCategory + " - " + selectedPeriod.toUpperCase(),
                "handler": function(response) {
                    alert("Payment Successful!\nPayment ID: " + response.razorpay_payment_id);
                },
                "theme": {
                    "color": "#28a745"
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        });
    </script>

    <div class="row mt-5">
        <div class="col-md-12">
            <div class="section-title white text-center">
                <h2>Fee <span class="alternate">Payment</span></h2>
            </div>
            <p class="text-center mb-4">The registration fee should be paid into the Indian Virological Society (IVS) account as per the details given below.</p>

            <div class="table-responsive mx-auto" style="max-width: 1000px;">
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th style="width: 40%;">Account Number</th>
                            <td>91532010005056</td>
                        </tr>
                        <tr>
                            <th>Bank</th>
                            <td>Canara Bank</td>
                        </tr>
                        <tr>
                            <th>Branch Name</th>
                            <td>NASC, PUSA CAMPUS, DELHI</td>
                        </tr>
                        <tr>
                            <th>IFSC Code</th>
                            <td>CNRB0019153</td>
                        </tr>
                        <tr>
                            <th>Branch Code</th>
                            <td>19153</td>
                        </tr>
                        <tr>
                            <th>Payment Remarks</th>
                            <td>Please add <strong>“VIROCON”</strong> to the payment remarks section for verification.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>


<?php include 'INCLUDE/footer.php' ?>