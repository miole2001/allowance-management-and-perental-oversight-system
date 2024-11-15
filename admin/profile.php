<?php 
    include("../components/admin-header.php"); 
    
    $select_user = $connForAccounts->prepare("SELECT * FROM `user_accounts` WHERE id = ? LIMIT 1");
    $select_user->execute([$user_id]);
    $user = $select_user->fetch(PDO::FETCH_ASSOC);
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
            <h1 class="mb-0 text-gray-800">Dashboard</h1>
        </div>

        <div class="main-body">
    
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="main-breadcrumb">
      <ol class="breadcrumb">

      </ol>
    </nav>
    <!-- /Breadcrumb -->

    <div class="row gutters-sm">
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex flex-column align-items-center text-center">
                        <img src="<?php echo "../image/profile/" . $user['image']; ?>" alt="profile" class="rounded-circle" width="150">
                        <div class="mt-3">
                            <h4><?php echo ($user['name']); ?></h4>
                            <p class="text-secondary mb-1"><?php echo ($user['email']); ?></p>
                            <!-- Button trigger modal -->
                            <button type="button" class="btn btn-info" data-toggle="modal" data-target="#exampleModal">
                                Launch demo modal
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Full Name</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['name']); ?>
                        </div>
                    </div>

                    <hr>

                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Email</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['email']); ?>
                        </div>
                    </div>

                    <hr>
                    
                    <div class="row">
                        <div class="col-sm-3">
                            <h6 class="mb-0">Password</h6>
                        </div>
                        <div class="col-sm-9 text-secondary">
                            <?php echo ($user['password']); ?>
                        </div>
                    </div>

                    <hr>

                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog d-flex align-items-center" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="modal-body">
                <form action="" method="post">
                    <!-- Text Input 1 -->
                    <div class="form-group">
                        <label for="inputSample">Sample Input</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputSample" placeholder="Sample Input">
                        </div>
                    </div>

                    <!-- Text Input 2 (Readonly) -->
                    <div class="form-group">
                        <label for="inputReadonly">Sample Input (Readonly)</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="inputReadonly" placeholder="Sample Input readonly" readonly>
                        </div>
                    </div>

                    <!-- Dropdown Menu -->
                    <div class="form-group">
                        <label for="inputSelect">Select Option</label>
                        <div class="col-sm-10">
                            <select class="form-control" id="inputSelect">
                                <option value="">Choose an option</option>
                                <option value="option1">Option 1</option>
                                <option value="option2">Option 2</option>
                                <option value="option3">Option 3</option>
                            </select>
                        </div>
                    </div>
                </form>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
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