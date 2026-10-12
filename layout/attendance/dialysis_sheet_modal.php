<div 
class="modal fade bd-example-modal-xl" 
id="dialysis_sheet_modal" 
tabindex="-1" 
role="dialog" 
aria-labelledby="dialysis_sheet_modal" 
aria-hidden="true"
data-backdrop="static"
data-keyboard="false">
  <div class="modal-dialog"  style="max-width: 95%;" role="document">
	   <div class="modal-content">
        <div class="modal-header">
        		<h5 class="modal-title m-0 font-weight-bold text-primary" id="dialysis_sheet_modal_header">DIALYSIS SHEET</h5>
        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
          		<span aria-hidden="true">&times;</span>
        		</button>
  		  </div>
          <form id="dialysis_sheet_modal_form" method="POST">
            <div class="modal-body">
              <!--<div class="accordion-option">
                <a href="javascript:void(0)" class="toggle-accordion active" accordion-id="#accordion"></a>
              </div>-->
              <div class="clearfix"></div>
                  <!--<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
                      <div class="panel panel-default">
                          <div class="panel-heading" role="tab" id="headingOne">
                            <h6 class="panel-title">
                          <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                          <h5 class="m-0 font-weight-bold text-primary">Dialysis Details</h5>
                          </a>
                            </h6>
                          </div>
                          <div id="response"></div>-->
                      <!--<div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">-->
                        <div class="panel-body">
                          <div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="treatment_time">Treatment Time (Hours)</label>
                              <input type="hidden" class="form-control" name="dialysis_sheet_id" id="dialysis_sheet_id">
                              <input type="text" class="form-control bg-light" name="treatment_time" id="treatment_time">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="machine_no">Machine No</label>
                              <select class="form-control bg-light" name="machine_no" id="machine_no"> 
                                <option value="0">-Please Select-</option>
                                <option value="1">1</option>
                                <option value="2">2</option>
                                <option value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                                <option value="8">8</option>
                                <option value="9">9</option>
                                <option value="10">10</option>
                              </select>
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="previous_weight">Previous Weight</label>
                              <input type="text" class="form-control bg-light text-center" name="previous_weight" id="previous_weight">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="dry_weight">Dry Weight</label>
                              <input type="text" class="form-control bg-light text-center" name="dry_weight" id="dry_weight">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="weight_gain">Weight Gain</label>
                              <input type="text" class="form-control bg-light text-center" name="weight_gain" id="weight_gain">
                            </div>
                            <div class="col-md-2 mb-2" id="vascular_access_div">
                              <label for="vascular_access">Vasc. Access</label>
                              <select class="form-control bg-light" name="vascular_access" id="vascular_access"> 
                                <option value="0">-Please Select-</option>
                                <option value="Fistula">Fistula</option>
                                <option value="Graft">Graft</option>
                                <option value="Femoral Catheter">Femoral Catheter</option>
                                <option value="Tunneled Catheter">Tunneled Catheter</option>
                              </select>
                            </div>
                            <div class="col-md-1 mb-1" id="needle_size_div" hidden="true">
                              <label for="needle_size">Needle Size</label>
                              <input type="text" class="form-control bg-light" name="needle_size" id="needle_size">
                            </div>
                            <!--<div class="col-md-2 mb-2">
                              <label for="fistula">Fistula</label>
                              <input type="text" class="form-control bg-light" name="fistula" id="fistula">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="graft">Graft</label>
                              <input type="text" class="form-control bg-light" name="graft" id="graft">
                            </div>-->
                          </div>
                          <div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="type_of_dialysis">Type of Dialysis</label>
                              <select class="form-control bg-light" name="type_of_dialysis" id="type_of_dialysis"> 
                                <option value="0">-Please Select-</option>
                                <option value="Haemodialysis">Haemodialysis</option>
                                <option value="Peritoneal dialysis">Peritoneal dialysis</option>
                              </select>
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="exact_time_commenced">Exact Time Commence</label>
                              <input type="time" class="form-control bg-light" name="exact_time_commenced" id="exact_time_commenced">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="exact_time_completed">Exact Time Completed</label>
                              <input type="time" class="form-control bg-light" name="exact_time_completed" id="exact_time_completed">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="heparin_bolus_dose">Heparin Bolus Dose</label>
                              <input type="text" class="form-control bg-light" name="heparin_bolus_dose" id="heparin_bolus_dose">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="heparin_maint_dose">Heparin Maint. Dose</label>
                              <input type="text" class="form-control bg-light" name="heparin_maint_dose" id="heparin_maint_dose">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="bvp">BVP</label>
                              <input type="text" class="form-control bg-light" name="bvp" id="bvp">
                            </div>
                          </div>
                          <!--<div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="bp_pre">Blood Pressure (Pre)</label>
                              <input type="text" class="form-control bg-light" name="bp_pre" id="bp_pre">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="bp_post">Blood Pressure (Post)</label>
                              <input type="text" class="form-control bg-light" name="bp_post" id="bp_post">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="standing_bp">Standing BP</label>
                              <input type="text" class="form-control bg-light" name="standing_bp" id="standing_bp">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="vascath">Vascath</label>
                              <input type="text" class="form-control bg-light" name="vascath" id="vascath">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="weight_pre">Weight (Pre)</label>
                              <input type="text" class="form-control bg-light" name="weight_pre" id="weight_pre">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="weight_post">Weight (Post)</label>
                              <input type="text" class="form-control bg-light" name="weight_post" id="weight_post">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="goal">Goal</label>
                              <input type="text" class="form-control bg-light" name="goal" id="goal">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="previous_goal">Previous Goal</label>
                              <input type="text" class="form-control bg-light" name="previous_goal" id="previous_goal">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="temp_pre">Temperature (Pre)</label>
                              <input type="text" class="form-control bg-light" name="temp_pre" id="temp_pre">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="temp_post">Temperature (Post)</label>
                              <input type="text" class="form-control bg-light" name="temp_post" id="temp_post">
                            </div>
                          </div>
                          <div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="dialysate_bath_conc">Dialysate Bath Conc</label>
                              <input type="text" class="form-control bg-light" name="dialysate_bath_conc" id="dialysate_bath_conc">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="pulse_pre">Pulse (Pre)</label>
                              <input type="text" class="form-control" name="pulse_pre" id="pulse_pre">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="pulse_post">Pulse (Post)</label>
                              <input type="text" class="form-control" name="pulse_post" id="pulse_post">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="shunt">Shunt</label>
                              <input type="text" class="form-control bg-light" name="shunt" id="shunt">
                            </div
                          </div>
                            <div class="col-md-6 mb-6">
                              <label for="comment">Comment</label>
                              <input type="text" class="form-control bg-light" name="comment" id="comment">
                            </div>
                          </div>-->
                          <div class="form-row">
                            <div class="col-md-4 mb-4">
                              <label for="medical_orders">Nurse/Medical Order/Action</label>
                              <textarea class="form-control bg-light" id="medical_orders" name="medical_orders" rows="3"></textarea>
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="assessment_pre">Assessment (Pre)</label>
                              <textarea class="form-control bg-light" id="assessment_pre" name="assessment_pre" rows="3"></textarea>
                            </div>
                            <div class="col-md-4 mb-4">
                              <label for="assessment_post">Assessment (Post)</label>
                              <textarea class="form-control bg-light" id="assessment_post" name="assessment_post" rows="3"></textarea>
                            </div>
                            <!--<div class="col-md-2 mb-2">
                              <label for="blood_sample">Blood Sample</label>
                              <input type="text" class="form-control" name="blood_sample" id="blood_sample">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="others">Others</label>
                              <input type="text" class="form-control bg-light" name="others" id="others">
                            </div>-->
                          </div>
                          <!--<div class="form-row">
                            <div class="col-md-2 mb-2">
                              <label for="rbs_time">RBS (Time)</label>
                              <input type="text" class="form-control bg-light" name="rbs_time" id="rbs_time">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="rbs_value">RBS (Value)</label>
                              <input type="text" class="form-control bg-light" name="rbs_value" id="rbs_value">
                            </div>
                            <div class="col-md-8 mb-8">
                              <label for="rbs_action">RBS (Action)</label>
                              <input type="text" class="form-control bg-light" name="rbs_action" id="rbs_action">
                            </div>
                          </div>-->
                          <div class="form-row">
                            <!--<div class="col-md-1 mb-1">
                              <label for="na">Na+</label>
                              <input type="text" class="form-control bg-light" name="na" id="na">
                            </div>-->
                            <div class="col-md-2 mb-2">
                              <label for="creat">Creat.</label>
                              <input type="text" class="form-control bg-light" name="creat" id="creat">
                            </div>
                            <!--<div class="col-md-1 mb-1">
                              <label for="glue">Glue.</label>
                              <input type="text" class="form-control bg-light" name="glue" id="glue">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="k">K+</label>
                              <input type="text" class="form-control bg-light" name="k" id="k">
                            </div>-->
                            <div class="col-md-2 mb-2">
                              <label for="urea">Urea</label>
                              <input type="text" class="form-control bg-light" name="urea" id="urea">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="hb">Hb</label>
                              <input type="text" class="form-control bg-light" name="hb" id="hb">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="connecting_nurse">Connecting Nurse</label>
                              <input type="text" class="form-control bg-light" name="connecting_nurse" id="connecting_nurse">
                            </div>
                            <div class="col-md-3 mb-3">
                              <label for="disconnecting_nurse">Disconnecting Nurse</label>
                              <input type="text" class="form-control bg-light" name="disconnecting_nurse" id="disconnecting_nurse">
                            </div>
                            <!--<div class="col-md-1 mb-1">
                              <label for="heart">Heart</label>
                              <input type="text" class="form-control bg-light" name="heart" id="heart">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="lungs">Lungs</label>
                              <input type="text" class="form-control bg-light" name="lungs" id="lungs">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="gi">GI</label>
                              <input type="text" class="form-control" name="gi" id="gi">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="access">Access</label>
                              <input type="text" class="form-control bg-light" name="access" id="access">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="gait">Gait</label>
                              <input type="text" class="form-control bg-light" name="gait" id="gait">
                            </div>
                            <div class="col-md-1 mb-1">
                              <label for="br_others">Others</label>
                              <input type="text" class="form-control bg-light" name="br_others" id="br_others">
                            </div>-->
                          </div>
                          <div class="form-row">
                            <!--<div class="col-md-2 mb-2">
                              <label for="conductivity">Conductivity</label>
                              <input type="text" class="form-control" name="conductivity" id="conductivity">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="auto_test">Auto Test</label>
                              <input type="text" class="form-control bg-light" name="auto_test" id="auto_test">
                            </div>
                            <div class="col-md-2 mb-2">
                              <label for="alarm_test">Alarm Test</label>
                              <input type="text" class="form-control bg-light" name="alarm_test" id="alarm_test">
                            </div>-->
                          </div>
                        </div>
                      <!--</div>-->
                    <!--</div>
                </div>-->
              <hr>
              <div class="form-row">
                  <div class="col-md-12 mb-12" id="dialysis_sheet_list">
                      <table table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px" id="dialysis_sheet_list_table">
                          <tr>
                              <th class = "action-td" colspan="11">DIALYSIS TABLE</th>
                          </tr>
                          <tr>
                              <th class = "action-td">Time</th>
                              <th class = "action-td">BP</th>
                              <th class = "action-td">Pulse</th>
                              <th class = "action-td">Blood Flow</th>
                              <th class = "action-td">Arterial Pressure</th>
                              <th class = "action-td">Venous Pressure</th>
                              <th class = "action-td">TMP</th>
                              <th class = "action-td">UFR</th>
                              <th class = "action-td">Volume</th>
                              <th class = "action-td">Heparin Rate</th>
                              <th class = "action-td">Comment</th>
                              <th class = "action-td">Action</th>
                          </tr>
                          <tr id="1">
                              <td class = "action-td">
                                  <input type="time" name="dl_time[]" class="form-control bg-light dl_time" id="dl_time1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_bp[]" class="form-control bg-light dl_bp" id="dl_bp1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_pulse[]" class="form-control bg-light dl_pulse" id="dl_pulse1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_blood_flow[]" class="form-control bg-light" id="dl_blood_flow1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_arterial_pressure[]" class="form-control bg-light" id="dl_arterial_pressure1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_venous_pressure[]" class="form-control bg-light" id="dl_venous_pressure1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_tmp[]" class="form-control bg-light" id="dl_tmp1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_ufr[]" class="form-control bg-light" id="dl_ufr1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_volume[]" class="form-control bg-light" id="dl_volume1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_heparin_rate[]" class="form-control bg-light" id="dl_heparin_rate1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <input type="text" name="dl_comment[]" class="form-control bg-light" id="dl_comment1" data-id="1" style="border-width:0px">
                              </td>
                              <td class = "action-td">
                                  <!--<a href="#" id="delete_dialysis_sheet_list" data-id="1"><i class="fa fa-trash fa-sm"></i></a>-->
                              </td>
                          </tr>
                      </table>
                  </div>
              </div>
            </div>
            <div class="modal-footer">
                <button type="submit" name="dialysis_sheet_save_btn" id="dialysis_sheet_save_btn" class="btn btn-primary">Save</button>
                <button type="submit" name="dialysis_sheet_update_btn" id="dialysis_sheet_update_btn" class="btn btn-secondary">Update</button>
                <button type="submit" name="dialysis_sheet_cancel_btn" id="dialysis_sheet_cancel_btn" class="btn btn-danger" data-dismiss="modal">Close</button>
            </div>
            <?php include($_SERVER['DOCUMENT_ROOT'] .'/includes/foot.php');?>
          </form>
	   </div>
  </div>
</div>