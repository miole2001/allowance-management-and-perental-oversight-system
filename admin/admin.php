<?php 
    include("../components/admin-header.php"); 

    $allowance_list = $connForAllowance->query("SELECT * FROM `allowance` WHERE status = 'pending'")->fetchAll(PDO::FETCH_ASSOC);

    $query = "SELECT COUNT(*) AS student_count FROM `student_accounts`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $student_count = $run_query->fetch(PDO::FETCH_ASSOC)['student_count'];


    $query = "SELECT COUNT(*) AS parent_count FROM `user_accounts`";
    $run_query = $connForAccounts->prepare($query);
    $run_query->execute();
    $parent_count = $run_query->fetch(PDO::FETCH_ASSOC)['parent_count'];


    $query = "SELECT COUNT(*) AS rules_count FROM `oversight_rules`";
    $run_query = $connForAllowance->prepare($query);
    $run_query->execute();
    $rules_count = $run_query->fetch(PDO::FETCH_ASSOC)['rules_count'];

    $query = "SELECT COUNT(*) AS allowance_count FROM `allowance`";
    $run_query = $connForAllowance->prepare($query);
    $run_query->execute();
    $allowance_count = $run_query->fetch(PDO::FETCH_ASSOC)['allowance_count'];

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

        <!-- Content Row -->
        <div class="row">

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Student Count
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $student_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-user-graduate fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Parent Count
                                </div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $parent_count; ?></div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-users fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Rules Count
                                </div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                            <?php echo $rules_count; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-gavel fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Allowance Count</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    <?php echo $allowance_count; ?>
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-fw fa-wallet fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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

</body>

</html>