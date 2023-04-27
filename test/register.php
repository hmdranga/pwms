<?php include '../header.php'; ?>
<?php include '../nav.php'; ?>
<h1>My Registration Form</h1>
<div class="row">
    <div class="col">
        <form id="member_registration_form">
    <div class="form-group">
        <label for="exampleInputEmail1">Member Name</label>
        <input type="text" class="form-control" id="member_namea" name="member_nameb" placeholder="Enter Member Name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Member Address</label>
        <input type="text" class="form-control" id="member_address" name="member_address" placeholder="Enter Member Address">
    </div>
    <div class="form-group">
        <?php
        $sql = "SELECT * FROM tb_district";
        $result = $conn->query($sql);
        ?>
        <label>District</label>
        <select class="form-control" id="district" name="district" onchange="loadDivSec(this.value);">
            <option value="">--Select a District--</option>
            <?php 
            if($result->num_rows>0){
                while ($row=$result->fetch_assoc()){
                ?>
            <option value="<?php echo $row['dis_code'];?>" > <?php echo $row['district'];?> </option>
                <?php
                
                }
            }
            ?>
            
        </select>
    </div>
            <div class="form-group" id="result_dis_sec">
                <?php
                $sql = "SELECT * FROM tb_divsecretariat";
                $result = $conn->query($sql);
                ?>
                <label>Divisional Secretariate</label>
                <select class="form-control" id="divsecretariat" name="divsecretariat" >
                    <option value="">--Select a District--</option>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row=$result->fetch_assoc()){
                        ?>
                        <option value="<?php echo $row['DivSecretariat'] ?>"><?php echo $row['DivSecretariat'] ?></option>
                        <?php
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label>Select Services</label>
                <select class="form-control" id="services" name="services" onchange="show_hide_services(this.value)">
                    <option value="">--Select a Services--</option>
                    <option value="oil">Oil Change</option>
                    <option value="full">Full Service</option>
                    <option value="break">Break Checking</option>
                </select>
            </div>
    
    <button type="button" class="btn btn-primary"  onclick="member_register()">Submit</button>
    <button type="button" class="btn btn-primary" id="district1" onclick="show_district()">show district</button>
</form>
    </div>
    <div class="col">
   <div id="oil" class="alert alert-danger" style="display: none">
            <p>Oil Change</p>
        </div>
        <div id="full" class="alert alert-success" style="display: none">
            <p>Full Service</p>
        </div>
        <div id="break" class="alert alert-warning" style="display: none">
            <p>Break Checking</p>
        </div>
        <div id="result"></div>
    </div>
</div>


<?php include '../footer.php'; ?>
<script type="text/javascript">
function member_register(){
   var mydata = $("#member_registration_form").serialize();
//   alert(mydata);
   $.ajax({
       type: 'POST',
       data: mydata,
       url: "process.php",
       success: function (data) {
          $("#result").html(data);    
       },
       error: function (request, status, error) {
          alert(request.responseText);              
        }
   });
}
function show_district(){
    $("#district").show(); 
}

function show_hide_services(service){ 
    $("#oil").hide();
    $("#full").hide();
    $("#break").hide();
    if(service=="oil"){
        $("#oil").show();
    }
    if(service=="full"){
        $("#full").show();
    }
    if(service=="break"){
        $("#break").show();
    }
}
function loadDivSec(dis_code){
      var mydata = "dis_code="+dis_code+"&";
//   alert(mydata);
   $.ajax({
       type: 'POST',
       data: mydata,
       url: "dis_sec_combo.php",
       success: function (data) {
          $("#result_dis_sec").html(data);    
       },
       error: function (request, status, error) {
          alert(request.responseText);              
        }
   });
}
</script>