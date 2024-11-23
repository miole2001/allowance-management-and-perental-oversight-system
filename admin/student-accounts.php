<?php 
    ob_start();
    include("../components/admin-header.php"); 

    // HANDLE DELETE REQUEST
    if (isset($_POST['delete_account'])) {
        $delete_id = $_POST['delete_id'];
        
        $verify_delete = $connForAccounts->prepare("SELECT * FROM `student_accounts` WHERE id = ?");
        $verify_delete->execute([$delete_id]);
        
        if ($verify_delete->rowCount() > 0) {
            $delete_account = $connForAccounts->prepare("DELETE FROM `student_accounts` WHERE id = ?");
            if ($delete_account->execute([$delete_id])) {
                $success_msg[] = 'Account deleted!';
            } else {
                $error_msg[] = 'Error deleting Account.';
            }
        } else {
            $warning_msg[] = 'Account already deleted!';
        }
        header('Location: student-accounts.php');
        exit;
    }

    //add new student
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_student'])) {

        $image = $_POST['image'];
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
    
    
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
    
            $insert_student = $connForAccounts->prepare("INSERT INTO `student_accounts` (`image`, `student_id`, `name`, `email`, `password`, `user_type`, `date_registered`) VALUES (?, ?, ?, ?, ?, 'student', NOW())");
            if ($insert_student->execute([$image, $student_id, $name, $email, $hashed_password])) {
                $success_msg[] = 'New student added successfully!';
            } else {
                $error_msg[] = 'Error adding student. Please try again.';
            }
        header('Location: student-accounts.php');
        exit;
    }


    $select_user = $connForAccounts->prepare("SELECT * FROM `student_accounts` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $user = $select_user->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
        $student_id = $_POST['student_id'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $id = $_POST['student'];

        if (!empty($password)) {

            // If the user provided a new password, hash it
            $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        } else {

            // If the password field is empty, keep the existing password
            $hashed_password = $user['password'];
        }

        $update_sql = "UPDATE `student_accounts` SET `student_id` = ?, `name` = ?, `email` = ?, `password` = ? WHERE `id` = ?";
        $stmt_update = $connForAccounts->prepare($update_sql);
        $stmt_update->execute([$student_id, $name, $email, $hashed_password, $id]);

        header('Location: student-accounts.php');
        exit;
    }

    $student_accounts = $connForAccounts->query("SELECT * FROM `student_accounts`")->fetchAll(PDO::FETCH_ASSOC);
?>


<!-- Main Content -->
<div id="content">

    <!-- Topbar -->
    <?php include("../components/topbar.php"); ?>
    <!-- End of Topbar -->

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <button type="button" class="btn btn-primary mb-5 mt-4" data-toggle="modal" data-target="#studentModal">
                Add New Student
            </button>
        </div>



        <!-- DataTable -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                                <th>Action(s)</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Profile</th>
                                <th>Student ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Password</th>
                                <th>Date Registered</th>
                                <th>Action(s)</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($student_accounts as $student):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><img src="../image/profile/<?php echo ($student['image']); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                    <td><?php echo ($student['student_id']); ?></td>
                                    <td><?php echo ($student['name']); ?></td>
                                    <td><?php echo ($student['email']); ?></td>
                                    <td><?php echo ($student['password']); ?></td>
                                    <td><?php echo ($student['date_registered']); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($student['id']); ?>">
                                            <input type="hidden" name="delete_account" value="1">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editConference<?php echo $student['id']; ?>">
                                            Edit
                                        </button>
                                    </td>
                                </tr>

                                <!-- edit conference Modal -->
                                <div class="modal fade" id="editConference<?php echo $student['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editConferenceLabel<?php echo $student['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog d-flex align-items-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editConferenceLabel<?php echo $student['id']; ?>">Edit Student Info</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <img class="card-img-top" src="<?php echo "../image/profile/" . $student['image']; ?>" alt="Card image cap">
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="student" value="<?php echo ($student['id']); ?>">

                                                    <div class="form-group">
                                                        <label for="student_id">Student ID</label>
                                                        <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo ($student['student_id']); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="name">Full Name</label>
                                                        <input type="text" class="form-control" id="name" name="name" value="<?php echo ($student['name']); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="email">Email</label>
                                                        <input type="email" class="form-control" id="email" name="email" value="<?php echo ($student['email']); ?>">
                                                    </div>

                                                    <div class="form-group">
                                                        <label for="password">Password</label>
                                                        <input type="password" class="form-control" id="password" name="password" placeholder="Leave empty to keep current password">
                                                    </div>


                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_student">Save changes</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->

<!-- Footer -->
<?php include("../components/footer.php"); ?>
<!-- End of Footer -->

</div>
<!-- End of Content Wrapper -->

</div>
<!-- End of Page Wrapper -->

<?php include("../components/scripts.php"); ?>
<script>
        // Delete confirmation
        $('.delete-btn').on('click', function() {
            const form = $(this).closest('.delete-form');
            const reviewId = form.find('input[name="delete_id"]').val();

            Swal.fire({
                title: 'Are you sure?',
                text: "This action cannot be undone!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    console.log("Deleting voter ID: " + reviewId);
                    form.submit();
                }
            });
        });

</script>

    <div class="modal fade" id="studentModal" tabindex="-1" role="dialog" aria-labelledby="studentModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="studentModalLabel">Add New Teacher</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Form for adding new teacher -->
                    <form action="" method="post">

                        <div class="form-group">
                            <label for="image">Upload Picture</label>
                            <input type="file" class="form-control" id="image" name="image" placeholder="Upload Image" required>
                        </div>

                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student id" required>
                        </div>

                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" required>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add_student">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>

</html>