<?php 
    ob_start();
    include("../components/parent-header.php"); 

    // HANDLE DELETE REQUEST
    if (isset($_POST['delete_rules'])) {
        $delete_id = $_POST['delete_id'];

        $verify_delete = $connForAllowance->prepare("SELECT * FROM `oversight_rules` WHERE id = ?");
        $verify_delete->execute([$delete_id]);

        if ($verify_delete->rowCount() > 0) {
            $delete_rule = $connForAllowance->prepare("DELETE FROM `oversight_rules` WHERE id = ?");
            if ($delete_rule->execute([$delete_id])) {
                $success_msg[] = 'Rule deleted!';
            } else {
                $error_msg[] = 'Error deleting Rule.';
            }
        } else {
            $warning_msg[] = 'Rule already deleted!';
        }
        header('Location: oversight-rules.php');
        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_rule'])) {

        $parent_name = $_POST['parent_name'];
        $student_name = $_POST['student_name'];
        $rule = $_POST['rule'];
        $spending_limit = $_POST['spending_limit'];
        $description = $_POST['description'];
    
        
            $insert_student = $connForAllowance->prepare("INSERT INTO `oversight_rules` (`parent_name`, `student_name`, `rule`, `spending_limit`, `description`, `status`, `created_at`) VALUES (?, ?, ?, ?, ?, 'pending', NOW())");
            if ($insert_student->execute([$parent_name, $student_name, $rule, $spending_limit, $description])) {
                $success_msg[] = 'New oversight rule added successfully!';
            } else {
                $error_msg[] = 'Error adding oversight rule. Please try again.';
            }
        header('Location: oversight-rules.php');
        exit;
    }


    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_rules'])) {
        $parent_name = $_POST['parent_name'];
        $student_name = $_POST['student_name'];
        $rule = $_POST['rule'];
        $spending_limit = $_POST['spending_limit'];
        $description = $_POST['description'];


        $id = $_POST['oversight_rules'];


        $update_sql = "UPDATE `oversight_rules` SET `parent_name` = ?, `student_name` = ?, `rule` = ?, `spending_limit` = ?, `description` = ? WHERE `id` = ?";
        $stmt_update = $connForAllowance->prepare($update_sql);
        $stmt_update->execute([$parent_name, $student_name, $rule, $spending_limit, $description, $id]);

        header('Location: oversight-rules.php');
        exit;
    }
    
    $oversight_rules = $connForAllowance->query("SELECT * FROM `oversight_rules`")->fetchAll(PDO::FETCH_ASSOC);
    
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
            <button type="button" class="btn btn-primary mb-5 mt-4" data-toggle="modal" data-target="#ruleModal">
                Add New Oversight Rules
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
                                <th>Parent</th>
                                <th>Student</th>
                                <th>Rules</th>
                                <th>Spending Limit</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>#</th>
                                <th>Parent</th>
                                <th>Student</th>
                                <th>Rules</th>
                                <th>Spending Limit</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Date Created</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            <?php
                                $count = 1;
                                foreach ($oversight_rules as $rules):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><?php echo ($rules['parent_name']); ?></td>
                                    <td><?php echo ($rules['student_name']); ?></td>
                                    <td><?php echo ($rules['rule']); ?></td>
                                    <td><?php echo ($rules['spending_limit']); ?></td>
                                    <td><?php echo ($rules['description']); ?></td>
                                    <td><?php echo ($rules['status']); ?></td>
                                    <td><?php echo ($rules['created_at']); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($rules['id']); ?>">
                                            <input type="hidden" name="delete_rules" value="1">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editConference<?php echo $rules['id']; ?>">
                                            Edit
                                        </button>
                                    </td>
                                </tr>


                                <div class="modal fade" id="editConference<?php echo $rules['id']; ?>" tabindex="-1" role="dialog" aria-labelledby="editConferenceLabel<?php echo $rules['id']; ?>" aria-hidden="true">
                                    <div class="modal-dialog d-flex align-items-center" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="editConferenceLabel<?php echo $rules['id']; ?>">Edit Oversight Rules</h5>
                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form action="" method="post" enctype="multipart/form-data">
                                                    <input type="hidden" name="oversight_rules" value="<?php echo ($rules['id']); ?>">

                                                <div class="form-group">
                                                    <label for="parent_name">Parent Name</label>
                                                    <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo ($rules['parent_name']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="student_name">Student Name</label>
                                                    <input type="text" class="form-control" id="student_name" name="student_name" value="<?php echo ($rules['student_name']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="rule">Rule(s)</label>
                                                    <input type="text" class="form-control" id="rule" name="rule" value="<?php echo ($rules['rule']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="spending_limit">Spending Limit</label>
                                                    <input type="number" class="form-control" id="spending_limit" name="spending_limit" value="<?php echo ($rules['spending_limit']); ?>">
                                                </div>

                                                <div class="form-group">
                                                    <label for="description">Description</label>
                                                    <textarea class="form-control" name="description" id="description" rows="3" value="<?php echo ($rules['description']); ?>"></textarea>
                                                </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                    <button type="submit" class="btn btn-primary" name="edit_rules">Save changes</button>
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
                console.log("Deleting Rule ID: " + reviewId); // Debug log
                form.submit(); // Submit the form if confirmed
            }
        });
    });
</script>

    <div class="modal fade" id="ruleModal" tabindex="-1" role="dialog" aria-labelledby="ruleModalLabel" aria-hidden="true">
        <div class="modal-dialog d-flex align-items-center" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ruleModalLabel">Add New Oversight Rule</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <form action="" method="post">

                        <?php foreach ($parent_accounts as $parent): ?>
                            <div class="form-group">
                                <label for="parent_name">Parent Name</label>
                                <input type="text" class="form-control" id="parent_name" name="parent_name" value="<?php echo($parent['name']); ?>" readonly>
                            </div>
                        <?php endforeach; ?>

                        <div class="form-group">
                            <label for="student_name">Student Name</label>
                            <input type="text" class="form-control" id="student_name" name="student_name" placeholder="Enter Student Name" required>
                        </div>

                        <div class="form-group">
                            <label for="rule">Rule(s)</label>
                            <input type="text" class="form-control" id="rule" name="rule" placeholder="Enter Rule(s)" required>
                        </div>

                        <div class="form-group">
                            <label for="spending_limit">Spending Limit</label>
                            <input type="number" class="form-control" id="spending_limit" name="spending_limit" placeholder="Enter Spending Limit" required>
                        </div>

                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" name="description" id="description" rows="3"></textarea>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary" name="add_rule">Save changes</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

</body>

</html>