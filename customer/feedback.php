<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<div class="container-fluid">
        <div class="card card-secondary">
            <div class="card-header">
                <h3 class="card-title">Feedback</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="form" method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>"novalidate>

                <div class="card-body">
                    <div class="form-group">
                        <label for="first_name">comment :</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter comment" value="<?php echo @$first_name; ?>">
                        <div class="text-danger"><?php echo @$e['first_name']; ?></div>
                    </div>

                   


               <!-- /.card-body -->
</div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        
    </div>
<?php include '../footer.php'; ?>

