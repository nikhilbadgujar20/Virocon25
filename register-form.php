

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

    <!-- Optional: Your own CSS (if any) -->
    <link rel="stylesheet" href="assets/css/custom.css">
</head>

<body>
    <section>
        <div class="container mt-5 mb-5">
            <h2 class="mb-4 text-center text-primary text-bold">Delegate Registration Form</h2>
            <form action="register-now.php" method="POST" id="registrationForm">
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
                            <option value="Male">National</option>
                            <option value="Female">International</option>

                        </select>

                    </div>
                    <div class="col-md-8">
                        <label for="natureOfDelegate" class="form-label">Nature of Delegate</label>
                        <select class="form-select" id="natureOfDelegate" name="nature_of_delegate" required>
                            <option value="">Select</option>
                            <option value="MaAcamadic Or Reasearch Organizationle">Acamadic Or Reasearch Organization</option>
                            <option value="Industry">Industry</option>
                            <option value="Accompanying Person">Accompanying Person</option>
                        </select>
                        <!-- <input type="text" class="form-control" id="natureOfDelegate" name="nature_of_delegate" required> -->
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
                    <div class="col-md-12">
                        <label for="delegateType" class="form-label">Attempting As</label>

                        <select class="form-select" id="Attempting" name="Attempting_as" required>
                            <option value="">Select</option>
                            <option value="participant">participant</option>
                            <option value="Presenter">Presenter</option>

                        </select>

                    </div>
                    <!-- File Upload (only for Presenter) -->
                    <div class="row mb-3" id="fileUploadBox" style="display: none;">
                        <div class="col-md-12">
                            <label for="presentationFile" class="form-label">Upload Presentation File (.docx or .pdf, max 5MB)</label>
                            <input type="file" class="form-control" id="presentationFile" name="presentation_file" accept=".pdf,.docx">
                            <div class="text-danger small mt-1" id="fileError"></div>
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


  

    <!-- ✅ Bootstrap 5 JS (needed for dropdowns) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <!-- For hiding box section -->
    <script>
        const attemptingSelect = document.getElementById('Attempting');
        const fileUploadBox = document.getElementById('fileUploadBox');
        const payButton = document.getElementById('payButton');
        const fileInput = document.getElementById('presentationFile');
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





    <?php include 'INCLUDE/footer.php' ?>