<?php

include 'INCLUDE/header.php';
include 'conn.php';
include 'includes/PHPMailer-master/PHPMailerAutoload.php';

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <title>Delegate Registration</title>


    <!-- ✅ Bootstrap 5 CSS (for dropdowns and layout) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <section>
        <div class="container mt-5 mb-5">
            <h3 class="mb-4 text-center text-primary text-">Delegate Registration Form</h3>
            <form action="register-now.php" method="POST" id="registrationForm" enctype="multipart/form-data">
                <div class="row mb-3">
                    <div class="col-md-2">
                        <label for="title" class="form-label">Title</label>
                        <select class="form-select" id="title" name="title" required>
                            <option value="">Select</option>
                            <option value="Dr.">Dr.</option>
                            <option value="Prof.">Prof.</option>
                            <option value="Mr.">Mr.</option>
                            <option value="Mrs.">Mrs.</option>
                            <option value="Ms.">Ms.</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="fname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="col-md-5">
                        <label for="lname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>
                </div>

                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="gender" class="form-label">Gender</label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option value="">Select</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <!-- Organization -->
                    <div class="col-md-8">
                        <label for="organization" class="form-label">Organization</label>
                        <input type="text" class="form-control" id="organization" name="organization">
                    </div>
                </div>
                <!-- Delegate Type -->
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="delegateType" class="form-label">Delegate Type</label>

                        <select class="form-select" id="delegateType" name="delegate_type" required>
                            <option value="">Select</option>
                            <option value="National">National</option>
                            <option value="International">International</option>
                        </select>
                    </div>

                    <!-- ✅ Insert the new Area of Research dropdown here -->
                    <div class="col-md-4">
                        <label for="areaOfResearch" class="form-label">Area of Research</label>
                        <select class="form-select" id="areaOfResearch" name="area_of_research" required>
                            <option value="">Select</option>
                            <option value="Pandemic Preparedness &amp; Response - Challenges and Solutions">
                                Pandemic Preparedness &amp; Response - Challenges and Solutions
                            </option>
                            <option value="Countermeasures Development - Innovations for Response">
                                Countermeasures Development - Innovations for Response
                            </option>
                            <option value="Basic Virology for Research and Development">
                                Basic Virology for Research and Development
                            </option>
                        </select>
                    </div>
                    <!-- Nature of Delegate -->
                    <div class="col-md-4">
                        <label for="natureOfDelegate" class="form-label">Nature of Delegate</label>
                        <select class="form-select" id="natureOfDelegate" name="nature_of_delegate" required>
                            <option value="">Select</option>
                            <option value="IVS Members">IVS Members</option>
                            <option value="Non IVS Members">Non IVS Members</option>
                            <option value="Students/Research Fellows">Students/Research Fellows</option>
                            <option value="Industry/Corporate">Industry/Corporate</option>
                        </select>
                    </div>

                    <!-- File Upload for Students/Research Fellows -->
                    <div class="row mb-3" id="studentProofBox" style="display: none;">
                        <div class="col-12">
                            <label for="studentProofFile" class="form-label fw-bold">Upload Student/Research Proof</label>
                            <input type="file" class="form-control" id="studentProofFile" name="student_proof_file" accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text">Allowed formats: .pdf, .jpg, .jpeg, .png | Max size: 5MB</div>
                            <div class="text-danger small mt-1" id="studentFileError"></div>
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
                            <label for="state" class="form-label">State</label>
                            <input type="text" class="form-control" id="state" name="state">
                        </div>
                        <div class="col-md-4">
                            <label for="country" class="form-label">Country</label>
                            <input type="text" class="form-control" id="country" name="country">
                        </div>
                    </div>

                    <!-- Country, Telephone, Mobile -->
                    <div class="row mb-3">

                        <div class="col-md-4">
                            <label for="pincode" class="form-label">Pin Code</label>
                            <input type="text" class="form-control" id="pincode" name="pin_code" pattern="\d{6}" title="Enter a valid 6-digit pin code">
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

                    <div class="row mb-3">
                        <div class="mb-3">
                            <label for="accompanyingPersons" class="form-label">No. of Accompanying Persons (upto 3 )</label>
                            <input type="number" class="form-control" id="accompanyingPersons" name="no_of_accompanying_persons"
                                min="0" max="3" oninput="validateAccompanying()" onkeydown="blockInvalidKeys(event)">
                        </div>
                        <div class="col-md-12">
                            <label for="delegateType" class="form-label">Attending As</label>

                            <select class="form-select" id="Attempting" name="Attempting_as" required>
                                <option value="">Select</option>
                                <option value="participant">Participant</option>
                                <option value="Presenter">Presenter</option>
                            </select>

                        </div>
                        <!-- File Upload (only for Presenter) -->
                        <div class="container">
                            <div class="row mb-3" id="fileUploadBox" style="display: none;">
                                <div class="col-12 mt-2">
                                    <label for="presentationFile" class="form-label">Upload Presentation File</label>
                                    <input type="file" class="form-control" id="presentationFile" name="presentation_file" accept=".pdf,.docx" required>
                                    <div class="form-text">Allowed formats: .docx, .pdf | Max size: 5MB</div>
                                    <div class="text-danger small mt-1" id="fileError"></div>
                                </div>
                            </div>
                        </div>


                        <!-- Abstract Details (only for Presenter) -->
                        <div id="abstractFields" style="display: none;">

                            <!-- Title of Abstract -->
                            <div class="mb-3">
                                <label for="abstractTitle" class="form-label">Title of Abstract <span class="text-muted">(max 25 words, small letters only)</span></label>
                                <input type="text" class="form-control" id="abstractTitle" name="abstract_title" oninput="validateTitle()" placeholder="enter title in small letters" />
                                <div id="titleWarning" class="form-text text-danger"></div>
                            </div>


                            <!-- Authors -->
                            <div class="mb-3">
                                <label for="authors" class="form-label">Author(s) <span class="text-muted">(follow spacing: A. Author (1,2) B. Writer (1,2))</span></label>
                                <input type="text" class="form-control" id="authors" name="authors" placeholder="e.g. A. Aman (1)  B. Bman (1,2)">
                            </div>

                            <!-- Abstract Text -->
                            <div class="mb-3">
                                <label for="abstractText" class="form-label">Text of Abstract <span class="text-muted">(max 250 words)</span></label>
                                <textarea class="form-control" id="abstractText" name="abstract_text" rows="6" oninput="countAbstractWords()"></textarea>
                                <div id="abstractWordCount" class="form-text"></div>
                            </div>

                            <!-- Editable Abstract File Upload -->


                        </div>
                        <!-- Amount Payable -->
                        <div class="mb-3 mt-2">
                            <label for="amountPayable" class="form-label">Total Amount Payable (INR)</label>
                            <input type="text" class="form-control" id="amountPayable" name="amount_payable" readonly>
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
                        <!-- Submit / Submit & Pay Buttons -->
                        <div class="row justify-content-center">
                            <div class="col-md-6 text-center">
                                <!-- Submit only (for presenters or no-payment types) -->
                                <button type="submit" class="btn btn-primary w-100" id="submitBtn" disabled style="display: none;">Submit</button>

                                <!-- Submit & Pay (for participants only) -->
                                <button type="button" class="btn btn-success w-100" id="submitPayBtn" disabled style="display: none;">Submit & Pay</button>
                            </div>
                        </div>
                        <!-- <div class="text-center mt-4">
                            <button id="payButton" class="btn btn-success btn-lg" disabled>Pay Now</button>
                        </div> -->

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

            <div class="container text-center mt-4">
                <div class="btn-group mb-4" role="group">
                    <button type="button" class="btn btn-outline-primary active" onclick="selectPeriod('early')">Early <i>(Till 15th Sept 2025)</i></button>
                    <button type="button" class="btn btn-outline-primary" onclick="selectPeriod('regular')">Regular<i>(Till 15th Oct 2025)</i></button>
                    <button type="button" class="btn btn-outline-primary" onclick="selectPeriod('late')">Late/On-Spot<i>(Till 05th Nov 2025)</i></button>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    <table class="table table-bordered text-center table-striped" id="feeTable">
                        <thead class="thead-light">
                            <tr>
                                <th>Categories of Delegates</th>
                                <th>Early Registration<br>INR</th>
                                <th>Regular Registration<br>INR</th>
                                <th>Late/On Spot Registration<br>INR</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>IVS Members</td>
                                <td>7500</td>
                                <td>8500</td>
                                <td>9500</td>
                            </tr>
                            <tr>
                                <td>Non IVS Members</td>
                                <td>8500</td>
                                <td>10000</td>
                                <td>10500</td>
                            </tr>
                            <tr>
                                <td>Students/Research Fellows</td>
                                <td>4500</td>
                                <td>5500</td>
                                <td>6000</td>
                            </tr>
                            <tr>
                                <td>Industry/Corporate</td>
                                <td>13000</td>
                                <td>16000</td>
                                <td>21500</td>
                            </tr>
                            <tr>
                                <td>Accompanying Person (kit will not be provided)</td>
                                <td>4500</td>
                                <td>5500</td>
                                <td>6000</td>
                            </tr>
                        </tbody>
                    </table>
                    <label id="dateLabel" class="d-block text-center font-weight-bold">Loading current date...</label>
                </div>
            </div>
        </div>
        <!-- accompayning person -->
        <script>
            function validateAccompanying() {
                const input = document.getElementById('accompanyingPersons');
                let value = parseInt(input.value);

                // If empty, do nothing (user may be typing)
                if (input.value === "") return;

                // Clamp value between 0 and 3
                if (value < 0) {
                    input.value = 0;
                } else if (value > 3) {
                    input.value = 3;
                }
            }

            // Prevent characters like 'e', '+', '-', etc.
            function blockInvalidKeys(e) {
                // Allow: backspace (8), tab (9), delete (46), arrows (37-40), home/end (36/35)
                if ([8, 9, 46, 37, 38, 39, 40, 35, 36].includes(e.keyCode)) return;

                // Block anything not number or navigation
                if (e.key === '-' || e.key === '+' || e.key === 'e') {
                    e.preventDefault();
                }
            }
        </script>
        <script>
            window.onload = function() {
                const today = new Date();
                const earlyDeadline = new Date("2025-09-15");
                const regularDeadline = new Date("2025-10-15");
                const lateDeadline = new Date("2025-11-05"); // Corrected

                const options = {
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                };
                const formattedDate = today.toLocaleDateString('en-IN', options);
                document.getElementById("dateLabel").textContent = "Today: " + formattedDate;

                let selectedPeriod = '';
                if (today <= earlyDeadline) {
                    selectedPeriod = 'early';
                } else if (today <= regularDeadline) {
                    selectedPeriod = 'regular';
                } else {
                    selectedPeriod = 'late';
                }

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
                    early: 1,
                    regular: 2,
                    late: 3
                };

                const currentIndex = periodIndex[selectedPeriod];
                const rows = document.querySelectorAll("#feeTable tbody tr");

                rows.forEach(row => {
                    for (let i = 1; i <= 3; i++) {
                        if (i !== currentIndex) {
                            row.children[i].style.color = "#999";
                            row.children[i].style.pointerEvents = "none";
                        } else {
                            row.children[i].style.fontWeight = "bold";
                        }
                    }
                });
            };
        </script>
    </section>
    <!-- razor pay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <script>
        const submitPayBtn = document.getElementById("submitPayBtn");
        const form = document.getElementById("registrationForm");

        submitPayBtn.addEventListener("click", function() {
            const amountValue = document.getElementById("amountPayable").value;

            if (!amountValue || isNaN(amountValue)) {
                alert("Amount not calculated. Please check delegate type and accompanying persons.");
                return;
            }

            const amountInPaise = parseInt(amountValue) * 100;

            const options = {
                "key": "rzp_test_aRRY41tkiwfWbk", // Replace with your live key in production
                "amount": amountInPaise,
                "currency": "INR",
                "name": "VIROCON 2025",
                "description": "Delegate Registration Fee",
                "handler": function(response) {
                    alert("Payment Successful!\nPayment ID: " + response.razorpay_payment_id);

                    // You can optionally add the payment ID to a hidden input:
                    const paymentInput = document.createElement("input");
                    paymentInput.type = "hidden";
                    paymentInput.name = "razorpay_payment_id";
                    paymentInput.value = response.razorpay_payment_id;
                    form.appendChild(paymentInput);

                    // Now submit the form
                    form.submit();
                },
                "prefill": {
                    "email": document.getElementById("email").value,
                    "contact": document.getElementById("mobile").value
                },
                "theme": {
                    "color": "#28a745"
                }
            };

            const rzp = new Razorpay(options);
            rzp.open();
        });
    </script>



    <!-- ✅ Bootstrap 5 JS (needed for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- For hiding box section -->
    <script>
        const attemptingSelect = document.getElementById('Attempting');
        const fileUploadBox = document.getElementById('fileUploadBox');
        const payButton = document.getElementById('submitPayBtn');
        const fileInput = document.getElementById('presentationFile');
        const studentProofBox = document.getElementById('studentProofBox');
        const studentProofFile = document.getElementById('studentProofFile');
        const fileError = document.getElementById('fileError');

        attemptingSelect.addEventListener('change', function() {
            const value = this.value;

            if (value === 'participants') {
                fileUploadBox.style.display = 'none';
                payButton.disabled = false;
            } else if (value === 'Presenter') {
                fileUploadBox.style.display = 'block';
                payButton.disabled = true; // Payment only for participants
            } else {
                fileUploadBox.style.display = 'none';
                payButton.disabled = true;
            }
        });

        // Optional: Validate file on selection
        fileInput.addEventListener('change', function() {
            const file = this.files[0];
            fileError.textContent = '';

            if (file) {
                const fileSizeMB = file.size / (1024 * 1024);
                const fileType = file.name.split('.').pop().toLowerCase();

                if (fileSizeMB > 5) {
                    fileError.textContent = 'File size must be under 5MB.';
                    this.value = '';
                } else if (!['pdf', 'docx'].includes(fileType)) {
                    fileError.textContent = 'Only .pdf or .docx files are allowed.';
                    this.value = '';
                }
            }
        });

        // registration amount



        const abstractFields = document.getElementById('abstractFields');
        const abstractTitle = document.getElementById('abstractTitle');
        const abstractText = document.getElementById('abstractText');
        const abstractFileInput = document.getElementById('abstractFile');

        attemptingSelect.addEventListener('change', function() {
            const value = this.value;

            if (value === 'Presenter') {
                fileUploadBox.style.display = 'block';
                abstractFields.style.display = 'block';
            } else {
                fileUploadBox.style.display = 'none';
                abstractFields.style.display = 'none';
            }
        });

        function validateTitle() {
            const title = abstractTitle.value.trim();
            const wordCount = title.split(/\s+/).filter(Boolean).length;
            const warning = document.getElementById('titleWarning');

            if (title !== title.toLowerCase()) {
                warning.textContent = "Title must be in small letters.";
            } else if (wordCount > 25) {
                warning.textContent = "Title exceeds 25-word limit.";
            } else {
                warning.textContent = "";
            }
        }

        function countAbstractWords() {
            const text = abstractText.value.trim();
            const wordCount = text.split(/\s+/).filter(Boolean).length;
            const wordDisplay = document.getElementById('abstractWordCount');

            if (wordCount > 250) {
                wordDisplay.innerHTML = `<span class="text-danger">⚠️ Word count: ${wordCount} / 250 (Too long)</span>`;
            } else {
                wordDisplay.innerHTML = `Word count: ${wordCount} / 250`;
            }
        }

        // Abstract file validation
        abstractFileInput.addEventListener('change', function() {
            const file = this.files[0];
            const errorDiv = document.getElementById('abstractFileError');
            errorDiv.textContent = '';

            if (file) {
                const sizeMB = file.size / (1024 * 1024);
                const extension = file.name.split('.').pop().toLowerCase();

                if (sizeMB > 5) {
                    errorDiv.textContent = 'File size exceeds 5MB.';
                    this.value = '';
                } else if (extension !== 'docx') {
                    errorDiv.textContent = 'Only .docx format is allowed.';
                    this.value = '';
                }
            }
        });
    </script>

    <!-- -----------OTP SEND----------------- -->
    <script>
        // Send OTP Script
        document.getElementById('sendOtpBtn').addEventListener('click', function() {
            const email = document.getElementById('email').value;
            const statusBox = document.getElementById('otpStatus');
            statusBox.innerHTML = ''; // Clear previous status
            document.getElementById('verifyOtpBtn').disabled = true; // Disable verify button until OTP is sent
            document.getElementById('submitBtn').disabled = true; // Disable submit until OTP is verified

            // Validate email presence
            if (!email) {
                statusBox.innerHTML = "<span class='text-danger'>Please enter your email.</span>";
                return;
            }

            // Validate email format
            if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                statusBox.innerHTML = "<span class='text-danger'>Please enter a valid email address.</span>";
                return;
            }

            // Alert the user before sending request
            alert('OTP sent, please wait.');

            // Send OTP request
            fetch('send_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `email=${encodeURIComponent(email)}`
                })
                .then(response => {
                    if (!response.ok) {
                        throw new Error('HTTP status ' + response.status);
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.status === 'OTP Sent') {
                        statusBox.innerHTML = "<span class='text-success'>OTP has been sent to your email.</span>";
                        document.getElementById('verifyOtpBtn').disabled = false;
                        document.getElementById('submitBtn').disabled = true;
                    } else if (data.error) {
                        statusBox.innerHTML = "<span class='text-danger'>" + data.error + "</span>";
                        document.getElementById('verifyOtpBtn').disabled = true;
                    } else {
                        statusBox.innerHTML = "<span class='text-danger'>Failed to send OTP. Please try again.</span>";
                        document.getElementById('verifyOtpBtn').disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    statusBox.innerHTML = "<span class='text-danger'>Failed to send OTP. Please try again later.</span>";
                    document.getElementById('verifyOtpBtn').disabled = true;
                    document.getElementById('submitBtn').disabled = true;
                });
        });


        // Verify OTP Script
        // Verify OTP Script (Updated)
        document.getElementById('verifyOtpBtn').addEventListener('click', function() {
            const otp = document.getElementById('otp').value;
            const email = document.getElementById('email').value;
            const verifyStatus = document.getElementById('otpStatus');
            const attendingAs = document.getElementById('Attempting').value;

            if (!otp || !email) {
                verifyStatus.innerHTML = "<span class='text-danger'>Please enter both email and OTP.</span>";
                return;
            }

            fetch('verify_otp.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded'
                    },
                    body: `otp=${encodeURIComponent(otp)}&email=${encodeURIComponent(email)}`
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'verified') {
                        verifyStatus.innerHTML = "<span class='text-success'>OTP verified successfully.</span>";

                        // Show the correct button based on role
                        if (attendingAs === 'participant') {
                            document.getElementById('submitPayBtn').style.display = 'block';
                            document.getElementById('submitPayBtn').disabled = false;
                            document.getElementById('submitBtn').style.display = 'none';
                        } else {
                            document.getElementById('submitBtn').style.display = 'block';
                            document.getElementById('submitBtn').disabled = false;
                            document.getElementById('submitPayBtn').style.display = 'none';
                        }

                        document.getElementById('verifyOtpBtn').disabled = true;
                    } else {
                        verifyStatus.innerHTML = "<span class='text-danger'>Invalid OTP. Please try again.</span>";
                        document.getElementById('submitBtn').disabled = true;
                        document.getElementById('submitPayBtn').disabled = true;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    verifyStatus.innerHTML = "<span class='text-danger'>Something went wrong. Try again.</span>";
                    document.getElementById('submitBtn').disabled = true;
                    document.getElementById('submitPayBtn').disabled = true;
                });
        });
        // PAy and submit button logic
        document.getElementById('Attempting').addEventListener('change', function() {
            const submitBtn = document.getElementById('submitBtn');
            const submitPayBtn = document.getElementById('submitPayBtn');

            if (this.value === 'participant') {
                submitBtn.style.display = 'none';
                submitPayBtn.style.display = 'block';
            } else {
                submitBtn.style.display = 'block';
                submitPayBtn.style.display = 'none';
            }
        });

        // student document
        const delegateSelect = document.getElementById('natureOfDelegate');
        const uploadDiv = document.getElementById('studentProofBox');
        const uploadInput = document.getElementById('studentProofFile');

        delegateSelect.addEventListener('change', function() {
            if (delegateSelect.value === 'Students/Research Fellows') {
                uploadDiv.style.display = 'block';
                uploadInput.required = true;
            } else {
                uploadDiv.style.display = 'none';
                uploadInput.required = false;
                uploadInput.value = ''; // Clear if previously selected
            }
        });

        // amount...............
        document.addEventListener('DOMContentLoaded', function() {
            const delegateSelect = document.getElementById('natureOfDelegate');
            const accompanyingInput = document.getElementById('accompanyingPersons');
            const amountField = document.getElementById('amountPayable');

            const registrationFees = {
                "IVS Members": [7500, 8500, 9500],
                "Non IVS Members": [8500, 10000, 10500],
                "Students/Research Fellows": [4500, 5500, 6000],
                "Industry/Corporate": [13000, 16000, 21500],
                "Accompanying Person": [4500, 5500, 6000]
            };

            function getRegistrationIndex() {
                const today = new Date();
                const earlyDeadline = new Date("2025-09-15");
                const regularDeadline = new Date("2025-10-15");

                if (today <= earlyDeadline) return 0; // Early
                if (today <= regularDeadline) return 1; // Regular
                return 2; // Late
            }

            function calculateTotalFee() {
                const nature = delegateSelect.value;
                const accompanyingCount = parseInt(accompanyingInput.value) || 0;
                const index = getRegistrationIndex();

                if (!nature || !(nature in registrationFees)) {
                    amountField.value = '';
                    return;
                }

                const baseFee = registrationFees[nature][index];
                const accompanyingFee = accompanyingCount * registrationFees["Accompanying Person"][index];

                const total = baseFee + accompanyingFee;

                amountField.value = `${total}`;
            }

            // Recalculate on changes
            delegateSelect.addEventListener('change', calculateTotalFee);
            accompanyingInput.addEventListener('input', calculateTotalFee);
        });
    </script>
    <hr>

    <?php include 'INCLUDE/footer.php' ?>