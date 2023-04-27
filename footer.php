</div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <strong>Copyright © D-Ads Digital 2021.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
      <b>Devoloped by </b> Ranga Disanayaka
    </div>
  </footer>
</div>
<!-- ./wrapper -->
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="<?php echo ROOT;?>plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap -->
<script src="<?php echo ROOT;?>plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE -->
<script src="<?php echo ROOT;?>dist/js/adminlte.js"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="<?php echo ROOT;?>plugins/chart.js/Chart.min.js"></script>
<script src="<?php echo ROOT;?>dist/js/demo.js"></script>
<script src="<?php echo ROOT;?>dist/js/pages/dashboard3.js"></script>

<!-- bs-custom-file-input -->
<script src="<?php echo ROOT;?>plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>

<script type="text/javascript">
//    file input function 
$(document).ready(function () {
  bsCustomFileInput.init();
});

function PrintElem(elem)
{
    var mywindow = window.open('', 'PRINT', 'height=400,width=600');

    mywindow.document.write('<html><head><title>' + document.title  + '</title>');
    mywindow.document.write('</head><body >');
    mywindow.document.write('<h1>' + document.title  + '</h1>');
    mywindow.document.write(document.getElementById(elem).innerHTML);
    mywindow.document.write('</body></html>');

    mywindow.document.close(); // necessary for IE >= 10
    mywindow.focus(); // necessary for IE >= 10*/

    mywindow.print();
    mywindow.close();

    return true;
}
</script>
</body>
</html>