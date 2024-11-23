<?php 
    ob_start();
    include("../components/admin-header.php"); 

    // HANDLE DELETE REQUEST
    if (isset($_POST['delete_allowance'])) {
        $delete_id = $_POST['delete_id'];

        $verify_delete = $connForAllowance->prepare("SELECT * FROM `allowance` WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_allowance = $connForAllowance->prepare("DELETE FROM `allowance` WHERE id = ?");
            if ($delete_allowance->execute([$delete_id])) {
                $success_msg[] = 'Allowance deleted!';
            } else {
                $error_msg[] = 'Error deleting Allowance.';
            }
        } else {
            $warning_msg[] = 'Allowance already deleted!';
        }
        header('Location: allowance.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_allowance'])) {

            $student_id = $_POST['student_id'];
            $student = $_POST['student'];
            $parent = $_POST['parent'];
            $amount = $_POST['amount'];
            $note = $_POST['note'];
            $date = $_POST['date'];
    
        
            $insert_student = $connForAllowance->prepare("INSERT INTO `allowance` (`student_id`, `student_name`, `parent_name`, `amount`, `note`, `status`, `date_given`, `created_at`) VALUES (?, ?, ?, ?, ?, 'pending', ?, NOW())");
            if ($insert_student->execute([$student_id, $student, $parent, $amount, $note, $date])) {
                $success_msg[] = 'New student added successfully!';
            } else {
                $error_msg[] = 'Error adding student. Please try again.';
            }
        header('Location: allowance.php');
        exit;
    }

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_student'])) {
        $student_id = $_POST['student_id'];
        $student = $_POST['student'];
        $parent = $_POST['parent'];
        $amount = $_POST['amount'];
        $note = $_POST['note'];
        $date = $_POST['date'];

        $id = $_POST['allowance'];


        $update_sql = "UPDATE `allowance` SET `student_id` = ?, `student_name` = ?, `parent_name` = ?, `amount` = ?, `note` = ?, `date_given` = ? WHERE `id` = ?";
        $stmt_update = $connForAllowance->prepare($update_sql);
        $stmt_update->execute([$student_id, $student, $parent, $amount, $note, $date, $id]);

        header('Location: allowance.php');
        exit;
    }

    
    // FETCH ALL DATA OF ADMIN LOGS
    $allowance_list = $connForAllowance->query("SELECT * FROM `allowance` WHERE status = 'pending'")->fetchAll(PDO::FETCH_ASSOC);

    $parent_accounts = $connForAccounts->query("SELECT * FROM `user_accounts`")->fetchAll(PDO::FETCH_ASSOC);

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
            <button type="button" class="btn btn-primary mb-5 mt-4" data-toggle="modal" data-target="#allowanceModal">
                Add New Allowance
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
                                <th>Student ID</th>
                                <th>Student</th>
                                <th>Parent</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Date Given</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Student ID</th>
                                <th>Student</th>
                                <th>Parent</th>
                                <th>Amount</th>
                                <th>Note</th>
                                <th>Status</th>
                                <th>Date Given</th>
                                <th>Date Added</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($allowance_list as $allowance):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo ($allowance['student_id']); ?></td>
                                    <td><?php echo ($allowance['student_name']); ?></td>
                                    <td><?php echo ($allowance['parent_name']); ?></td>
                                    <td><?php echo ($allowance['amount']); ?></td>
                                    <td><?php echo ($allowance['note']); ?></td>
                                    <td><?php echo ($allowance['status']); ?></td>
                                    <td><?php echo ($allowance['date_given']); ?></td>
                                    <td><?php echo ($allowance['created_at']); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($allowance['id']); ?>">
                                            <input type="hidden" name="delete_allowance" value="1">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editConference<?php echo $allowance['id']; ?>">
                                            Edit
                                        </button>
                                    </td>
                                </tr>

                                <!-- edit conference Modal -->
                                <div class="modal fade" id="editConference<?php echo $allowance['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editConferenceLabel<?php echo $allowance['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog d-flex align-items-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editConferenceLabel<?php echo $allowance['id']; ?>">Edit Student Info</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="allowance" value="<?php echo ($allowance['id']); ?>">

                                                <div class="form-group">
                                                    <label for="student_id">Student ID</label>
                                                    <input type="text" class="form-control" id="student_id" name="student_id" value="<?php echo ($allowance['student_id']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="student">Student Name</label>
                                                    <input type="text" class="form-control" id="student" name="student" value="<?php echo ($allowance['student_name']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="parent">Parent Name</label>
                                                    <input type="text" class="form-control" id="parent" name="parent" value="<?php echo ($allowance['parent_name']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="amount">Amount</label>
                                                    <input type="number" class="form-control" id="amount" name="amount" value="<?php echo ($allowance['amount']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="note">Note</label>
                                                    <textarea class="form-control" name="note" id="note" rows="3" value="<?php echo ($allowance['note']); ?>"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="date">Date Given</label>
                                                    <input type="date" class="form-control" id="date" name="date" value="<?php echo ($allowance['date_given']); ?>">
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
                console.log("Deleting Allowance ID: " + reviewId); // Debug log
                form.submit(); // Submit the form if confirmed
            }
        });
    });
</script>

<div class="modal fade" id="allowanceModal" tabindex="-1" role="dialog" aria-labelledby="allowanceModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="allowanceModalLabel">Add New Allowance</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <!-- Form for adding new teacher -->
                    <form action="" method="post">

                        <div class="form-group">
                            <label for="student_id">Student ID</label>
                            <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter Student id" required>
                        </div>

                        <div class="form-group">
                            <label for="student">Student Name</label>
                            <input type="text" class="form-control" id="student" name="student" placeholder="Enter Student Name" required>
                        </div>

                        <div class="form-group">
                            <label for="parent">Parent Name</label>
                            <input type="text" class="form-control" id="parent" name="parent" placeholder="Enter Parent Name" required>
                        </div>

                        <div class="form-group">
                            <label for="amount">Amount</label>
                            <input type="number" class="form-control" id="amount" name="amount" placeholder="Enter Email" required>
                        </div>

                        <div class="form-group">
                            <label for="note">Note</label>
                            <textarea class="form-control" name="note" id="note" rows="3"></textarea>
                        </div>

                        <div class="form-group">
                            <label for="date">Date Given</label>
                            <input type="date" class="form-control" id="date" name="date" required>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add_allowance">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>