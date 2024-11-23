<?php 

    include("../components/student-header.php"); 

    $allowance_list = $connForAllowance->query("SELECT * FROM `allowance` WHERE status = 'approved'")->fetchAll(PDO::FETCH_ASSOC);
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
                <h6 class="m-0 font-weight-bold text-primary">Search your Student id or Name to see your allowance(s)</h6>
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