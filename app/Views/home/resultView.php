<?php echo view('commFile/header'); ?>

<!-- <h2>This is the result View page</h2> -->

<!-- Modal -->
<div class="modal fade" id="my-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modal-From" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Delete gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h4 style="color:red;">Do You Want to delete data ......</h4>
                </div>
                <div class="modal-footer">
                    <span id="btn-Postion"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modalFrom" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Gallery</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="stud_id" name="stud_id" hidden />
                    <!-- Content wrapper -->
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="stud_name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="stud_name" name="stud_name" placeholder="Name"  required/>
                        </div>
                        <div class="mb-4">
                            <label for="exam_name" class="form-label">Exam Name</label>
                            <input type="text" class="form-control" id="exam_name" name="exam_name" placeholder="Exam Name" required />
                        </div>
                        <div class="mb-4">
                            <label for="exam_year" class="form-label">Exam Year</label>
                            <input type="text" class="form-control" id="exam_year" name="exam_year" placeholder="Exam Year" required />
                        </div>
                        <div class="mb-4">
                            <label for="college_name" class="form-label">College Name</label>
                            <input type="text" class="form-control" id="college_name" name="college_name" placeholder="College Name"  required/>
                        </div>
                        <div class="mb-4">
                            <label for="score" class="form-label">Score</label>
                            <input type="text" class="form-control" id="score" name="score" placeholder="score" required />
                        </div>
                        <div class="mb-4">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="formFile" name="image" required />
                        </div>

                    </div>
                    <!-- Content wrapper -->
                </div>
                <div class="modal-footer">
                    <span id="btnPostion"></span>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="container-xxl flex-grow-1 container-p-y">
    <!-- Basic Bootstrap Table -->
    <div class="card">
        <div class="d-flex flex-row justify-content-between">
            <h5 class="card-header">Student Table </h5>
            <!-- Button to trigger modal -->
            <c class="card-header">
                <input type="button" style="background-color: #9e9e9e; color:white" class="btn btn-small addNewData float-right grey" data-bs-toggle="modal" data-bs-target="#myModal" value="+" />
            </c>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>

                    <!-- // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	 -->
                    <!-- // student_results -->

                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Exam Name</th>
                        <th>Exam Year</th>
                        <th>College Name</th>
                        <th>Score</th>
                        <th>Image</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appendTable" class="table-border-bottom-0">

                </tbody>
            </table>
        </div>
    </div>
    <!--/ Basic Bootstrap Table -->

    <hr class="my-12" />
</div>
<!-- / Content -->

<?php echo view('commFile/footer'); ?>

<script>
    $(document).ready(function() {

        initialCall();
        var JsonData;


        $('#inv_items').html("output");

        function initialCall() {
            var csrfToken = $('#csrf_token').val();
            $.ajax({
                url: '/initialstudCall',
                method: 'post',
                // headers: {
                //     'X-CSRF-TOKEN': csrfToken
                // },
                dataType: 'json',
                success: function(data) {
                    JsonData = data; // Update the list
                    loadList(); // Load updated data

                    // print_r($data);
                    // loadList(JsonData);


                },
                error: function(xhr) {
                    // $('.overlay').addClass("noneGroup");
                    // toastr.error("Something is wrong, Error Code: " + xhr.status + " ");
                    alert("Something went wrong. Error Code: " + xhr.status + " ");

                }
            })
        }


        function loadList() {
            $('#appendTable').html(''); // Clear the table before appending
            var output = '';
            var cnt = 1;


            // Iterate over the JsonData
            $.each(JsonData, function(index, val) {
                // Check if any critical fields are missing or empty
                if (!val.stud_name || !val.exam_name || !val.exam_year || !val.college_name || !val.image) {
                    // console.log("Skipping invalid entry:", val);
                    return; // Skip if any key is missing or invalid
                }

                // Construct the image path using the stored image filename
                let imageUrl = 'assets/uploads/itemImgs/' + val.image;

                // Constructing the table row
                output += `<tr>
            <td>${cnt}</td>
            <td>${val.stud_name}</td>
            <td>${val.exam_name}</td>
            <td>${val.exam_year}</td>
            <td>${val.college_name}</td>
            <td>${val.score}</td>
            <td><img style="height:40px;" src="${imageUrl}" alt="Avatar" class="rounded-circle" /></td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item updateData showInv" data-id="${val.stud_id}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item deleteData" data-id="${val.stud_id}"><i class="bx bx-trash me-2"></i> Delete</a>
                    </div>
                </div>
            </td>
        </tr>`;

                cnt++;
            });

            // If no valid data, show "No Data" row
            if (cnt == 1) {
                output += `<tr><td colspan="7">No Data</td></tr>`;
            }

            // Append the output to the table body
            $('#appendTable').append(output);
        }




        // Open Modal and prepare for adding new testimonial
        $(document).on('click', '.addNewData', function() {
            // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	

            var addBtn = '<input type="submit" data-id="no" class="btn btn-small addCompBtnSub" value="Add" id="addMenuTitle">';
            $('#btnPostion').html(addBtn); // Set the button for adding data
            $('#stud_name').val(''); // Clear input fields
            $('#exam_name').val(''); // Clear input fields
            $('#exam_year').val(''); // Clear input fields
            $('#college_name').val(''); // Clear input fields
            $('#score').val(''); // Clear input fields
            $('#formFile').val(''); // Clear file input
            $('#myModal').modal('hide'); // Close modal
        });



        // ************************** update Data ************************
        $(document).on('click', '.updateData', function() {
            var addBtn = '<input type="submit" data-id="" class="btn btn-small addCompBtnSub" value="Add" id="addMenuTitle">';

            var Id = $(this).attr('data-id');

            // Ensure the ID is a number if necessary
            const foundData = JsonData.find(data => data.stud_id == Id);

            if (!foundData) {
                console.error("Data not found for ID:", Id);
                return; // Stop execution if no matching data is found
            }

            // Populate fields if data is found
            // stud_id	stud_name	exam_name	exam_year	college_name	score	image	created_at	

            $('#stud_id').val(foundData.stud_id);
            $('#stud_name').val(foundData.stud_name);
            $('#exam_name').val(foundData.exam_name);
            $('#exam_year').val(foundData.exam_year);
            $('#college_name').val(foundData.college_name);
            $('#score').val(foundData.score);

            // Show image preview if found
            if (foundData.image) {
                $('#imagePreview').attr('src', '/path/to/uploads/' + foundData.image).show();
            } else {
                $('#imagePreview').hide(); // Hide if no image is present
            }

            // Update button for submission
            var updateBtn = '<input id="updateCompany"  data-id="' + foundData.id + '" data-tranxid="' + foundData.id + '" type="submit" class="btn btn-primary btn-small" value="Update">';
            $('#btnPostion').html(updateBtn);

            // Show the modal
            $('#myModal').modal('show');
        });


        //*********************** */ Form submission
        $("form#modalFrom").submit(function(e) {
            e.preventDefault();

            var csrfToken = $('#csrf_token').val(); // Get CSRF token
            var opt = $('.addCompBtnSub').attr('data-id'); // Check if it's add or update

            if (opt === 'no') { // Add new entry
                var formData = new FormData(this); // FormData object to handle file uploads
                formData.append('csrf_token', csrfToken); // Append CSRF token manually


                $.ajax({
                    url: '/saveStudDataAjax',
                    data: formData,
                    method: 'POST',
                    processData: false, // Required for file uploads
                    contentType: false, // Required for file uploads
                    dataType: 'json',
                    success: function(data) {

                        // Check if the success flag is set in the response
                        if (data.status_code === 200) {
                            // Show success notification
                            // alert('Added');
                            $('#myModal').modal('hide'); // Close modal
                            JsonData = data.list; // Update the list
                            loadList(); // Load updated data
                            initialCall();

                        } else {
                            // Show error notification if success is false
                            alert('Error: ' + (data.error || 'Failed to save data.'));
                        }
                    },
                    error: function(xhr) {
                        // Handle the error response from the server
                        $('.overlay').addClass("noneGroup"); // Hide overlay
                        // toastr.error("Something went wrong, Error Code: " + xhr.status); // Show error
                        alert("Something went wrong. Error Code: " + xhr.status + " ");

                    }
                });
            } else {

                // *************** update Data Ajax *********************
                var Id = $('#updateCompany').attr('data-id');

                // Create FormData object to collect all form data, including files
                var formData = new FormData(this);
                // formData.append('id', Id); // Append ID to formData

                $.ajax({
                    url: '/updateStudDataAjax', // Your server-side update endpoint
                    data: formData,
                    method: 'post',
                    processData: false, // Important: prevent jQuery from processing the data
                    contentType: false, // Important: tell jQuery to not set content-type header
                    dataType: 'json',
                    success: function(data) {
                        // toastr.success('Updated');
                        if (data.status_code === 200) {
                            // Show success notification
                            // alert("Updated ");
                            $('#myModal').modal('hide'); // Close modal
                            JsonData = data.list; // Update the list
                            loadList(); // Re-render the updated list
                            initialCall();

                        } else {
                            // Show error notification if success is false
                            alert('Error: ' + (data.error || 'Failed to save data.'));
                        }

                    },
                    error: function(xhr) {
                        // toastr.error("Something went wrong. Error Code: " + xhr.status + " ");
                        alert("Something went wrong. Error Code: " + xhr.status + " ");

                    }
                });
            }
        });


        // ************************** delete Data ************************
        $(document).on('click', '.deleteData', function() {
            var Id = $(this).attr('data-id');

            // Ensure the ID is a number if necessary
            const foundData = JsonData.find(data => data.stud_id == Id);

            if (!foundData) {
                console.error("Data not found for ID:", Id);
                return; // Stop execution if no matching data is found
            }

            // Populate fields if data is found
            $('#stud_id').val(foundData.stud_id);

            // Delete button for submission
            var deleteBtn = '<input id="deleteFormData" data-id="' + foundData.stud_id + '" type="submit" class="btn btn-primary btn-small" value="Delete">';
            $('#btn-Postion').html(deleteBtn);

            // Show the modal
            $('#my-Modal').modal('show');
        });

        $("form#modal-From").submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var Id = $('#deleteFormData').attr('data-id');

            // Create FormData object to collect all form data, including the ID
            var formData = new FormData(this);
            formData.append('stud_id', Id); // Append ID to formData

            $.ajax({
                url: '/deleteStudDataAjax', // Your server-side delete endpoint
                data: formData,
                method: 'post', // Corrected method
                processData: false, // Important: prevent jQuery from processing the data
                contentType: false, // Important: tell jQuery to not set content-type header
                dataType: 'json',
                success: function(response) {
                    // Check if the status code is 200
                    if (response.status_code === 200) {
                        console.log("this data is deleted")
                        // toastr.success('Deleted successfully');
                        // alert('Deleted successfully');
                        $('#my-Modal').modal('hide'); // Close the correct modal
                        JsonData = response.list; // Update the data list
                        loadList(); // Re-render the updated list
                        initialCall();
                    } else {
                        // toastr.error('Error: ' + response.message); // Display any error message from the server
                        alert("Something went wrong. Error Code: " + xhr.status + " ");
                    }
                },
                error: function(xhr) {
                    // toastr.error("Something went wrong. Error Code: " + xhr.status + " ");
                    alert("Something went wrong. Error Code: " + xhr.status + " ");

                }
            });
        });




    });
</script>