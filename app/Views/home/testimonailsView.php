<?php echo view('commFile/header'); ?>

<h2>This is the testimonials page</h2>

<!-- Modal -->
<div class="modal fade" id="my-Modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="modal-From" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Add Testimonials</h5>
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
                    <h5 class="modal-title" id="exampleModalLabel">Add Testimonials</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control" id="id" name="id" placeholder="Name" hidden />
                    <!-- Content wrapper -->
                    <div class="card-body">
                        <div class="mb-4">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Name" required />
                        </div>
                        <div class="mb-4">
                            <label for="designation" class="form-label">Designation</label>
                            <input type="text" class="form-control" id="designation" name="designation" placeholder="Designation" required />
                        </div>
                        <div class="mb-4">
                            <label for="formFile" class="form-label">Image</label>
                            <input class="form-control" type="file" id="formFile" name="image" required />
                        </div>
                        <div>
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
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
            <h5 class="card-header">Table Basic</h5>
            <!-- Button to trigger modal -->
            <c class="card-header">
                <input type="button" style="background-color: #9e9e9e; color:white" class="btn btn-small addNewData float-right grey" data-bs-toggle="modal" data-bs-target="#myModal" value="+" />
            </c>
        </div>
        <div class="table-responsive text-nowrap">
            <table class="table">
                <thead>
                    <tr>
                        <th>Sr No</th>
                        <th>Name</th>
                        <th>Designation</th>
                        <th>Image</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="appendTable" class="table-border-bottom-0">
                    <!-- <tr>
                        <td>Bootstrap Project</td>
                        <td>Jerry Milton</td>
                        <td>
                            <ul class="list-unstyled m-0 avatar-group d-flex align-items-center">
                                <li class="avatar avatar-xs pull-up" title="Lilian Fuller">
                                    <img src="../assets/img/avatars/5.png" alt="Avatar" class="rounded-circle" />
                                </li>
                            </ul>
                        </td>
                        <td><span class="badge bg-label-warning me-1">Pending</span></td>
                        <td>
                            <div class="dropdown">
                                <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu">
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                                    <a class="dropdown-item" href="javascript:void(0);"><i class="bx bx-trash me-2"></i> Delete</a>
                                </div>
                            </div>
                        </td>
                    </tr> -->
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
                url: '/initialCall',
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

            console.log("Loading data:", JsonData); // Log the received data

            $.each(JsonData, function(index, val) {
                if (!val.username || !val.description || !val.designation || !val.image) {
                    console.log("Skipping invalid entry:", val);
                    return; // Skip if any key is missing or invalid
                }

                let editBtn = '<button type="button" class="dropdown-item orange darken-1 updatePo showInv" data-id="' + val.po_id + '"><i class="bx bx-edit-alt me-2"></i>Edit</button>';
                let enBtn = '<button type="button" class="dropdown-item disable" data-id="' + val.po_id + '" data-user="' + val.po_no + '" value="Dis"><i class="bx bx-trash me-2"></i>delete</button>';
                let dsBtn = '<button type="button" class="btn-small btn-floating waves-effect waves-light red darken-1 enable" data-id="' + val.po_id + '" data-user="' + val.po_no + '" value="Ena" style="color:red;"><i class="material-icons red">cancel</i></button>';
                let actBtn = enBtn;

                // Construct the image path using the stored image filename
                let imageUrl = 'assets/uploads/itemImgs/' + val.image;

                output += `<tr>
            <td>${cnt}</td>
            <td>${val.username}</td>
            <td>${val.designation}</td>
            <td><img style="height:40px;"  src="${imageUrl}" alt="Avatar"  class="rounded-circle" /></td>
            <td>${val.description}</td>
            <td>
                <div class="dropdown">
                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
                        <i class="bx bx-dots-vertical-rounded"></i>
                    </button>
                    <div class="dropdown-menu">
                        <a class="dropdown-item updateData showInv " data-id="${val.id}"><i class="bx bx-edit-alt me-2"></i> Edit</a>
                        <a class="dropdown-item deleteData " data-id="${val.id}" ><i class="bx bx-trash me-2"></i> Delete</a>
                    </div>
                </div>
             </td>
        </tr>`;

                cnt++;
            });

            if (cnt == 1) {
                output += `<tr><td colspan="7">No Data</td></tr>`;
            }

            $('#appendTable').append(output); // Append the constructed rows

            console.log("Appended output:", output); // Log the final output
        }



        // Open Modal and prepare for adding new testimonial
        $(document).on('click', '.addNewData', function() {
            var addBtn = '<input type="submit" data-id="no" class="btn btn-small addCompBtnSub" value="Add" id="addMenuTitle">';
            $('#btnPostion').html(addBtn); // Set the button for adding data
            $('#name').val(''); // Clear input fields
            $('#designation').val(''); // Clear input fields
            $('#formFile').val(''); // Clear file input
            $('#description').val(''); // Clear textarea
            $('#myModal').modal('hide'); // Close modal
        });
        // $(document).on('click', '.addCompBtnSub', function() {
        //     // $('#myModal').modal('close'); // Close modal
        //     $('#myModal').modal('hide'); // Close modal
        // });
        // ************************** update Data ************************
        $(document).on('click', '.updateData', function() {
            var addBtn = '<input type="submit" data-id="" class="btn btn-small addCompBtnSub" value="Add" id="addMenuTitle">';

            var Id = $(this).attr('data-id');

            // Ensure the ID is a number if necessary
            const foundData = JsonData.find(data => data.id == Id);

            if (!foundData) {
                console.error("Data not found for ID:", Id);
                return; // Stop execution if no matching data is found
            }

            // Populate fields if data is found
            $('#id').val(foundData.id);
            $('#name').val(foundData.username);
            $('#designation').val(foundData.designation);
            $('#description').val(foundData.description);

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
                    url: '/saveDataAjax',
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
                    url: '/updateDataAjax', // Your server-side update endpoint
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
            const foundData = JsonData.find(data => data.id == Id);

            if (!foundData) {
                console.error("Data not found for ID:", Id);
                return; // Stop execution if no matching data is found
            }

            // Populate fields if data is found
            $('#id').val(foundData.id);

            // Delete button for submission
            var deleteBtn = '<input id="deleteFormData" data-id="' + foundData.id + '" type="submit" class="btn btn-primary btn-small" value="Delete">';
            $('#btn-Postion').html(deleteBtn);

            // Show the modal
            $('#my-Modal').modal('show');
        });

        $("form#modal-From").submit(function(e) {
            e.preventDefault(); // Prevent the default form submission

            var Id = $('#deleteFormData').attr('data-id');

            // Create FormData object to collect all form data, including the ID
            var formData = new FormData(this);
            formData.append('id', Id); // Append ID to formData

            $.ajax({
                url: '/deleteDataAjax', // Your server-side delete endpoint
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