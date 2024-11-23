<?php 
    include("../components/student-header.php"); 
    
    $oversight_rules = $connForAllowance->query("SELECT * FROM `oversight_rules`")->fetchAll(PDO::FETCH_ASSOC);
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
                <h6 class="m-0 font-weight-bold text-primary">Search Your Name to see your oversight rule(s)</h6>
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