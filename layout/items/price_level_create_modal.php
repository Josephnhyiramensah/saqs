<div 
class="modal fade bd-example-modal-lg" 
id="price_level_create_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="price_level_create_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
<div class="modal-dialog" style="max-width: 80%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="price_level_create_modal_header">Stock Type Setup</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="price_level_create_form" method="POST">
              <div class="modal-body">
                <div class="form-row">
                  <div class="col-md-12 mb-12">
                    <div id="price_level_create_form_msg"></div>
                    <input type="hidden" class="form-control" name="price_level_id" id="price_level_id" >
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-6 mb-6">
                    <label for="price_level_description">Description</label>
                    <input type="text" class="form-control" name="price_level_description" id="price_level_description">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="price_level_date">Date</label>
                    <input type="date" class="form-control" name="price_level_date" id="price_level_date" value="<?php echo $date_today;?>">
                  </div>
                  <div class="col-md-3 mb-3">
                    <label for="price_level_branch_id">Branch</label>
                    <?php
                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2)) 
                    {
                      echo '<select class="form-control price_level_branch_id" name="price_level_branch_id" id="price_level_branch_id">';
                    }
                    else
                    {
                      echo '<select class="form-control price_level_branch_id" name="price_level_branch_id" id="price_level_branch_id" hidden="true">';
                    };
                      echo '<option value="0">Please Select</option>';
                        $branch_id = $_SESSION['branch_id'];
                        $sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
                        $result=mysqli_query($con,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                          if($row['branch_id'] == $branch_id)
                          {
                            echo '<option value ="'.$row['branch_id'].'" selected="selected">'.$row['branch_name'].'</option>';
                          }
                          else
                          {
                            echo '<option value ="'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
                          };
                        };
                    echo '</select>';
                    if ($_SESSION['user_type'] == 'Ultra_Super_User' OR $_SESSION['user_type'] == 'Super_User' OR ($_SESSION['user_type'] == 'Normal_User' AND $_SESSION['user_type_id'] == 2)) 
                    {
                      echo '<select class="form-control price_level_branch_idD" name="price_level_branch_idD" id="price_level_branch_idD" disabled="disabled" hidden="true"> ';
                    }
                    else
                    {
                      echo '<select class="form-control price_level_branch_idD" name="price_level_branch_idD" id="price_level_branch_idD" disabled="disabled"> ';
                    };
                    
                      echo '<option value="0">Please Select</option>';
                        $branch_id = $_SESSION['branch_id'];
                        $sql="SELECT * FROM branch WHERE company_id = '$company_id' ORDER BY branch_name ASC";
                        $result=mysqli_query($con,$sql);
                        while($row = mysqli_fetch_array($result))
                        {
                          if($row['branch_id'] == $branch_id)
                          {
                            echo '<option value ="'.$row['branch_id'].'" selected="selected">'.$row['branch_name'].'</option>';
                          }
                          else
                          {
                            echo '<option value ="'.$row['branch_id'].'">'.$row['branch_name'].'</option>';
                          };
                        };
                      ?>
                    </select>
                  </div>
                </div>
                <div class="form-row">
                  <div class="col-md-12 mb-12" id="price_list_div">
                      <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="price_list_table">
                          <tr>
                              <th width="80%">Stock Item</th>
                              <th width="15%">Price</th>
                              <th width="5%"class="action-td">Action</th>
                          </tr>
                          <tr id="1">
                            <td>
																<select class="form-control price_level_stock_item_id" name="price_level_stock_item_id[]" id="price_level_stock_item_id1" data-id="1" style="border-width:0px"> 
																	<option value="0">Please Select</option>
																	<?php
																		$sql="SELECT * FROM stock_items WHERE company_id = '$company_id' ORDER BY stock_item ASC";
																		$result=mysqli_query($con,$sql);
																		while($row = mysqli_fetch_array($result))
																		{
																			echo '<option value ="'.$row['stock_item_id'].'">'.$row['stock_item'].'</option>';
																		};
																	?>
																</select>
															</td>
                              <td class = "action-td">
                                  <input type="text" name="price_list_price[]" class="form-control bg-light price_list_price text-right" id="price_list_price1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <!--<a href="#" class="delete_price_list_stock_item" id="delete_price_list_stock_item1" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
                              </td>
                          </tr>
                      </table>
                  </div>
                </div>
              </div>
              <div class="modal-footer">
                  <button type="button" name="price_level_save_btn" id="price_level_save_btn" class="btn btn-primary">Save</button>
                  <button type="button" name="price_level_update_btn" id="price_level_update_btn" class="btn btn-primary">Update</button>
                  <button type="submit" name="price_level_cancel_btn" id="price_level_cancel_btn" class="btn btn-danger" data-dismiss="modal">Cancel</button>
              </div>
          <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>