<?php 
    include("../components/admin-header.php"); 

    // HANDLE DELETE REQUEST
    if (isset($_POST['delete_account'])) {
        $delete_id = $_POST['delete_id'];
        
        $verify_delete = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE id = ?");
        $verify_delete->execute([$delete_id]);
        
        if ($verify_delete->rowCount() > 0) {
            $delete_account = $connForAccounts->prepare("DELETE FROM `user_accounts` WHERE id = ?");
            if ($delete_account->execute([$delete_id])) {
                $success_msg[] = 'Account deleted!';
            } else {
                $error_msg[] = 'Error deleting Account.';
            }
        } else {
            $warning_msg[] = 'Account already deleted!';
        }
    }

    $user_accounts = $connForAccounts->query("SELECT * FROM `user_accounts` WHERE user_type = 'parent'")->fetchAll(PDO::FETCH_ASSOC);
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
                                foreach ($user_accounts as $account):
                                ?>
                                <tr>
                                    <td><?php echo $count++; ?></td>
                                    <td><img src="../image/profile/<?php echo ($account['image']); ?>" alt="Image" style="width: 100px; height: auto;"></td>
                                    <td><?php echo ($account['name']); ?></td>
                                    <td><?php echo ($account['email']); ?></td>
                                    <td><?php echo ($account['password']); ?></td>
                                    <td><?php echo ($account['date_registered']); ?></td>
                                    <td>
                                        <form method="POST" action="" class="delete-form">
                                            <input type="hidden" name="delete_id" value="<?php echo ($account['id']); ?>">
                                            <input type="hidden" name="delete_account" value="1">
                                            <button type="button" class="btn btn-danger btn-sm delete-btn">Delete</button>
                                        </form>
                                    </td>
                                </tr>
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

</body>

</html>