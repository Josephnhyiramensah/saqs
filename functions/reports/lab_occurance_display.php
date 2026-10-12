<?php
    //session_start(); 
    require($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/auth.php');
    include($_SERVER['DOCUMENT_ROOT'] .'/includes/header_main.php');
?>
<input type='hidden' id='session_company_id' value="<?php echo $_SESSION['company_id'];?>">
<input type='hidden' id='session_user_super_id' value="<?php echo $_SESSION['user_super_id'];?>">
<input type='hidden' id='session_user_id' value="<?php echo $_SESSION['user_id'];?>">
  <style type="text/css">
    .scroll-card-body {
            max-height: 700px;
            overflow-y: auto;
          }
    .amt-td {
            text-align:right;
          }
    .action-td {
            text-align:center;
          }
</style>
<div class="container-fluid">
    <?php 
        if(isset($_SESSION['lab_occurance_start_date']))
        {           
            $company_id = $_SESSION['company_id'];
            $start_date = $_SESSION['lab_occurance_start_date'];
            $end_date = $_SESSION['lab_occurance_end_date'];

            $sql_company = "SELECT * FROM company WHERE company_id = '$company_id'";
            $result_company = mysqli_query($con,$sql_company);
            $row_company = mysqli_fetch_array($result_company);
    ?>
            <table class="table table-hover table-bordered table-sm" id="incidence_of_disease_list_table" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th class = "action-td" colspan="3"><H2><?php echo $row_company['trading_name'];?></H2></th>
                    </tr>
                    <tr>
                        <th class = "action-td" colspan="3"><H6>LABORATORY TEST OCCURANCE FROM <?php echo $start_date;?> TO <?php echo $end_date;?></H6></th>
                    </tr>
                    
                    <tr>
                        <th class="action-td">S/NO</th>
                        <th>TEST</th>
                        <th class="action-td">OCCURANCE</th>
                    </tr>
                </thead>
                <tbody class="pv-table-body" id="lab_occurance_list_table_body">
                    <?php
                        $sql_lab = "SELECT * FROM lab ORDER BY lab ASC";
                        $result_lab = mysqli_query($con,$sql_lab);
                        if(mysqli_num_rows($result_lab) > 0)
                        {
                            $i = 0;
                            while($row_lab = mysqli_fetch_array($result_lab))
                            {
                                $lab_id = $row_lab['lab_id'];
                                
                                $sql_llcount = "SELECT count(lab_id) AS count FROM lab_list WHERE lab_id='$lab_id'
                                AND date BETWEEN '$start_date' AND '$end_date'";
                                $result_llcount = mysqli_query($con,$sql_llcount);
                                if(mysqli_num_rows($result_llcount) > 0)
                                {
                                    $row_llcount = mysqli_fetch_array($result_llcount);
                                    if($row_llcount['count'] > 0)
                                    {
                                        $i = ++$i;
                                        echo'<tr>
                                            <td class="action-td">'.$i.'</td>
                                            <td>'.$row_lab['lab'].'</td>
                                            <td class="action-td"><strong>'.$row_llcount['count'].'</strong></td>
                                        </tr>';
                                    };
                                };
                            };
                        };
                        
                    ?>
                </tbody>
            </table>
    <?php
    };
    ?>
</div>
<?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/scripts_main.php');?>