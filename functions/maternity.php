<?php 
require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
//MATERNITY
			//PREGNANCIES
            function save_pregnancy()
            {
                global $con;
                $date_delivery = $_POST['date_delivery'];
                $method_delivery = $_POST['method_delivery'];
                $lmp = $_POST['lmp'];
                $edd = $_POST['edd'];
                $gender_1 = $_POST['gender_1'];
                $weight_1 = $_POST['weight_1'];
                $height_1 = $_POST['height_1'];
                $gender_2 = $_POST['gender_2'];
                $weight_2 = $_POST['weight_2'];
                $height_2 = $_POST['height_2'];
                $gender_3 = $_POST['gender_3'];
                $weight_3 = $_POST['weight_3'];
                $height_3 = $_POST['height_3'];
                $preg_outcome = $_POST['preg_outcome'];
                $preg_condition = $_POST['preg_condition'];
                $preg_problem = $_POST['preg_problem'];
                $indication = $_POST['indication'];
                $labour_type = $_POST['labour_type'];
                $post_partum = $_POST['post_partum'];
                $preg_comment = $_POST['preg_comment'];
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $risk_factor = $_POST['risk_factors'];
                $preg_thru = $_POST['preg_thru'];
                $preg_thru_specify = $_POST['preg_thru_specify'];
                $gestation_age = $_POST['gestation_age'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "INSERT INTO `pregnancies`(`company_id`,`patient_id`, `attend_id`, `LMP`, `EDD`, 
                `problems`, `outcome`, `labour_type`, `post_partum`, `indication`, `comments`, `method`, 
                `delivery_date`, `condition_delivery`, `weight_1`, `weight_2`, `weight_3`, `height_1`, 
                `height_2`, `height_3`, `gender_1`, `gender_2`, `gender_3`, `risk_factor`, `preg_thru`, 
                `preg_thru_specify`, `gestation_age`, `branch_id`, `created_by`, `created_time`) VALUES ('$company_id','$patient_id',
                '$attend_id','$lmp','$edd','$preg_problem','$preg_outcome','$labour_type','$post_partum',
                '$indication','$preg_comment','$method_delivery','$date_delivery','$preg_condition',
                '$weight_1','$weight_2','$weight_3','$height_1','$height_2','$height_3','$gender_1',
                '$gender_2','$gender_3','$risk_factor','$preg_thru','$preg_thru_specify','$gestation_age',
                '$branch_id','$user_id',NOW())";
                $query_run = mysqli_query($con, $query);

                if ($query_run)
                {
                    echo "Pregnancy Added Successfully";
                }
                else
                {
                    echo "Pregnancy NOT Added";
                };
            }

            function search_pregnancy()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $Data=array();
                $query = "SELECT * FROM pregnancies WHERE patient_id='$patient_id' AND delivery_date =''";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row=mysqli_fetch_assoc($query_run);
                    array_push($Data,'exist',$row['preg_id']);
                    $_SESSION['preg_id'] = $row["preg_id"];
                }
                else
                {
                    array_push($Data,'none');
                };
                echo json_encode($Data);
            }

            function edit_pregnancy()
            {
                global $con;
                $preg_id = $_POST['preg_id'];
                $Data=array();
                $query = "SELECT * FROM pregnancies WHERE preg_id='$preg_id'";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    array_push($Data, 
                        $row['preg_id'],$row['LMP'],$row['EDD'],$row['problems'],$row['outcome'],
                        $row['labour_type'],$row['post_partum'],$row['indication'],$row['comments'],$row['method'],
                        $row['delivery_date'],$row['condition_delivery'],$row['weight_1'],$row['weight_2'],$row['weight_3'],$row['height_1'],$row['height_2'],
                        $row['height_3'],$row['gender_1'],$row['gender_2'],$row['gender_3'],$row['risk_factor'],
                        $row['preg_thru'],$row['preg_thru_specify'],$row['gestation_age']
                    );
                }
                 echo json_encode($Data);
            }

            function update_pregnancy()
            {
                global $con;
                $preg_id = $_POST['pregnancy_id'];
                $date_delivery = $_POST['date_delivery'];
                $method_delivery = $_POST['method_delivery'];
                $lmp = $_POST['lmp'];
                $edd = $_POST['edd'];
                $gender_1 = $_POST['gender_1'];
                $weight_1 = $_POST['weight_1'];
                $height_1 = $_POST['height_1'];
                $gender_2 = $_POST['gender_2'];
                $weight_2 = $_POST['weight_2'];
                $height_2 = $_POST['height_2'];
                $gender_3 = $_POST['gender_3'];
                $weight_3 = $_POST['weight_3'];
                $height_3 = $_POST['height_3'];
                $preg_outcome = $_POST['preg_outcome'];
                $preg_condition = $_POST['preg_condition'];
                $preg_problem = $_POST['preg_problem'];
                $indication = $_POST['indication'];
                $labour_type = $_POST['labour_type'];
                $post_partum = $_POST['post_partum'];
                $preg_comment = $_POST['preg_comment'];
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $risk_factor = $_POST['risk_factors'];
                $preg_thru = $_POST['preg_thru'];
                $preg_thru_specify = $_POST['preg_thru_specify'];
                $gestation_age = $_POST['gestation_age'];
                $user_id = $_SESSION['user_id'];
                
                $query = "UPDATE `pregnancies` SET `patient_id`='$patient_id', `attend_id`='$attend_id', 
                `LMP`='$lmp', `EDD`='$edd', `problems`='$preg_problem', `outcome`='$preg_outcome', 
                `labour_type`='$labour_type', `post_partum`='$post_partum', `indication`='$indication', 
                `comments`='$preg_comment', `method`='$method_delivery', `delivery_date`='$date_delivery', 
                `condition_delivery`='$preg_condition', `weight_1`='$weight_1', `weight_2`='$weight_2', 
                `weight_3`='$weight_3', `height_1`='$height_1', `height_2`='$height_2', 
                `height_3`='$height_3', `gender_1`='$gender_1', `gender_2`='$gender_2', 
                `gender_3`='$gender_3', `risk_factor`='$risk_factor', `preg_thru`='$preg_thru', 
                `preg_thru_specify`='$preg_thru_specify', `gestation_age`='$gestation_age' , 
                `altered_by`='$user_id', `altered_time`=NOW()
                WHERE `preg_id`='$preg_id'";
                $query_run = mysqli_query($con, $query);

                if ($query_run)
                {
                    echo "Pregnancy Updated Successfully";
                }
                else
                {
                    echo "Pregnancy NOT Updated";
                };
            }

            function view_pregnancies()
            {
                global $con;
                $patient_id = $_POST['patient_id'];

                $query_gravida = "SELECT COUNT(preg_id) AS gravida FROM pregnancies WHERE patient_id='$patient_id'";
                $query_run_gravida = mysqli_query($con, $query_gravida);
                $row_gravida=mysqli_fetch_assoc($query_run_gravida);

                $query_para = "SELECT COUNT(preg_id) AS para FROM pregnancies WHERE patient_id='$patient_id' AND gestation_age > 23";
                $query_run_para = mysqli_query($con, $query_para);
                $row_para=mysqli_fetch_assoc($query_run_para);

                $query_abort = "SELECT COUNT(preg_id) AS abortions FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION'";
                $query_run_abort = mysqli_query($con, $query_abort);
                $row_abort=mysqli_fetch_assoc($query_run_abort);

                $query_spont = "SELECT COUNT(preg_id) AS spontaneous FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='Spontaneous'";
                $query_run_spont = mysqli_query($con, $query_spont);
                $row_spont=mysqli_fetch_assoc($query_run_spont);

                $query_induced = "SELECT COUNT(preg_id) AS induced FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='induced'";
                $query_run_induced = mysqli_query($con, $query_induced);
                $row_induced=mysqli_fetch_assoc($query_run_induced);

                $value = "";
                $value = '<div class="form-row">
                            <div class="col-md-3 mb-3">
                                <label for="ps_gravida"><small>Gravida</small></label>
                                <input type="text" class="form-control bg-light text-center" name="ps_gravida" id="ps_gravida" disabled="true" value="'.$row_gravida['gravida'].'">
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="ps_para"><small>Para</small></label>
                                <input type="text" class="form-control bg-light text-center" name="ps_para" id="ps_para" disabled="true" value="'.$row_para['para'].'">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="ps_abortions"><small>Abortions</small></label>
                                <input type="text" class="form-control bg-light text-center" name="ps_abortions" id="ps_abortions" disabled="true" value="'.$row_abort['abortions'].'">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="ps_spontaneous"><small>Spontaneous</small></label>
                                <input type="text" class="form-control bg-light text-center" name="ps_spontaneous" id="ps_spontaneous" disabled="true" value="'.$row_spont['spontaneous'].'">
                            </div>
                            <div class="col-md-2 mb-2">
                                <label for="ps_induced"><small>Induced</small></label>
                                <input type="text" class="form-control bg-light text-center" name="ps_induced" id="ps_induced" disabled="true" value="'.$row_induced['induced'].'">
                            </div>
                        </div>
                        <hr class="d-none d-md-block">
                        <table class="table table-hover table-bordered table-sm text-center" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>EDD</th>
                                    <th>LMP</th>
                                    <th>Delivery Date</th>
                                    <th>Delivery Method</th>
                                    <th>Labour Type</th>
                                    <th>Gestation Age</th>
                                    <th>Risk Factors</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody class="pv-table-body">';
                $query = "SELECT * FROM pregnancies WHERE patient_id='$patient_id' ORDER BY delivery_date DESC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_preg" data-id="'.$row['preg_id'].'">'.$row['EDD'].'</a></td>
                                        <td>'.$row['LMP'].'</td>
                                        <td>'.$row['delivery_date'].'</td>
                                        <td>'.$row['method'].'</td>
                                        <td>'.$row['labour_type'].'</td>
                                        <td>'.$row['gestation_age'].'</td>
                                        <td>'.$row['risk_factor'].'</td>
                                        <td>';
                                        if ($row['delivery_date'] == 0 || $row['delivery_date'] == "") 
                                        {
                                            $value.='<a href="#" id="preg_anc_sheet" data-id="'.$row['preg_id'].'">ANC</a> | 
                                                    <a href="#" id="preg_delivery_sheet" data-id1="'.$row['preg_id'].'">DELIVERY</a> | 
                                                    <a href="#" id="preg_pnc_sheet" data-id2="'.$row['preg_id'].'">PNC</a> | ';
                                        };
                                            $value.='<a href="#" id="preg_delete" data-id3="'.$row['preg_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                    }
                }
                else
                {
                        $value.='No Pregnancies Found';
                };
                $value.='</tbody>
                        </table>';
                echo $value;
            }

            function disable_new_pregnancy_btn()
            {
                global $con;
                $patient_id = $_POST['patient_id'];
                $query = "SELECT * FROM pregnancies WHERE patient_id='$patient_id' AND delivery_date =''";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $Data = 'exist';
                }
                else
                {
                    $Data = 'none';
                };
                echo $Data;
            }
        //ANC
            function anc_open()
            {
                global $con;
                $_SESSION['preg_id'] = $_POST["preg_id"];
            }

            function save_anc_form()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];

                $anc_weight = $_POST['anc_weight'];
                $anc_urine_sugar = $_POST['anc_urine_sugar'];
                $anc_urine_protein = $_POST['anc_urine_protein'];
                $anc_bp_systolic = $_POST['anc_bp_systolic'];
                $anc_bp_diastolic = $_POST['anc_bp_diastolic'];
                $anc_gest_age = $_POST['anc_gest_age'];
                $anc_fundal_height = $_POST['anc_fundal_height'];
                $anc_fundal_weight = $_POST['anc_fundal_weight'];
                $anc_fhr = $_POST['anc_fhr'];
                $anc_present = $_POST['anc_present'];
                $anc_descent = $_POST['anc_descent'];
                $anc_tt_episode = $_POST['anc_tt_episode'];
                $anc_tt_qty = $_POST['anc_tt_qty'];
                $anc_ifa_given = $_POST['anc_ifa_given'];
                $anc_sp_episode = $_POST['anc_sp_episode'];
                $anc_sp_qty = $_POST['anc_sp_qty'];
                $anc_g6pd = $_POST['anc_g6pd'];
                $anc_hiv_status = $_POST['anc_hiv_status'];
                $anc_arv_treat = $_POST['anc_arv_treat'];
                $anc_syphillis_status = $_POST['anc_syphillis_status'];
                $anc_syphillis_treat = $_POST['anc_syphillis_treat'];
                $anc_tb_diagnosed = $_POST['anc_tb_diagnosed'];
                $anc_tb_treat = $_POST['anc_tb_treat'];
                $anc_hp = $_POST['anc_hp'];
                $anc_itn = $_POST['anc_itn'];
                $anc_date = $_POST['anc_date'];
                $anc_comment = $_POST['anc_comment'];
                $preg_id = $_POST['preg_id'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "INSERT INTO `anc`(
                `company_id`,`patient_id`, `attend_id`, `preg_id`, `weight`, `urine_sugar`, `urine_protein`, `bp_systolic`, `bp_diastolic`, 
                `gest_age`, `fundal_height`, `foetal_hr`, `presentation`, `descent`, `tt_episode`, `tt_qty`, `ifa`, `sp_episode`, 
                `sp_qty`,`g6pd`,`hiv_status`, `syphillis_status`, `tb_diag`, `arv_treat`, `syphillis_treat`, 
                `tb_treat`, `date`, `hb`, `itn`, `remarks`, `fundal_weight`, `branch_id`, `created_by`, `created_time`) 
                VALUES (
                '$company_id','$patient_id','$attend_id','$preg_id','$anc_weight','$anc_urine_sugar','$anc_urine_protein','$anc_bp_systolic','$anc_bp_diastolic',
                '$anc_gest_age', '$anc_fundal_height','$anc_fhr','$anc_present','$anc_descent','$anc_tt_episode','$anc_tt_qty','$anc_ifa_given','$anc_sp_episode','
                $anc_sp_qty','$anc_g6pd','$anc_hiv_status','$anc_syphillis_status','$anc_tb_diagnosed','$anc_arv_treat','$anc_syphillis_treat',
                '$anc_tb_treat','$anc_date','$anc_hp','$anc_itn','$anc_comment','$anc_fundal_weight',
                '$branch_id','$user_id',NOW())";
                $query_run = mysqli_query($con, $query);

                if ($query_run)
                {
                    echo "ANC Saved Successfully";
                }
                else
                {
                    echo "ANC NOT Saved";
                };
            }

            function view_anc_list()
            {
                global $con;
                $preg_id = $_POST['preg_id'];
                $query_preg = "SELECT * FROM pregnancies WHERE preg_id='$preg_id'";
                $query_run_preg = mysqli_query($con, $query_preg);
            
                if (mysqli_num_rows($query_run_preg) > 0)
                {
                    while($row_preg = mysqli_fetch_assoc($query_run_preg))
                    {
                        $preg_problem = $row_preg['risk_factor'];
                    };
                }
                else
                {
                    $preg_problem = 'None';
                };
                $value = "";
                $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Weight</th>
                                    <th>BP</th>
                                    <th>Urine Protein</th>
                                    <th>Urine Sugar</th>
                                    <th>Gest. Age</th>
                                    <th>F. Height</th>
                                    <th>F. Weight</th>
                                    <th>Present.</th>
                                    <th>Descent</th>
                                    <th>FHR</th>
                                    <th>Remarks</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                          <tbody class="pv-table-body">
                          <tr>
                              <td colspan="13"><strong>Pregnancy Problem:</strong> '.$preg_problem.'</td>
                          </tr>';
                $query = "SELECT * FROM anc WHERE preg_id='$preg_id' ORDER BY date DESC";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row=mysqli_fetch_assoc($query_run))
                    {
                        $attend_id = $row['attend_id'];
                        $query_attd_vitals = "SELECT * FROM vitals WHERE attend_id='$attend_id' ORDER BY date DESC";
                        $query_run_attd_vitals = mysqli_query($con, $query_attd_vitals);
                        if (mysqli_num_rows($query_run_attd_vitals) > 0)
                        {
                            while($row_attd_vitals = mysqli_fetch_assoc($query_run_attd_vitals))
                            {
                                if($row_attd_vitals['bp_diastolic'] !='')
                                {$bp_diastolic = $row_attd_vitals['bp_diastolic'];}
                                else
                                {$bp_diastolic = 0;};

                                if($row_attd_vitals['bp_systolic'] !='')
                                {$bp_systolic = $row_attd_vitals['bp_systolic'];}
                                else
                                {$bp_systolic = 0;};

                                if($row_attd_vitals['weight'] !='')
                                {$weight = $row_attd_vitals['weight'];}
                                else
                                {$weight = 0;};
                            };
                        }
                        else
                        {
                            $bp_diastolic = 0;
                            $bp_systolic = 0;
                            $weight = 0;
                        };
                        
                        $urine_protein = 0;
                        $urine_sugar = 0;
                        $query_attd_labs = "SELECT * FROM lab_param_list WHERE attend_id='$attend_id' AND lab_id = 54";
                        $query_run_attd_labs = mysqli_query($con, $query_attd_labs);
                        if (mysqli_num_rows($query_run_attd_labs) > 0)
                        {
                            while($row_attd_labs = mysqli_fetch_assoc($query_run_attd_labs))
                            {
                                $lab_param_id = $row_attd_labs['lab_param_id'];
                                $result = $row_attd_labs['result'];
                                if($urine_protein == 0 && $lab_param_id == 851 && $result !='')
                                {
                                    $urine_protein = $result;
                                }
                                else if($urine_protein == 0 && $lab_param_id == 851 && $result =='')
                                {
                                    $urine_protein = 0;
                                }
                                else if($urine_sugar == 0 && $lab_param_id == 852 && $result !='')
                                {
                                    $urine_sugar = $result;
                                }
                                else if($urine_sugar == 0 && $lab_param_id == 852 && $result =='')
                                {
                                    $urine_sugar = 0;
                                };
                            };
                        }
                        else
                        {
                            $urine_protein = 0;
                            $urine_sugar = 0;
                        };
                        $value.='<tr>
                                    <td><a href="#" id="btn_edit_anc_sheet" data-id1="'.$row['anc_id'].'">'.$row['date'].'</a></td>
                                    <td>'.$weight.'</td>
                                    <td>'.$bp_systolic.'/'.$bp_diastolic.'</td>
                                    <td>'.$urine_protein.'</td>
                                    <td>'.$urine_sugar.'</td>
                                    <td>'.$row['gest_age'].'</td>
                                    <td>'.$row['fundal_height'].'</td>
                                    <td>'.$row['fundal_weight'].'</td>
                                    <td>'.$row['presentation'].'</td>
                                    <td>'.$row['descent'].'</td>
                                    <td>'.$row['foetal_hr'].'</td>
                                    <td>'.$row['remarks'].'</td>
                                    <td>
                                        <a href="#" id="btn_delete_anc" data-id2="'.$row['anc_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                    </td>
                                </tr>';
                    }
                };
                $value.='</tbody>
                        </table>';
                echo $value;
            }

            function edit_anc_sheet()
            {
                global $con;
                $anc_id = $_POST['anc_id'];
                $Data=array();
                $query = "SELECT * FROM anc WHERE anc_id='$anc_id'";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    array_push($Data, 
                        $row['anc_id'],$row['preg_id'],$row['weight'],$row['urine_sugar'],$row['urine_protein'],
                        $row['bp_systolic'],$row['bp_diastolic'],$row['gest_age'],$row['fundal_height'],
                        $row['foetal_hr'],$row['presentation'],$row['descent'],$row['tt_episode'],$row['tt_qty'],
                        $row['ifa'],$row['sp_episode'],$row['sp_qty'],$row['g6pd'],$row['hiv_status'],$row['syphillis_status'],
                        $row['tb_diag'],$row['arv_treat'],$row['syphillis_treat'],$row['tb_treat'],$row['date'],$row['hb'],
                        $row['itn'],$row['remarks'],$row['fundal_weight']
                    );
                }
                 echo json_encode($Data);
            }

            function update_anc_sheet()
            {
                global $con;
                $anc_weight = $_POST['anc_weight'];
                $anc_urine_sugar = $_POST['anc_urine_sugar'];
                $anc_urine_protein = $_POST['anc_urine_protein'];
                $anc_bp_systolic = $_POST['anc_bp_systolic'];
                $anc_bp_diastolic = $_POST['anc_bp_diastolic'];
                $anc_gest_age = $_POST['anc_gest_age'];
                $anc_fundal_height = $_POST['anc_fundal_height'];
                $anc_fundal_weight = $_POST['anc_fundal_weight'];
                $anc_fhr = $_POST['anc_fhr'];
                $anc_present = $_POST['anc_present'];
                $anc_descent = $_POST['anc_descent'];
                $anc_tt_episode = $_POST['anc_tt_episode'];
                $anc_tt_qty = $_POST['anc_tt_qty'];
                $anc_ifa_given = $_POST['anc_ifa_given'];
                $anc_sp_episode = $_POST['anc_sp_episode'];
                $anc_sp_qty = $_POST['anc_sp_qty'];
                $anc_g6pd = $_POST['anc_g6pd'];
                $anc_hiv_status = $_POST['anc_hiv_status'];
                $anc_arv_treat = $_POST['anc_arv_treat'];
                $anc_syphillis_status = $_POST['anc_syphillis_status'];
                $anc_syphillis_treat = $_POST['anc_syphillis_treat'];
                $anc_tb_diagnosed = $_POST['anc_tb_diagnosed'];
                $anc_tb_treat = $_POST['anc_tb_treat'];
                $anc_hp = $_POST['anc_hp'];
                $anc_itn = $_POST['anc_itn'];
                $anc_date = $_POST['anc_date'];
                $anc_comment = $_POST['anc_comment'];
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $anc_id = $_POST['anc_id'];

                $query = "UPDATE `anc` SET 
                    `patient_id`='$patient_id',`attend_id`='$attend_id',`preg_id`='$preg_id',`weight`='$anc_weight',`urine_sugar`='$anc_urine_sugar',
                    `urine_protein`='$anc_urine_protein',`bp_systolic`='$anc_bp_systolic',`bp_diastolic`='$anc_bp_diastolic',`gest_age`='$anc_gest_age',
                    `fundal_height`='$anc_fundal_height',`foetal_hr`='$anc_fhr',`presentation`='$anc_present',`descent`='$anc_descent',
                    `tt_episode`='$anc_tt_episode',`tt_qty`='$anc_tt_qty',`ifa`='$anc_ifa_given',`sp_episode`='$anc_sp_episode',`sp_qty`='$anc_sp_qty',
                    `g6pd`='$anc_g6pd',`hiv_status`='$anc_hiv_status',`syphillis_status`='$anc_syphillis_status',`tb_diag`='$anc_tb_diagnosed',
                    `arv_treat`='$anc_arv_treat',`syphillis_treat`='$anc_syphillis_treat',`tb_treat`='$anc_tb_treat',`date`='$anc_date',
                    `hb`='$anc_hp',`itn`='$anc_itn',`remarks`='$anc_comment',`fundal_weight`='$anc_fundal_weight' WHERE `anc_id`='$anc_id'";
                $query_run = mysqli_query($con, $query);

                if ($query_run)
                {
                    echo "ANC Updated Successfully";
                }
                else
                {
                    echo "ANC NOT Updated";
                };
            }
        //DELIVERY
            //MAIN
                function delivery_open()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_SESSION['preg_id'];

                    $Data=array();
                    $query_del = "SELECT * from preg_delivery WHERE patient_id='$patient_id' AND preg_id='$preg_id'";
                    $query_run_del = mysqli_query($con, $query_del);
                    if (mysqli_num_rows($query_run_del) > 0)
                    {
                        $row_del=mysqli_fetch_assoc($query_run_del);
                        array_push($Data, 'exist');
                        $_SESSION['delivery_state'] = 'exist';
                        $_SESSION['delivery_id'] = $row_del['delivery_id'];
                    }
                    else
                    {
                        array_push($Data, 'none');
                        $_SESSION['delivery_state'] = 'none';
                    };
                    echo json_encode($Data);

                    $query = "SELECT * from patients WHERE patient_id='$patient_id'";
                    $query_run = mysqli_query($con, $query);
                    $row=mysqli_fetch_assoc($query_run);
                    $_SESSION['BloodGroup'] = $row['BloodGroup'];
                    $_SESSION['geno_type'] = $row['geno_type'];
                    $_SESSION['sickling'] = $row['sickling'];

                    $query_preg = "SELECT * FROM pregnancies WHERE preg_id='$preg_id'";
                    $query_run_preg = mysqli_query($con, $query_preg);
                    $row_preg=mysqli_fetch_assoc($query_run_preg);
                    $_SESSION['LMP'] = $row_preg['LMP'];
                    $_SESSION['EDD'] = $row_preg['EDD'];

                    $query_gravida = "SELECT COUNT(preg_id) AS gravida FROM pregnancies WHERE patient_id='$patient_id'";
                    $query_run_gravida = mysqli_query($con, $query_gravida);
                    $row_gravida=mysqli_fetch_assoc($query_run_gravida);
                    $_SESSION['gravida'] = $row_gravida['gravida'];

                    $query_para = "SELECT COUNT(preg_id) AS para FROM pregnancies WHERE patient_id='$patient_id' AND gestation_age > 23";
                    $query_run_para = mysqli_query($con, $query_para);
                    $row_para=mysqli_fetch_assoc($query_run_para);
                    $_SESSION['para'] = $row_para['para'];

                    $query_abort = "SELECT COUNT(preg_id) AS abortions FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION'";
                    $query_run_abort = mysqli_query($con, $query_abort);
                    $row_abort=mysqli_fetch_assoc($query_run_abort);
                    $_SESSION['abortions'] = $row_abort['abortions'];

                    $query_spont = "SELECT COUNT(preg_id) AS spontaneous FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='Spontaneous'";
                    $query_run_spont = mysqli_query($con, $query_spont);
                    $row_spont=mysqli_fetch_assoc($query_run_spont);
                    $_SESSION['spontaneous'] = $row_spont['spontaneous'];

                    $query_induced = "SELECT COUNT(preg_id) AS induced FROM pregnancies WHERE patient_id='$patient_id' AND method='ABORTION' AND labour_type='induced'";
                    $query_run_induced = mysqli_query($con, $query_induced);
                    $row_induced=mysqli_fetch_assoc($query_run_induced);
                    $_SESSION['induced'] = $row_induced['induced'];
                }

                function delivery_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];

                    $start_date = $_POST['start_date'];
                    $start_time = $_POST['start_time'];
                    $end_date = $_POST['end_date'];
                    $end_time = $_POST['end_time'];

                    $gravida = $_POST['gravida'];
                    $para = $_POST['para'];
                    $abortion = $_POST['abortions'];
                    $induced = $_POST['induced'];
                    $spontaneous = $_POST['spontaneous'];
                    $lmp = $_POST['lmp'];

                    $edd = $_POST['edd'];
                    $blood_group = $_POST['blood_group'];
                    $sickling = $_POST['sickling'];
                    $geno_type = $_POST['geno_type'];
                    $gestation_age = $_POST['gestation_age'];
                    $no_of_anc_visits = $_POST['no_of_anc_visits'];
                    $syphillis = $_POST['syphillis'];
                    $heb_b = $_POST['heb_b'];
                    $pmtct = $_POST['pmtct'];

                    $an_cort = $_POST['an_cort'];
                    $other_interventions = $_POST['other_interventions'];
                    $bp_systolic = $_POST['bp_systolic'];
                    $bp_diastolic = $_POST['bp_diastolic'];
                    $pulse = $_POST['pulse'];
                    $temp = $_POST['temp'];
                    $fhr = $_POST['fhr'];
                    $lie_present = $_POST['lie_present'];
                    $cervical_dilitation = $_POST['cervical_dilitation'];

                    $partograph_used = $_POST['partograph_used'];
                    $perineum = $_POST['perineum'];
                    $auxilliary_temp = $_POST['auxilliary_temp'];
                    $stillbirth = $_POST['stillbirth'];
                    $labour_complication = $_POST['labour_complication'];
                    $apgar_score = $_POST['apgar_score'];
                    $Mode_of_delivery = $_POST['Mode_of_delivery'];
                    $cs_on_account = $_POST['cs_on_account'];
                    $oxytocin_10min = $_POST['oxytocin_10min'];
                    $oxytocin_time = $_POST['oxytocin_time'];
                    $est_blood_loss = $_POST['est_blood_loss'];
                    $placenta_time = $_POST['placenta_time'];
                    $placenta_state = $_POST['placenta_state'];
                    $labour_type = $_POST['labour_type'];
                    $outcome = $_POST['outcome'];
                    $condition = $_POST['condition'];
                    $post_partum = $_POST['post_partum'];

                    $bp_systolic_post = $_POST['bp_systolic_post'];
                    $bp_diastolic_post = $_POST['bp_diastolic_post'];
                    $pulse_post = $_POST['pulse_post'];
                    $temp_post = $_POST['temp_post'];
                    $resp_rate_post = $_POST['resp_rate_post'];
                    $vit_a_post = $_POST['vit_a_post'];
                    $mother_state = $_POST['mother_state'];
                    $transferred_to = $_POST['transferred_to'];
                    $transferred_date = $_POST['transferred_date'];
                    $transferred_time = $_POST['transferred_time'];
                    $post_mother_comment = $_POST['post_mother_comment'];
                    $delivered_by = $_POST['delivered_by'];
                    $designation = $_POST['designation'];
                    $delivered_date = $_POST['delivered_date'];
                    $delivered_time = $_POST['delivered_time'];
                    $final_comment = $_POST['final_comment'];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];
                    
                    $query = "INSERT INTO `preg_delivery`(
                    `company_id`, `patient_id`, `attend_id`, `preg_id`, `date_start`, `time_start`, `date_end`, `time_end`, `gravida`, `para`, `abortion`, `induced`, 
                    `spontaneous`, `lmp`, `edd`, `anc_visit`, `blood_group`, `sickling_status`, `geno_type`, `gentation_age`, `syphillis`, `hepb`, `pmtct`, `an_cort`, 
                    `intervention`, `complication`, `bp_systolic`, `bp_daistolic`, `pulse`, `temp`, `fhr`, `lie_present`, `cervical_dilation`, `partograph_used`, 
                    `perineum`, `auxilliary_temp`, `sb`, `apgar_score`, `mode_of_delivery`, `cs_on_account`, `oxytocin_10min`, `time_oxy_given`, `est_blood_loss`, 
                    `time_placenta`, `state_placenta`, `bp_systolic_post`, `bp_daistolic_post`, `temp_post`, `pulse_post`, `resp_post`, `vit_a`, `state`, `trans_ref`, 
                    `trans_ref_date`, `trans_ref_time`, `comment_post`, `delivered_by`, `designation`, `delivery_date`, `delivery_time`, `delivery_comment`, `labour_type`, 
                    `outcome`, `labour_condition`, `post_partum`,`branch_id`, `created_by`, `created_datetime`) 
                    VALUES (
                    '$company_id','$patient_id','$attend_id','$preg_id','$start_date','$start_time','$end_date','$end_time','$gravida','$para','$abortion','$induced','$spontaneous',
                    '$lmp','$edd','$no_of_anc_visits','$blood_group','$sickling','$geno_type','$gestation_age','$syphillis','$heb_b','$pmtct','$an_cort',
                    '$other_interventions','$labour_complication','$bp_systolic','$bp_diastolic','$pulse','$temp','$fhr','$lie_present','$cervical_dilitation',
                    '$partograph_used','$perineum','$auxilliary_temp','$stillbirth','$apgar_score','$Mode_of_delivery','$cs_on_account','$oxytocin_10min',
                    '$oxytocin_time','$est_blood_loss','$placenta_time','$placenta_state','$bp_systolic_post','$bp_diastolic_post','$temp_post','$pulse_post',
                    '$resp_rate_post','$vit_a_post','$mother_state','$transferred_to','$transferred_date','$transferred_time','$post_mother_comment','$delivered_by',
                    '$designation','$delivered_date','$delivered_time','$final_comment',
                    '$labour_type','$outcome','$condition','$post_partum','$branch_id','$user_id',NOW())";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        $_SESSION['delivery_state'] = 'exist';
                        $query_child = "SELECT * FROM preg_child WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
                        $result_child = mysqli_query($con,$query_child);
                        if(mysqli_num_rows($result_child) > 0)
                        {
                            $row_child=mysqli_fetch_assoc($result_child);
                            $gender = $row_child['sex'];
                            $weight = $row_child['weight'];
                            $height = $row_child['length'];
                        }
                        else
                        {
                            $Gender = 0;
                            $weight = 0;
                            $height = 0;
                        };
                        $query_preg = "UPDATE `pregnancies` SET
                        `delivery_date`='$end_date', `method`='$Mode_of_delivery', `labour_type`='$labour_type', `outcome`='$outcome', 
                        `condition_delivery`='$condition',`problems`='$labour_complication', `post_partum`='$post_partum', 
                        `gender_1`='$gender',`weight_1`='$weight', `height_1`='$height', `gestation_age`='$gestation_age'
                        WHERE `preg_id`='$preg_id'";
                        $query_run_preg = mysqli_query($con, $query_preg);
                    }
                    else
                    {
                        echo "Delivery NOT Added";
                    };
                }

                function delivery_view()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $attend_id = $_POST['attend_id'];
                    $preg_id = $_POST['preg_id'];
                    $Data=array();
                    $value = "";
                    
                    $query = "SELECT * FROM preg_delivery WHERE preg_id='$preg_id'";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                                        <tbody class="pv-table-body">
                                            <tr style="background-color:#E4E1E0">
                                                <th>Date Start</th>
                                                <th>Time Start</th>
                                                <th colspan="7"></th>
                                                <th>Date End</th>
                                                <th>Time End</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['date_start'].'
                                                </td>
                                                <td>
                                                    '.$row['time_start'].'
                                                </td>
                                                <td colspan="7">
                                                    
                                                </td>
                                                <td>
                                                    '.$row['date_end'].'
                                                </td>
                                                <td>
                                                    '.$row['time_end'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Gravida</th>
                                                <th>Para</th>
                                                <th>Abortions</th>
                                                <th>Induced</th>
                                                <th>Spontaneous</th>
                                                <th>LMP</th>
                                                <th>EDD</th>
                                                <th>Blood Group</th>
                                                <th>Sickling</th>
                                                <th colspan="2">Geno Type</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['gravida'].'
                                                </td>
                                                <td>
                                                    '.$row['para'].'
                                                </td>
                                                <td>
                                                    '.$row['abortion'].'
                                                </td>
                                                <td>
                                                    '.$row['induced'].'
                                                </td>
                                                <td>
                                                    '.$row['spontaneous'].'
                                                </td>
                                                <td>
                                                    '.$row['lmp'].'
                                                </td>
                                                <td>
                                                    '.$row['edd'].'
                                                </td>
                                                <td>
                                                    '.$row['blood_group'].'
                                                </td>
                                                <td>
                                                    '.$row['sickling_status'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['geno_type'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Gestation Age</th>
                                                <th>ANC Visits</th>
                                                <th>Syphillis</th>
                                                <th>Heb B</th>
                                                <th>PMTCT</th>
                                                <th>AN Cort</th>
                                                <th>SB</th>
                                                <th>Labour Complication</th>
                                                <th colspan="3">Other Interventions</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['gentation_age'].'
                                                </td>
                                                <td>
                                                    '.$row['anc_visit'].'
                                                </td>
                                                <td>
                                                    '.$row['syphillis'].'
                                                </td>
                                                <td>
                                                    '.$row['hepb'].'
                                                </td>
                                                <td>
                                                    '.$row['pmtct'].'
                                                </td>
                                                <td>
                                                    '.$row['an_cort'].'
                                                </td>
                                                <td>
                                                    '.$row['sb'].'
                                                </td>
                                                <td>
                                                    '.$row['complication'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['intervention'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>BP-Systolic</th>
                                                <th>BP-Diastolic</th>
                                                <th>Pulse</th>
                                                <th>Temp</th>
                                                <th>FHR</th>
                                                <th>Lie & Present.</th>
                                                <th>Cervical Dilitation</th>
                                                <th>Parto. Used</th>
                                                <th>Perineum</th>
                                                <th>Aux. Temp</th>
                                                <th>Apgar Score</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['bp_systolic'].'
                                                </td>
                                                <td>
                                                    '.$row['bp_daistolic'].'
                                                </td>
                                                <td>
                                                    '.$row['pulse'].'
                                                </td>
                                                <td>
                                                    '.$row['temp'].'
                                                </td>
                                                <td>
                                                    '.$row['fhr'].'
                                                </td>
                                                <td>
                                                    '.$row['lie_present'].'
                                                </td>
                                                <td>
                                                    '.$row['cervical_dilation'].'
                                                </td>
                                                <td>
                                                    '.$row['partograph_used'].'
                                                </td>
                                                <td>
                                                    '.$row['perineum'].'
                                                </td>
                                                <td>
                                                    '.$row['auxilliary_temp'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_score'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Mode of Delivery</th>
                                                <th colspan="5">CS on account of</th>
                                                <th>Oxytocin-10min</th>
                                                <th>Oxytocin Time</th>
                                                <th>Est. Blood Loss</th>
                                                <th>Placenta Delivery time</th>
                                                <th>State of Placenta</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['mode_of_delivery'].'
                                                </td>
                                                <td colspan="5">
                                                    '.$row['cs_on_account'].'
                                                </td>
                                                <td>
                                                    '.$row['oxytocin_10min'].'
                                                </td>
                                                <td>
                                                    '.$row['time_oxy_given'].'
                                                </td>
                                                <td>
                                                    '.$row['est_blood_loss'].'
                                                </td>
                                                <td>
                                                    '.$row['time_placenta'].'
                                                </td>
                                                <td>
                                                    '.$row['state_placenta'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th colspan="3">Labour Type</th>
                                                <th colspan="2">Outcome</th>
                                                <th colspan="3">Condition</th>
                                                <th colspan="3">Post Partum</th>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    '.$row['labour_type'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['outcome'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['labour_condition'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['post_partum'].'
                                                </td>
                                            </tr>
                                            <tr class="text-center">
                                                <th colspan="11"><h6 class="m-0 font-weight-bold text-primary">POST DELIVERY</h6></th>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th colspan="2">BP-Systolic</th>
                                                <th colspan="2">BP-Diastolic</th>
                                                <th colspan="2">Pulse</th>
                                                <th colspan="2">Temp</th>
                                                <th colspan="2">Resp. Rate</th>
                                                <th>Vitamin A</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    '.$row['bp_systolic_post'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['bp_daistolic_post'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['pulse_post'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['temp_post'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['resp_post'].'
                                                </td>
                                                <td>
                                                    '.$row['vit_a'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th colspan="2">State of Mother</th>
                                                <th colspan="2">Transferred To</th>
                                                <th colspan="2">Transferred Date</th>
                                                <th colspan="2">Transferred Date</th>
                                                <th colspan="3">Comment</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    '.$row['state'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['trans_ref'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['trans_ref_date'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['trans_ref_time'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['comment_post'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th colspan="2">Delivered By</th>
                                                <th colspan="2">Designation</th>
                                                <th colspan="2">Delivery Date</th>
                                                <th colspan="2">Delivery Time</th>
                                                <th colspan="3">Comment</th>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    '.$row['delivered_by'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['designation'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['delivery_date'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['delivery_time'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['delivery_comment'].'
                                                </td>
                                            </tr>';
                                                }
                                $value.='</tbody>
                                    </table>';
                            echo $value;
                                        };
                }

                function delivery_edit()
                {
                    global $con;
                    $preg_id = $_POST['preg_id'];
                    $patient_id = $_POST['patient_id'];
                    $Data=array();
                    $query = "SELECT * FROM preg_delivery WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
                    $result = mysqli_query($con,$query);
                    while($row=mysqli_fetch_assoc($result))
                    {
                        array_push($Data, 
                            $row['delivery_id'],$row['patient_id'],$row['attend_id'],$row['preg_id'],$row['date_start'],$row['time_start'],$row['date_end'],
                            $row['time_end'],$row['gravida'],$row['para'],$row['abortion'],$row['induced'],$row['spontaneous'],$row['lmp'],$row['edd'],
                            $row['anc_visit'],$row['blood_group'],$row['sickling_status'],$row['geno_type'],$row['gentation_age'],$row['syphillis'],$row['hepb'],
                            $row['pmtct'],$row['an_cort'],$row['intervention'],$row['complication'],$row['bp_systolic'],$row['bp_daistolic'],$row['pulse'],$row['temp'],
                            $row['fhr'],$row['lie_present'],$row['cervical_dilation'],$row['partograph_used'],$row['perineum'],$row['auxilliary_temp'],$row['sb'],
                            $row['apgar_score'],$row['mode_of_delivery'],$row['cs_on_account'],$row['oxytocin_10min'],$row['time_oxy_given'],$row['est_blood_loss'],
                            $row['time_placenta'],$row['state_placenta'],$row['bp_systolic_post'],$row['bp_daistolic_post'],$row['temp_post'],$row['pulse_post'],
                            $row['resp_post'],$row['vit_a'],$row['state'],$row['trans_ref'],$row['trans_ref_date'],$row['trans_ref_time'],$row['comment_post'],
                            $row['delivered_by'],$row['designation'],$row['delivery_date'],$row['delivery_time'],$row['delivery_comment'],$row['labour_type'],$row['outcome'],$row['labour_condition'],$row['post_partum']
                        );
                    }
                    $_SESSION['delivery_state'] = 'exist';
                    echo json_encode($Data);
                }

                function delivery_update()
                {
                    global $con;
                    $delivery_id = $_POST['delivery_id'];
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];

                    $start_date = $_POST['start_date'];
                    $start_time = $_POST['start_time'];
                    $end_date = $_POST['end_date'];
                    $end_time = $_POST['end_time'];

                    $gravida = $_POST['gravida'];
                    $para = $_POST['para'];
                    $abortion = $_POST['abortions'];
                    $induced = $_POST['induced'];
                    $spontaneous = $_POST['spontaneous'];
                    $lmp = $_POST['lmp'];

                    $edd = $_POST['edd'];
                    $blood_group = $_POST['blood_group'];
                    $sickling = $_POST['sickling'];
                    $geno_type = $_POST['geno_type'];
                    $gestation_age = $_POST['gestation_age'];
                    $no_of_anc_visits = $_POST['no_of_anc_visits'];
                    $syphillis = $_POST['syphillis'];
                    $heb_b = $_POST['heb_b'];
                    $pmtct = $_POST['pmtct'];

                    $an_cort = $_POST['an_cort'];
                    $other_interventions = $_POST['other_interventions'];
                    $bp_systolic = $_POST['bp_systolic'];
                    $bp_diastolic = $_POST['bp_diastolic'];
                    $pulse = $_POST['pulse'];
                    $temp = $_POST['temp'];
                    $fhr = $_POST['fhr'];
                    $lie_present = $_POST['lie_present'];
                    $cervical_dilitation = $_POST['cervical_dilitation'];

                    $partograph_used = $_POST['partograph_used'];
                    $perineum = $_POST['perineum'];
                    $auxilliary_temp = $_POST['auxilliary_temp'];
                    $stillbirth = $_POST['stillbirth'];
                    $labour_complication = $_POST['labour_complication'];
                    $apgar_score = $_POST['apgar_score'];
                    $Mode_of_delivery = $_POST['Mode_of_delivery'];
                    $cs_on_account = $_POST['cs_on_account'];
                    $oxytocin_10min = $_POST['oxytocin_10min'];
                    $oxytocin_time = $_POST['oxytocin_time'];
                    $est_blood_loss = $_POST['est_blood_loss'];
                    $placenta_time = $_POST['placenta_time'];
                    $placenta_state = $_POST['placenta_state'];
                    $labour_type = $_POST['labour_type'];
                    $outcome = $_POST['outcome'];
                    $condition = $_POST['condition'];
                    $post_partum = $_POST['post_partum'];

                    $bp_systolic_post = $_POST['bp_systolic_post'];
                    $bp_diastolic_post = $_POST['bp_diastolic_post'];
                    $pulse_post = $_POST['pulse_post'];
                    $temp_post = $_POST['temp_post'];
                    $resp_rate_post = $_POST['resp_rate_post'];
                    $vit_a_post = $_POST['vit_a_post'];
                    $mother_state = $_POST['mother_state'];
                    $transferred_to = $_POST['transferred_to'];
                    $transferred_date = $_POST['transferred_date'];
                    $transferred_time = $_POST['transferred_time'];
                    $post_mother_comment = $_POST['post_mother_comment'];
                    $delivered_by = $_POST['delivered_by'];
                    $designation = $_POST['designation'];
                    $delivered_date = $_POST['delivered_date'];
                    $delivered_time = $_POST['delivered_time'];
                    $final_comment = $_POST['final_comment'];
                    $user_id = $_SESSION['user_id'];
                    
                    $query = "UPDATE `preg_delivery` SET
                    `patient_id`='$patient_id', `attend_id`='$attend_id', `preg_id`='$preg_id', `date_start`='$start_date', `time_start`='$start_time', 
                    `date_end`='$end_date',`time_end`='$end_time', `gravida`='$gravida', `para`='$para', `abortion`='$abortion', `induced`='$induced', 
                    `spontaneous`='$spontaneous', `lmp`='$lmp', `edd`='$edd', `anc_visit`='$no_of_anc_visits', `blood_group`='$blood_group', 
                    `sickling_status`='$sickling', `geno_type`='$geno_type', `gentation_age`='$gestation_age', `syphillis`='$syphillis', `hepb`='$heb_b', 
                    `pmtct`='$pmtct', `an_cort`='$an_cort', `intervention`='$other_interventions', `complication`='$labour_complication', `bp_systolic`='$bp_systolic',
                    `bp_daistolic`='$bp_diastolic', `pulse`='$pulse', `temp`='$temp', `fhr`='$fhr', `lie_present`='$lie_present', 
                    `cervical_dilation`='$cervical_dilitation', `partograph_used`='$partograph_used', `perineum`='$perineum', `auxilliary_temp`='$auxilliary_temp', 
                    `sb`='$stillbirth', `apgar_score`='$apgar_score', `mode_of_delivery`='$Mode_of_delivery', `cs_on_account`='$cs_on_account', 
                    `oxytocin_10min`='$oxytocin_10min', `time_oxy_given`='$oxytocin_time', `est_blood_loss`='$est_blood_loss', `time_placenta`='$placenta_time', 
                    `state_placenta`='$placenta_state', `bp_systolic_post`='$bp_systolic_post', `bp_daistolic_post`='$bp_diastolic_post', `temp_post`='$temp_post', 
                    `pulse_post`='$pulse_post', `resp_post`='$resp_rate_post', `vit_a`='$vit_a_post', `state`='$mother_state', `trans_ref`='$transferred_to', 
                    `trans_ref_date`='$transferred_date', `trans_ref_time`='$transferred_time', `comment_post`='$post_mother_comment', `delivered_by`='$delivered_by', 
                    `designation`='$designation', `delivery_date`='$delivered_date', `delivery_time`='$delivered_time', `delivery_comment`='$final_comment', 
                    `labour_type`='$labour_type', `outcome`='$outcome', `labour_condition`='$condition', `post_partum`='$post_partum',
                    `altered_by`='$user_id', `altered_datetime`=NOW() 
                    WHERE `delivery_id`='$delivery_id'";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        $query_child = "SELECT * FROM preg_child WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
                        $result_child = mysqli_query($con,$query_child);
                        if(mysqli_num_rows($result_child) > 0)
                        {
                            $row_child=mysqli_fetch_assoc($result_child);
                            $gender = $row_child['sex'];
                            $weight = $row_child['weight'];
                            $height = $row_child['length'];
                        }
                        else
                        {
                            $Gender = 0;
                            $weight = 0;
                            $height = 0;
                        };
                        $query_preg = "UPDATE `pregnancies` SET
                        `delivery_date`='$end_date', `method`='$Mode_of_delivery', `labour_type`='$labour_type', `outcome`='$outcome', 
                        `condition_delivery`='$condition',`problems`='$labour_complication', `post_partum`='$post_partum', 
                        `gender_1`='$gender',`weight_1`='$weight', `height_1`='$height', `gestation_age`='$gestation_age'
                        WHERE `preg_id`='$preg_id'";
                        $query_run_preg = mysqli_query($con, $query_preg);
                    }
                    else
                    {
                        echo "Delivery NOT Updated";
                    };
                }
            //PARTOGRAPH
                function parto_fhr_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['parto_fhr_date'];
                    $time = $_POST['parto_fhr_time'];
                    $value = $_POST['parto_fhr_value'];
                    $parto_amniotic_value = $_POST['parto_amniotic_v'];
                    $parto_moulding_value = $_POST['parto_moulding_v'];
                    $parto_cd_cervix = $_POST['parto_cd_cervix_v'];
                    $parto_cd_descent = $_POST['parto_cd_descent_v'];
                    $parto_contra_less20 = $_POST['parto_contra_less20_v'];
                    $parto_contra_2040 = $_POST['parto_contra_2040_v'];
                    $parto_contra_more40 = $_POST['parto_contra_more40_v'];
                    $parto_oxy_vol = $_POST['parto_oxy_vol_v'];
                    $parto_oxy_drops = $_POST['parto_oxy_drops_v'];
                    $parto_drug_name = $_POST['parto_drug_name_v'];
                    $parto_drug_qty = $_POST['parto_drug_qty_v'];
                    $parto_pbp_pulse = $_POST['parto_pbp_pulse_v'];
                    $parto_pbp_systolic = $_POST['parto_pbp_systolic_v'];
                    $parto_pbp_diastolic = $_POST['parto_pbp_diastolic_v'];
                    $parto_temp = $_POST['parto_temp_v'];
                    $parto_urine_protein = $_POST['parto_urine_protein_v'];
                    $parto_urine_acetone = $_POST['parto_urine_acetone_v'];
                    $parto_urine_sugar = $_POST['parto_urine_sugar_v'];
                    $parto_urine_volume = $_POST['parto_urine_volume_v'];
                    $read_by = $_POST['parto_fhr_read_by'];
                    $remarks = $_POST['parto_fhr_remarks'];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];
                    
                    $query = "INSERT INTO `parto_fhr`(
                    `company_id`, `patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `value`, 
                    `read_by`, `remarks`,`moulding`, `amiotic_fluid`, `cervix`, `descent`, `contra_less_20`, 
                    `contra_20_40`, `contra_more_40`, `temp`, `pulse`, `bp_systolic`,`bp_diastolic`, 
                    `urine_protein`, `urine_acetone`, `urine_sugar`, `urine_volume`, `drug`, 
                    `drug_qty`, `oxytocin_volume`, `oxytocin_drop`,`company_id`, `branch_id`, `created_by`,
                    `created_datetime`) 
                    VALUES (
                    '$company_id','$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$value',
                    '$read_by','$remarks','$parto_moulding_value','$parto_amniotic_value','$parto_cd_cervix',
                    '$parto_cd_descent','$parto_contra_less20','$parto_contra_2040','$parto_contra_more40',
                    '$parto_temp','$parto_pbp_pulse','$parto_pbp_systolic','$parto_pbp_diastolic',
                    '$parto_urine_protein','$parto_urine_acetone','$parto_urine_sugar','$parto_urine_volume',
                    '$parto_drug_name','$parto_drug_qty','$parto_oxy_vol','$parto_oxy_drops',
                    '$company_id','$branch_id','$user_id',NOW())";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto-FHR Added Successfully";
                    }
                    else
                    {
                        echo "Parto-FHR NOT Added";
                    };
                }

                function parto_fhr_view()
                {
                    /*global $con;
                        $patient_id = $_POST['patient_id'];
                        $preg_id = $_POST['preg_id'];
                        $delivery_id = $_POST['delivery_id'];
                        $value = "";
                        $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Time</th>
                                            <th>FHR</th>
                                            <th>Amiotic</th>
                                            <th>Moulding</th>
                                            <th>Cervix</th>
                                            <th>Descent</th>
                                            <th><20</th>
                                            <th>20-40</th>
                                            <th>>40</th>
                                            <th>Oxy. Vol</th>
                                            <th>Oxy. Drop</th>
                                            <th>Drug</th>
                                            <th>D.Qty</th>
                                            <th>Pulse</th>
                                            <th>BP-S</th>
                                            <th>BP-D</th>
                                            <th>Temp</th>
                                            <th>U. Protein</th>
                                            <th>U. Acetone</th>
                                            <th>U. Sugar</th>
                                            <th>U. Vol</th>
                                            <th>Read by</th>
                                            <th>Remarks</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                  <tbody class="pv-table-body">';
                        $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                        $query_run = mysqli_query($con, $query);
                        if (mysqli_num_rows($query_run) > 0)
                        {
                            while($row=mysqli_fetch_assoc($query_run))
                            {
                                $value.='<tr>
                                            <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                            <td>'.$row['time'].'</td>
                                            <td>'.$row['value'].'</td>
                                            <td>'.$row['amiotic_fluid'].'</td>
                                            <td>'.$row['moulding'].'</td>
                                            <td>'.$row['cervix'].'</td>
                                            <td>'.$row['descent'].'</td>
                                            <td>'.$row['contra_less_20'].'</td>
                                            <td>'.$row['contra_20_40'].'</td>
                                            <td>'.$row['contra_more_40'].'</td>
                                            <td>'.$row['oxytocin_volume'].'</td>
                                            <td>'.$row['oxytocin_drop'].'</td>
                                            <td>'.$row['drug'].'</td>
                                            <td>'.$row['drug_qty'].'</td>
                                            <td>'.$row['pulse'].'</td>
                                            <td>'.$row['bp_systolic'].'</td>
                                            <td>'.$row['bp_diastolic'].'</td>
                                            <td>'.$row['temp'].'</td>
                                            <td>'.$row['urine_protein'].'</td>
                                            <td>'.$row['urine_acetone'].'</td>
                                            <td>'.$row['urine_sugar'].'</td>
                                            <td>'.$row['urine_volume'].'</td>
                                            <td>'.$row['read_by'].'</td>
                                            <td>'.$row['remarks'].'</td>
                                            <td>
                                                <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                            </td>
                                        </tr>';
                            }
                        };
                        $value.='</tbody>
                                </table>';
                        echo $value;*/
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND value !='' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">FETAL HEART RATE</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>FHR</th>
                                        <th>Read by</th>
                                        <th colspan="4">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            
                            $value.='
                                    <tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['value'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="4">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (amiotic_fluid !='' OR moulding !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">AMIOTIC FLUID AND MOULDING</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Amiotic</th>
                                        <th>Moulding</th>
                                        <th>Read by</th>
                                        <th colspan="3">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['amiotic_fluid'].'</td>
                                        <td>'.$row['moulding'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="3">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (cervix !='' OR descent !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">CERVIX AND DESCENT</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Cervix</th>
                                        <th>Descent</th>
                                        <th>Read by</th>
                                        <th colspan="3">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['cervix'].'</td>
                                        <td>'.$row['descent'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="3">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (contra_less_20 !='' OR contra_20_40 !='' OR contra_more_40 !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">CONTRACTIONS</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th><20</th>
                                        <th>20-40</th>
                                        <th>>40</th>
                                        <th>Read by</th>
                                        <th colspan="2">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['contra_less_20'].'</td>
                                        <td>'.$row['contra_20_40'].'</td>
                                        <td>'.$row['contra_more_40'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="2">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (oxytocin_volume !='' OR oxytocin_drop !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">OXYTOCIN</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Volume</th>
                                        <th>Drops/min</th>
                                        <th>Read by</th>
                                        <th colspan="3">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['oxytocin_volume'].'</td>
                                        <td>'.$row['oxytocin_drop'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="3">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (drug !='' OR drug_qty !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">DRUGS GIVEN AND IV FLUIDS</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Drug</th>
                                        <th>Qty</th>
                                        <th>Read by</th>
                                        <th colspan="3">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['drug'].'</td>
                                        <td>'.$row['drug_qty'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="3">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (pulse !='' OR bp_systolic !='' OR bp_diastolic !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">PULSE AND BP</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Pulse</th>
                                        <th>BP-Systolic</th>
                                        <th>BP-Daistolic</th>
                                        <th>Read by</th>
                                        <th colspan="2">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                                    $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['pulse'].'</td>
                                        <td>'.$row['bp_systolic'].'</td>
                                        <td>'.$row['bp_diastolic'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="2">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND temp !='' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">TEMPERATURE</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Temp</th>
                                        <th>Read by</th>
                                        <th colspan="4">Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['temp'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td colspan="4">'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };

                    $query = "SELECT * FROM parto_fhr WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' AND (urine_protein !='' OR urine_acetone !='' OR urine_sugar !='' OR urine_volume !='') ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                            $value.='<tr style="background-color:#E4E1E0">
                                        <th colspan="9">URINE</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Protein</th>
                                        <th>Acetone</th>
                                        <th>Sugar</th>
                                        <th>Volume</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>';
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_fhr" data-id="'.$row['parto_fhr_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['urine_protein'].'</td>
                                        <td>'.$row['urine_acetone'].'</td>
                                        <td>'.$row['urine_sugar'].'</td>
                                        <td>'.$row['urine_volume'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_fhr_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        };
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_fhr_edit()
                {
                    global $con;
                    $parto_fhr_id = $_POST['parto_fhr_id'];
                    $Data=array();
                    $query = "SELECT * FROM parto_fhr WHERE parto_fhr_id='$parto_fhr_id'";
                    $result = mysqli_query($con,$query);
                    while($row=mysqli_fetch_assoc($result))
                    {
                        array_push($Data, 
                            $row['parto_fhr_id'],$row['date'],$row['time'],$row['value'],$row['moulding'],$row['amiotic_fluid'],$row['cervix'],$row['descent'],
                            $row['contra_less_20'],$row['contra_20_40'],$row['contra_more_40'],$row['temp'],$row['pulse'],$row['bp_systolic'],$row['bp_diastolic'],
                            $row['urine_protein'],$row['urine_acetone'],$row['urine_sugar'],$row['urine_volume'],$row['drug'],$row['drug_qty'],$row['oxytocin_volume'],
                            $row['oxytocin_drop'],$row['read_by'],$row['remarks']
                        );
                    }
                     echo json_encode($Data);
                }

                function parto_fhr_update()
                {
                    global $con;
                    $parto_fhr_id = $_POST['parto_fhr_id'];
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['parto_fhr_date'];
                    $time = $_POST['parto_fhr_time'];
                    $value = $_POST['parto_fhr_value'];
                    $parto_amniotic_value = $_POST['parto_amniotic_v'];
                    $parto_moulding_value = $_POST['parto_moulding_v'];
                    $parto_cd_cervix = $_POST['parto_cd_cervix_v'];
                    $parto_cd_descent = $_POST['parto_cd_descent_v'];
                    $parto_contra_less20 = $_POST['parto_contra_less20_v'];
                    $parto_contra_2040 = $_POST['parto_contra_2040_v'];
                    $parto_contra_more40 = $_POST['parto_contra_more40_v'];
                    $parto_oxy_vol = $_POST['parto_oxy_vol_v'];
                    $parto_oxy_drops = $_POST['parto_oxy_drops_v'];
                    $parto_drug_name = $_POST['parto_drug_name_v'];
                    $parto_drug_qty = $_POST['parto_drug_qty_v'];
                    $parto_pbp_pulse = $_POST['parto_pbp_pulse_v'];
                    $parto_pbp_systolic = $_POST['parto_pbp_systolic_v'];
                    $parto_pbp_diastolic = $_POST['parto_pbp_diastolic_v'];
                    $parto_temp = $_POST['parto_temp_v'];
                    $parto_urine_protein = $_POST['parto_urine_protein_v'];
                    $parto_urine_acetone = $_POST['parto_urine_acetone_v'];
                    $parto_urine_sugar = $_POST['parto_urine_sugar_v'];
                    $parto_urine_volume = $_POST['parto_urine_volume_v'];
                    $read_by = $_POST['parto_fhr_read_by'];
                    $remarks = $_POST['parto_fhr_remarks'];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];
                    
                    $query = "UPDATE `parto_fhr`SET
                    `date`='$date', `time`='$time', `value`='$value', `read_by`='$read_by', `remarks`='$remarks',
                    `moulding`='$parto_moulding_value', `amiotic_fluid`='$parto_amniotic_value', `cervix`='$parto_cd_cervix', 
                    `descent`='$parto_cd_descent', `contra_less_20`='$parto_contra_less20', 
                    `contra_20_40`='$parto_contra_2040', `contra_more_40`='$parto_contra_more40', 
                    `temp`='$parto_temp', `pulse`='$parto_pbp_pulse', `bp_systolic`='$parto_pbp_systolic',
                    `bp_diastolic`='$parto_pbp_diastolic', `urine_protein`='$parto_urine_protein', 
                    `urine_acetone`='$parto_urine_acetone', `urine_sugar`='$parto_urine_sugar', 
                    `urine_volume`='$parto_urine_volume', `drug`='$parto_drug_name', `drug_qty`='$parto_drug_qty', 
                    `oxytocin_volume`='$parto_oxy_vol', `oxytocin_drop`= '$parto_oxy_drops',
                    `altered_by`='$user_id', `altered_datetime`= NOW()
                    WHERE  `parto_fhr_id`= '$parto_fhr_id'";

                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto-FHR Added Successfully";
                    }
                    else
                    {
                        echo "Parto-FHR NOT Added";
                    };
                }

                /*function parto_amniotic_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $value = $_POST['value'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_amniotic`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `amniotic`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$value','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto-FHR Added Successfully";
                    }
                    else
                    {
                        echo "Parto-FHR NOT Added";
                    };
                }

                function parto_amniotic_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Amniotic Fluid</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_amniotic WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_amniotic" data-id="'.$row['parto_amniotic_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['amniotic'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_amniotic" data-id="'.$row['parto_amniotic_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_moulding_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $value = $_POST['value'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_moulding`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `moulding`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$value','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Moulding Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Moulding NOT Added";
                    };
                }

                function parto_moulding_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Moulding</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_moulding WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_moulding" data-id="'.$row['parto_moulding_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['moulding'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_moulding" data-id="'.$row['parto_moulding_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_cervix_descent_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $cervix = $_POST['cervix'];
                    $descent = $_POST['descent'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_cervix_descent`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `cervix`, `descent`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$cervix','$descent','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Cervix/Descent Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Cervix/Descent NOT Added";
                    };
                }

                function parto_cervix_descent_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Cervix</th>
                                        <th>Descent</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_cervix_descent WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_cd" data-id="'.$row['parto_cd_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['cervix'].'</td>
                                        <td>'.$row['descent'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_cd" data-id="'.$row['parto_cd_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_contractions_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $contra_less_than_20 = $_POST['contra_less_than_20'];
                    $contra_20_t0_40 = $_POST['contra_20_t0_40'];
                    $contra_more_than_40 = $_POST['contra_more_than_40'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_contractions`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `contra_less_than_20`, `contra_20_to_40`, `contra_more_than_40`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$contra_less_than_20','$contra_20_t0_40','$contra_more_than_40','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Contractions Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Contractions NOT Added";
                    };
                }

                function parto_contractions_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>less than 20</th>
                                        <th>20 to 40</th>
                                        <th>more than 40</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_contractions WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_contra" data-id="'.$row['parto_contra_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['contra_less_than_20'].'</td>
                                        <td>'.$row['contra_20_to_40'].'</td>
                                        <td>'.$row['contra_more_than_40'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_contra" data-id="'.$row['parto_contra_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_oxytocin_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $volume = $_POST['volume'];
                    $drops = $_POST['drops'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_oxytocin`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `volume`, `drops`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$volume','$drops','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Oxytocin Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Oxytocin NOT Added";
                    };
                }

                function parto_oxytocin_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Volume</th>
                                        <th>Drops/min</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_oxytocin WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_oxy" data-id="'.$row['parto_oxy_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['volume'].'</td>
                                        <td>'.$row['drops'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_oxy" data-id="'.$row['parto_oxy_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_drugs_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $drug = $_POST['drug'];
                    $qty = $_POST['qty'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_drugs`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `drug`, `qty`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$drug','$qty','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Drug Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Drug NOT Added";
                    };
                }

                function parto_drugs_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Drug</th>
                                        <th>Qty</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_drugs WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_drug" data-id="'.$row['parto_drug_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['drug'].'</td>
                                        <td>'.$row['qty'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_drug" data-id="'.$row['parto_drug_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_pulse_bp_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $pulse = $_POST['pulse'];
                    $bp_systolic = $_POST['bp_systolic'];
                    $bp_diastolic = $_POST['bp_diastolic'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_pulse_bp`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `pulse`, `bp_systolic`, `bp_diastolic`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$pulse','$bp_systolic','$bp_diastolic','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Pulse/BP Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Pulse/BP NOT Added";
                    };
                }

                function parto_pulse_bp_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Pulse</th>
                                        <th>BP-Systolic</th>
                                        <th>BP-Diastolic</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_pulse_bp WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_bp" data-id="'.$row['parto_pbp_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['pulse'].'</td>
                                        <td>'.$row['bp_systolic'].'</td>
                                        <td>'.$row['bp_diastolic'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_pbp" data-id="'.$row['parto_pbp_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_temp_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $temp = $_POST['temp'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_temp`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `temp`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$temp','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Temperature Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Temperature NOT Added";
                    };
                }

                function parto_temp_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Temp</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_temp WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_temp" data-id="'.$row['parto_temp_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['temp'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_temp" data-id="'.$row['parto_temp_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }

                function parto_urine_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $date = $_POST['date'];
                    $time = $_POST['time'];
                    $protein = $_POST['protein'];
                    $acetone = $_POST['acetone'];
                    $sugar = $_POST['sugar'];
                    $volume = $_POST['volume'];
                    $read_by = $_POST['read_by'];
                    $remarks = $_POST['remarks'];
                    
                    $query = "INSERT INTO `parto_urine`(`patient_id`, `attend_id`, `preg_id`, `delivery_id`, `date`, `time`, `protein`, `acetone`, `sugar`, `volume`, `read_by`, `remarks`) 
                    VALUES ('$patient_id','$attend_id','$preg_id','$delivery_id','$date','$time','$protein','$acetone','$sugar','$volume','$read_by','$remarks')";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Parto - Urine Added Successfully";
                    }
                    else
                    {
                        echo "Parto - Urine NOT Added";
                    };
                }

                function parto_urine_view()
                {
                    global $con;
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $value = "";
                    $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Time</th>
                                        <th>Protein</th>
                                        <th>Acetone</th>
                                        <th>Sugar</th>
                                        <th>Volume</th>
                                        <th>Read by</th>
                                        <th>Remarks</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                              <tbody class="pv-table-body">';
                    $query = "SELECT * FROM parto_urine WHERE preg_id='$preg_id' AND delivery_id='$delivery_id' ORDER BY date DESC";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row=mysqli_fetch_assoc($query_run))
                        {
                            $value.='<tr>
                                        <td><a href="#" id="btn_edit_parto_urine" data-id="'.$row['parto_urine_id'].'">'.$row['date'].'</a></td>
                                        <td>'.$row['time'].'</td>
                                        <td>'.$row['protein'].'</td>
                                        <td>'.$row['acetone'].'</td>
                                        <td>'.$row['sugar'].'</td>
                                        <td>'.$row['volume'].'</td>
                                        <td>'.$row['read_by'].'</td>
                                        <td>'.$row['remarks'].'</td>
                                        <td>
                                            <a href="#" id="btn_delete_parto_urine" data-id="'.$row['parto_urine_id'].'"><i class="fa fa-trash fa-sm"></i></a>
                                        </td>
                                    </tr>';
                        }
                    };
                    $value.='</tbody>
                            </table>';
                    echo $value;
                }*/
            //CHILD
                function delivery_child_modal_pop()
                {
                    global $con;
                    $preg_id = $_POST['preg_id'];
                    $Data = array();
                    $query = "SELECT * FROM preg_child WHERE preg_id='$preg_id'";
                    $result = mysqli_query($con,$query);
                    
                        if (mysqli_num_rows($result) > 0)
                        {
                            array_push($Data, 'exist');
                        }
                        else
                        {
                            array_push($Data, 'none');
                        };
                    echo json_encode($Data);
                }

                function delivery_child_save()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id_c1'];
                    $date = $_POST['date_c1'];
                    $time = $_POST['time_c1'];
                    $sex = $_POST['sex_c1'];
                    $weight = $_POST['weight_c1'];
                    $chest_circ = $_POST['chest_circ_c1'];
                    $head_circ = $_POST['head_circ_c1'];
                    $Mode_of_delivery = $_POST['Mode_of_delivery_c1'];
                    $presentation = $_POST['presentation_c1'];
                    $indication = $_POST['indication_c1'];
                    $maturity = $_POST['maturity_c1'];
                    $vacuum_assisted = $_POST['vacuum_assisted_c1'];
                    $attendant = $_POST['attendant_c1'];
                    $breastfeeding = $_POST['breastfeeding_c1'];
                    $resp_rate_30min = $_POST['resp_rate_30min_c1'];
                    $initiated_skin_to_skin = $_POST['initiated_skin_to_skin_c1'];
                    $breath_cry = $_POST['breath_cry_c1'];
                    $resuscitation = $_POST['resuscitation_c1'];
                    $infant_arv = $_POST['infant_arv_c1'];
                    $eye_care = $_POST['eye_care_c1'];
                    $cord_care = $_POST['cord_care_c1'];
                    $birth_outcome = $_POST['birth_outcome_c1'];
                    $length = $_POST['length_c1'];
                    $inj_vit_k = $_POST['inj_vit_k_c1'];
                    $meconium_pass = $_POST['meconium_pass_c1'];
                    $urine_pass = $_POST['urine_pass_c1'];
                    $duration_stage_1 = $_POST['duration_stage_1_c1'];
                    $duration_stage_2 = $_POST['duration_stage_2_c1'];
                    $birth_complications = $_POST['birth_complications_c1'];
                    $other_complications = $_POST['other_complications_c1'];
                    $birth_abnormalities = $_POST['birth_abnormalities_c1'];
                    $other_abnormalities = $_POST['other_abnormalities_c1'];
                    $breast_feeding = $_POST['breast_feeding_c1'];
                    $colour = $_POST['colour_c1'];
                    $heart_rate = $_POST['heart_rate_c1'];
                    $temp = $_POST['temp_c1'];
                    $resp_rate = $_POST['resp_rate_c1'];
                    $state = $_POST['state_c1'];
                    $transferred_to = $_POST['transferred_to_c1'];
                    $transferred_date = $_POST['transferred_date_c1'];
                    $transferred_time = $_POST['transferred_time_c1'];
                    $comment = $_POST['comment_c1'];
                    $remarks = $_POST['remarks_c1'];

                    $apgar_colour_1 = $_POST['apgar_colour_1_c1'];
                    $apgar_colour_score_1 = $_POST['apgar_colour_score_1_c1'];
                    $apgar_heart_rate_1 = $_POST['apgar_heart_rate_1_c1'];
                    $apgar_heart_rate_score_1 = $_POST['apgar_heart_rate_score_1_c1'];
                    $apgar_breathing_1 = $_POST['apgar_breathing_1_c1'];
                    $apgar_breathing_score_1 = $_POST['apgar_breathing_score_1_c1'];
                    $apgar_movement_1 = $_POST['apgar_movement_1_c1'];
                    $apgar_movement_score_1 = $_POST['apgar_movement_score_1_c1'];
                    $apgar_response_1 = $_POST['apgar_response_1_c1'];
                    $apgar_response_score_1 = $_POST['apgar_response_score_1_c1'];
                    $apgar_total_1 = $_POST['apgar_total_1_c1'];

                    $apgar_colour_5 = $_POST['apgar_colour_5_c1'];
                    $apgar_colour_score_5 = $_POST['apgar_colour_score_5_c1'];
                    $apgar_heart_rate_5 = $_POST['apgar_heart_rate_5_c1'];
                    $apgar_heart_rate_score_5 = $_POST['apgar_heart_rate_score_5_c1'];
                    $apgar_breathing_5 = $_POST['apgar_breathing_5_c1'];
                    $apgar_breathing_score_5 = $_POST['apgar_breathing_score_5_c1'];
                    $apgar_movement_5 = $_POST['apgar_movement_5_c1'];
                    $apgar_movement_score_5 = $_POST['apgar_movement_score_5_c1'];
                    $apgar_response_5 = $_POST['apgar_response_5_c1'];
                    $apgar_response_score_5 = $_POST['apgar_response_score_5_c1'];
                    $apgar_total_5 = $_POST['apgar_total_5_c1'];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];

                    
                    $query = "INSERT INTO `preg_child`(
                    `company_id`, `patient_id`, `attend_id`, `preg_id`, `delivery_id`, `sex`, `weight`, `hc`, 
                    `birth_outcome`, `breath_cry`, `length`, `initiated_skin_to_skin`, `temp`, `resuscitation`, 
                    `cord_care`, `breastfeed_30min`, `vit_k`, `infant_arv`, `eye_care`, `birth_abnormalities`, 
                    `colour`, `heart_rate`, `resp`, `state`, `trans_ref`, `trans_ref_date`, `trans_ref_time`, 
                    `comment`, `mode_of_delivery`, `presentation`, `duration_1st`, `duration_2nd`, 
                    `vacuum_assisted`, `maturity`, `indication`, `chest_circ`, `meconium_pass`, `urine_pass`, 
                    `attendant`, `date`, `time`, `resp_rate_30min`, `birth_complications`, `other_complications`, 
                    `other_abnormalities`, `breast_feeding`, `remarks`, 

                    `apgar_colour_1`, `apgar_colour_score_1`, `apgar_heart_rate_1`, `apgar_heart_rate_score_1`, 
                    `apgar_breathing_1`, `apgar_breathing_score_1`, `apgar_movement_1`, `apgar_movement_score_1`, 
                    `apgar_response_1`, `apgar_response_score_1`, `apgar_total_1`, 

                    `apgar_colour_5`, `apgar_colour_score_5`, `apgar_heart_rate_5`, `apgar_heart_rate_score_5`, 
                    `apgar_breathing_5`, `apgar_breathing_score_5`, `apgar_movement_5`, `apgar_movement_score_5`, 
                    `apgar_response_5`, `apgar_response_score_5`, `apgar_total_5`,
                    `branch_id`, `created_by`, `created_datetime`) 
                    VALUES (
                    '$company_id','$patient_id','$attend_id','$preg_id','$delivery_id','$sex','$weight','$head_circ','$birth_outcome','$breath_cry','$length','$initiated_skin_to_skin',
                    '$temp','$resuscitation','$cord_care','$breastfeeding','$inj_vit_k','$infant_arv','$eye_care','$birth_abnormalities','$colour','$heart_rate','$resp_rate',
                    '$state','$transferred_to','$transferred_date','$transferred_time','$comment','$Mode_of_delivery','$presentation','$duration_stage_1','$duration_stage_2',
                    '$vacuum_assisted','$maturity','$indication','$chest_circ','$meconium_pass','$urine_pass','$attendant','$date','$time','$resp_rate_30min',
                    '$birth_complications','$other_complications','$other_abnormalities','$breast_feeding','$remarks',

                    '$apgar_colour_1','$apgar_colour_score_1','$apgar_heart_rate_1','$apgar_heart_rate_score_1','$apgar_breathing_1','$apgar_breathing_score_1',
                    '$apgar_movement_1','$apgar_movement_score_1','$apgar_response_1','$apgar_response_score_1','$apgar_total_1',

                    '$apgar_colour_5','$apgar_colour_score_5','$apgar_heart_rate_5','$apgar_heart_rate_score_5','$apgar_breathing_5','$apgar_breathing_score_5',
                    '$apgar_movement_5','$apgar_movement_score_5','$apgar_response_5','$apgar_response_score_5',
                    '$apgar_total_5','$branch_id','$user_id',NOW())";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Child Added Successfully";
                    }
                    else
                    {
                        echo "Child NOT Added";
                    };
                }

                function delivery_children_view()
                {
                    global $con;
                    $attend_id = $_POST['attend_id'];
                    $attend_id = $_POST['attend_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id'];
                    $Data=array();
                    $value = "";
                    $counter = 1;
                    $query = "SELECT * FROM preg_child WHERE preg_id='$preg_id' AND delivery_id='$delivery_id'";
                    $query_run = mysqli_query($con, $query);
                    if (mysqli_num_rows($query_run) > 0)
                    {
                        while($row = mysqli_fetch_assoc($query_run))
                        {
                            $sex = $row['sex'];
                            $sql_gender = "SELECT * FROM gender WHERE gender_id = '$sex'";
                            $result_gender=mysqli_query($con,$sql_gender);
                            $row_gender=mysqli_fetch_array($result_gender);
                            $gender = $row_gender['gender'];

                            $value .='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                                        <tbody class="pv-table-body">
                                            <tr>
                                                <th colspan="6"><h6 class="modal-title m-0 font-weight-bold text-primary">Child '.$counter.'</h6></th>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Date</th>
                                                <th>Time</th>
                                                <th>Sex</th>
                                                <th>Mode of Delivery</th>
                                                <th>Present.</th>
                                                <th>Indication</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['date'].'
                                                </td>
                                                <td>
                                                    '.$row['time'].'
                                                </td>
                                                <td>
                                                    '.$gender.'
                                                </td>
                                                <td>
                                                    '.$row['mode_of_delivery'].'
                                                </td>
                                                <td>
                                                    '.$row['presentation'].'
                                                </td>
                                                <td>
                                                    '.$row['indication'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Weight</th>
                                                <th>Chest Circum.</th>
                                                <th>Head Circum.</th>
                                                <th>Length</th>
                                                <th>Resp. Rate within 30min</th>
                                                <th>Injection Vitamin K</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['weight'].'
                                                </td>
                                                <td>
                                                    '.$row['chest_circ'].'
                                                </td>
                                                <td>
                                                    '.$row['hc'].'
                                                </td>
                                                <td>
                                                    '.$row['length'].'
                                                </td>
                                                <td>
                                                    '.$row['resp_rate_30min'].'
                                                </td>
                                                <td>
                                                    '.$row['vit_k'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Breastfeeding within 30min</th>
                                                <th>Initiated skin-to-skin</th>
                                                <th>Breathing/Crying at birth</th>
                                                <th>Resuscitation</th>
                                                <th>Meconium Pass</th>
                                                <th>Urine Pass</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['breastfeed_30min'].'
                                                </td>
                                                <td>
                                                    '.$row['initiated_skin_to_skin'].'
                                                </td>
                                                <td>
                                                    '.$row['breath_cry'].'
                                                </td>
                                                <td>
                                                    '.$row['resuscitation'].'
                                                </td>
                                                <td>
                                                    '.$row['meconium_pass'].'
                                                </td>
                                                <td>
                                                    '.$row['urine_pass'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Eye Care</th>
                                                <th>Cord Care</th>
                                                <th>Birth Outcome</th>
                                                <th>Maturity</th>
                                                <th>Vacuum Assisted</th>
                                                <th>Infant ARV</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['eye_care'].'
                                                </td>
                                                <td>
                                                    '.$row['cord_care'].'
                                                </td>
                                                <td>
                                                    '.$row['birth_outcome'].'
                                                </td>
                                                <td>
                                                    '.$row['maturity'].'
                                                </td>
                                                <td>
                                                    '.$row['vacuum_assisted'].'
                                                </td>
                                                <td>
                                                    '.$row['infant_arv'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Birth Complication</th>
                                                <th colspan="2">Other Complications</th>
                                                <th>Birth Abnormalities</th>
                                                <th colspan="2">Other Abnormalities</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['birth_complications'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['other_complications'].'
                                                </td>
                                                <td>
                                                    '.$row['birth_abnormalities'].'
                                                </td>
                                                <td colspan="2">
                                                    '.$row['other_abnormalities'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Attendant</th>
                                                <th>Duration of Stage 1</th>
                                                <th>Duration of Stage 2</th>
                                                <th colspan="3">Remarks</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['attendant'].'
                                                </td>
                                                <td>
                                                    '.$row['duration_1st'].'
                                                </td>
                                                <td>
                                                    '.$row['duration_2nd'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['remarks'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th colspan="3">APGAR SCORE @ 1 MIN</th>
                                                <th colspan="3">APGAR SCORE @ 5 MIN</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Colour
                                                </td>
                                                <td>
                                                    '.$row['apgar_colour_1'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_colour_score_1'].'
                                                </td>
                                                <td>
                                                    Colour
                                                </td>
                                                <td>
                                                    '.$row['apgar_colour_5'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_colour_score_5'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Heart Rate
                                                </td>
                                                <td>
                                                    '.$row['apgar_heart_rate_1'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_heart_rate_score_1'].'
                                                </td>
                                                <td>
                                                    Heart Rate
                                                </td>
                                                <td>
                                                    '.$row['apgar_heart_rate_5'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_heart_rate_score_5'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Breathing
                                                </td>
                                                <td>
                                                    '.$row['apgar_breathing_1'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_breathing_score_1'].'
                                                </td>
                                                <td>
                                                    Breathing
                                                </td>
                                                <td>
                                                    '.$row['apgar_breathing_5'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_breathing_score_5'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Movement
                                                </td>
                                                <td>
                                                    '.$row['apgar_movement_1'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_movement_score_1'].'
                                                </td>
                                                <td>
                                                    Movement
                                                </td>
                                                <td>
                                                    '.$row['apgar_movement_5'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_movement_score_5'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    Response
                                                </td>
                                                <td>
                                                    '.$row['apgar_response_1'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_response_score_1'].'
                                                </td>
                                                <td>
                                                    Response
                                                </td>
                                                <td>
                                                    '.$row['apgar_response_5'].'
                                                </td>
                                                <td>
                                                    '.$row['apgar_response_score_5'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2">
                                                    TOTAL
                                                </td>
                                                <td>
                                                    '.$row['apgar_total_1'].'
                                                </td>
                                                <td colspan="2">
                                                    TOTAL
                                                </td>
                                                <td>
                                                    '.$row['apgar_total_5'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0" class="text-center">
                                                <th colspan="11"><h6 class="m-0 font-weight-bold text-primary">POST DELIVERY</h6></th>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Breastfeeding</th>
                                                <th>Colour</th>
                                                <th>Heart Rate</th>
                                                <th>Temp</th>
                                                <th>Resp. Rate</th>
                                                <th>Child State</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['breast_feeding'].'
                                                </td>
                                                <td>
                                                    '.$row['colour'].'
                                                </td>
                                                <td>
                                                    '.$row['heart_rate'].'
                                                </td>
                                                <td>
                                                    '.$row['temp'].'
                                                </td>
                                                <td>
                                                    '.$row['resp'].'
                                                </td>
                                                <td>
                                                    '.$row['state'].'
                                                </td>
                                            </tr>
                                            <tr style="background-color:#E4E1E0">
                                                <th>Transferred To</th>
                                                <th>Transferred Date</th>
                                                <th>Transferred Time</th>
                                                <th colspan="3">Comment</th>
                                            </tr>
                                            <tr>
                                                <td>
                                                    '.$row['trans_ref'].'
                                                </td>
                                                <td>
                                                    '.$row['trans_ref_date'].'
                                                </td>
                                                <td>
                                                    '.$row['trans_ref_time'].'
                                                </td>
                                                <td colspan="3">
                                                    '.$row['comment'].'
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="6">
                                                    <div class="modal-footer">
                                                         <button type="submit" data-id="'.$row['preg_child_id'].'" name="delivery_child_edit_btn" id="delivery_child_edit_btn" class="btn btn-primary">Edit</button>
                                                    </div>
                                                </td>
                                            </tr>
                                        </tbody>
                                      </table>';
                                      $counter ++;
                        }
                                echo $value;
                    };
                }

                function delivery_child_edit()
                {
                    global $con;
                    $preg_child_id = $_POST['preg_child_id'];
                    $Data=array();
                    $query = "SELECT * FROM preg_child WHERE preg_child_id='$preg_child_id'";
                    $result = mysqli_query($con,$query);
                    
                    while($row=mysqli_fetch_assoc($result))
                    {
                        array_push($Data, 
                            $row['preg_child_id'],$row['delivery_id'],$row['preg_id'],$row['sex'],$row['weight'],$row['hc'],
                            $row['birth_outcome'],$row['breath_cry'],$row['length'],$row['initiated_skin_to_skin'],$row['temp'],$row['resuscitation'],$row['cord_care'],
                            $row['breastfeed_30min'],$row['vit_k'],$row['infant_arv'],$row['eye_care'],$row['birth_abnormalities'],$row['colour'],$row['heart_rate'],
                            $row['resp'],$row['state'],$row['trans_ref'],$row['trans_ref_date'],$row['trans_ref_time'],$row['comment'],$row['mode_of_delivery'],
                            $row['presentation'],$row['duration_1st'],$row['duration_2nd'],$row['vacuum_assisted'],$row['maturity'],$row['indication'],$row['chest_circ'],
                            $row['meconium_pass'],$row['urine_pass'],$row['attendant'],$row['date'],$row['time'],$row['resp_rate_30min'],$row['birth_complications'],
                            $row['other_complications'],$row['other_abnormalities'],$row['breast_feeding'],$row['remarks'],$row['apgar_colour_1'],$row['apgar_colour_score_1'],
                            $row['apgar_heart_rate_1'],$row['apgar_heart_rate_score_1'],$row['apgar_breathing_1'],$row['apgar_breathing_score_1'],$row['apgar_movement_1'],
                            $row['apgar_movement_score_1'],$row['apgar_response_1'],$row['apgar_response_score_1'],$row['apgar_total_1'],$row['apgar_colour_5'],
                            $row['apgar_colour_score_5'],$row['apgar_heart_rate_5'],$row['apgar_heart_rate_score_5'],$row['apgar_breathing_5'],$row['apgar_breathing_score_5'],
                            $row['apgar_movement_5'],$row['apgar_movement_score_5'],$row['apgar_response_5'],$row['apgar_response_score_5'],$row['apgar_total_5']
                        );
                    }
                    echo json_encode($Data);
                }

                function delivery_child_update()
                {
                    global $con;
                    $child_id = $_POST['child_id_c1'];
                    $attend_id = $_POST['attend_id'];
                    $patient_id = $_POST['patient_id'];
                    $preg_id = $_POST['preg_id'];
                    $delivery_id = $_POST['delivery_id_c1'];
                    $date = $_POST['date_c1'];
                    $time = $_POST['time_c1'];
                    $sex = $_POST['sex_c1'];
                    $weight = $_POST['weight_c1'];
                    $chest_circ = $_POST['chest_circ_c1'];
                    $head_circ = $_POST['head_circ_c1'];
                    $Mode_of_delivery = $_POST['Mode_of_delivery_c1'];
                    $presentation = $_POST['presentation_c1'];
                    $indication = $_POST['indication_c1'];
                    $maturity = $_POST['maturity_c1'];
                    $vacuum_assisted = $_POST['vacuum_assisted_c1'];
                    $attendant = $_POST['attendant_c1'];
                    $breastfeeding = $_POST['breastfeeding_c1'];
                    $resp_rate_30min = $_POST['resp_rate_30min_c1'];
                    $initiated_skin_to_skin = $_POST['initiated_skin_to_skin_c1'];
                    $breath_cry = $_POST['breath_cry_c1'];
                    $resuscitation = $_POST['resuscitation_c1'];
                    $infant_arv = $_POST['infant_arv_c1'];
                    $eye_care = $_POST['eye_care_c1'];
                    $cord_care = $_POST['cord_care_c1'];
                    $birth_outcome = $_POST['birth_outcome_c1'];
                    $length = $_POST['length_c1'];
                    $inj_vit_k = $_POST['inj_vit_k_c1'];
                    $meconium_pass = $_POST['meconium_pass_c1'];
                    $urine_pass = $_POST['urine_pass_c1'];
                    $duration_stage_1 = $_POST['duration_stage_1_c1'];
                    $duration_stage_2 = $_POST['duration_stage_2_c1'];
                    $birth_complications = $_POST['birth_complications_c1'];
                    $other_complications = $_POST['other_complications_c1'];
                    $birth_abnormalities = $_POST['birth_abnormalities_c1'];
                    $other_abnormalities = $_POST['other_abnormalities_c1'];
                    $breast_feeding = $_POST['breast_feeding_c1'];
                    $colour = $_POST['colour_c1'];
                    $heart_rate = $_POST['heart_rate_c1'];
                    $temp = $_POST['temp_c1'];
                    $resp_rate = $_POST['resp_rate_c1'];
                    $state = $_POST['state_c1'];
                    $transferred_to = $_POST['transferred_to_c1'];
                    $transferred_date = $_POST['transferred_date_c1'];
                    $transferred_time = $_POST['transferred_time_c1'];
                    $comment = $_POST['comment_c1'];
                    $remarks = $_POST['remarks_c1'];

                    $apgar_colour_1 = $_POST['apgar_colour_1_c1'];
                    $apgar_colour_score_1 = $_POST['apgar_colour_score_1_c1'];
                    $apgar_heart_rate_1 = $_POST['apgar_heart_rate_1_c1'];
                    $apgar_heart_rate_score_1 = $_POST['apgar_heart_rate_score_1_c1'];
                    $apgar_breathing_1 = $_POST['apgar_breathing_1_c1'];
                    $apgar_breathing_score_1 = $_POST['apgar_breathing_score_1_c1'];
                    $apgar_movement_1 = $_POST['apgar_movement_1_c1'];
                    $apgar_movement_score_1 = $_POST['apgar_movement_score_1_c1'];
                    $apgar_response_1 = $_POST['apgar_response_1_c1'];
                    $apgar_response_score_1 = $_POST['apgar_response_score_1_c1'];
                    $apgar_total_1 = $_POST['apgar_total_1_c1'];

                    $apgar_colour_5 = $_POST['apgar_colour_5_c1'];
                    $apgar_colour_score_5 = $_POST['apgar_colour_score_5_c1'];
                    $apgar_heart_rate_5 = $_POST['apgar_heart_rate_5_c1'];
                    $apgar_heart_rate_score_5 = $_POST['apgar_heart_rate_score_5_c1'];
                    $apgar_breathing_5 = $_POST['apgar_breathing_5_c1'];
                    $apgar_breathing_score_5 = $_POST['apgar_breathing_score_5_c1'];
                    $apgar_movement_5 = $_POST['apgar_movement_5_c1'];
                    $apgar_movement_score_5 = $_POST['apgar_movement_score_5_c1'];
                    $apgar_response_5 = $_POST['apgar_response_5_c1'];
                    $apgar_response_score_5 = $_POST['apgar_response_score_5_c1'];
                    $apgar_total_5 = $_POST['apgar_total_5_c1'];
                    $company_id = $_SESSION['company_id'];
                    $branch_id = $_SESSION['branch_id'];
                    $user_id = $_SESSION['user_id'];

                    $query = "UPDATE `preg_child` SET
                    `patient_id`='$patient_id', `attend_id`='$attend_id', `preg_id`='$preg_id', `delivery_id`='$delivery_id', `sex`='$sex', `weight`='$weight', 
                    `hc`='$head_circ', `birth_outcome`='$birth_outcome', `breath_cry`='$breath_cry', `length`='$length', `initiated_skin_to_skin`='$initiated_skin_to_skin', 
                    `temp`='$temp', `resuscitation`='$resuscitation', `cord_care`='$cord_care', `breastfeed_30min`='$breastfeeding', `vit_k`='$inj_vit_k', 
                    `infant_arv`='$infant_arv', `eye_care`='$eye_care', `birth_abnormalities`='$birth_abnormalities', `colour`='$colour', `heart_rate`='$heart_rate', 
                    `resp`='$resp_rate', `state`='$state', `trans_ref`='$transferred_to', `trans_ref_date`='$transferred_date', `trans_ref_time`='$transferred_time', 
                    `comment`='$comment', `mode_of_delivery`='$Mode_of_delivery', `presentation`='$presentation', `duration_1st`='$duration_stage_1', 
                    `duration_2nd`='$duration_stage_2', `vacuum_assisted`='$vacuum_assisted', `maturity`='$maturity', `indication`='$indication', `chest_circ`='$chest_circ', 
                    `meconium_pass`='$meconium_pass', `urine_pass`='$urine_pass', `attendant`='$attendant', `date`='$date', `time`='$time', 
                    `resp_rate_30min`='$resp_rate_30min', `birth_complications`='$birth_complications', `other_complications`='$other_complications', 
                    `other_abnormalities`='$other_abnormalities', `breast_feeding`='$breast_feeding', `remarks`='$remarks', `apgar_colour_1`='$apgar_colour_1', 
                    `apgar_colour_score_1`='$apgar_colour_score_1', `apgar_heart_rate_1`='$apgar_heart_rate_1', `apgar_heart_rate_score_1`='$apgar_heart_rate_score_1', 
                    `apgar_breathing_1`='$apgar_breathing_1', `apgar_breathing_score_1`='$apgar_breathing_score_1', `apgar_movement_1`='$apgar_movement_1', 
                    `apgar_movement_score_1`='$apgar_movement_score_1', `apgar_response_1`='$apgar_response_1', `apgar_response_score_1`='$apgar_response_score_1', 
                    `apgar_total_1`='$apgar_total_1', `apgar_colour_5`='$apgar_colour_5', `apgar_colour_score_5`='$apgar_colour_score_5', 
                    `apgar_heart_rate_5`='$apgar_heart_rate_5', `apgar_heart_rate_score_5`='$apgar_heart_rate_score_5', `apgar_breathing_5`='$apgar_breathing_5', 
                    `apgar_breathing_score_5`='$apgar_breathing_score_5',`apgar_movement_5`='$apgar_movement_5', `apgar_movement_score_5`='$apgar_movement_score_5', 
                    `apgar_response_5`='$apgar_response_5', `apgar_response_score_5`='$apgar_response_score_5', `apgar_total_5`='$apgar_total_5',
                    `altered_by`='$user_id',`altered_datetime`=NOW() 
                    WHERE `preg_child_id`='$child_id'";
                    $query_run = mysqli_query($con, $query);
                    if ($query_run)
                    {
                        echo "Child Update Successfully";
                    }
                    else
                    {
                        echo "Child NOT Updated";
                    };
                }
        //PNC
            function pnc_open()
            {
                global $con;
                $_SESSION['preg_id'] = $_POST["preg_id"];
            }

            function pnc_save()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $date = $_POST['pnc_date'];
                $time = $_POST['pnc_time'];
                $bp_systolic = $_POST['pnc_bp_systolic'];
                $bp_diastolic = $_POST['pnc_bp_diastolic'];
                $weight = $_POST['pnc_weight'];
                $pulse = $_POST['pnc_pulse'];
                $temp = $_POST['pnc_temp'];
                $urine_protein = $_POST['pnc_urine_protein'];
                $urine_sugar = $_POST['pnc_urine_sugar'];
                $fundal_height = $_POST['pnc_fundal_height'];
                $loch_colour = $_POST['pnc_loch_colour'];
                $loch_odour = $_POST['pnc_loch_odour'];
                $incision_per = $_POST['pnc_incision_per'];
                $breast_nipple = $_POST['pnc_breast_nipple'];
                $mood_change = $_POST['pnc_mood_change'];
                $days_ifa_supp = $_POST['pnc_days_ifa_supp'];
                $hb = $_POST['pnc_hb'];
                $hiv = $_POST['pnc_hiv'];
                $others = $_POST['pnc_others'];
                $fp_counsel = $_POST['pnc_fp_counsel'];
                $fp_method = $_POST['pnc_fp_method'];
                $fp_remarks = $_POST['pnc_fp_remarks'];
                $complaint = $_POST['pnc_complaint'];
                $initials = $_POST['pnc_initials'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "INSERT INTO `pnc`(
                `company_id`, `preg_id`, `patient_id`, `attend_id`, `date`, `time`, `bp_systolic`, `bp_diastolic`, `weight`, `pulse`, `temp`, `urine_protein`, 
                `urine_sugar`, `fundal_height`, `loch_colour`, `loch_odour`, `incision_per`, `breast_nipple`, `mood_change`, `days_ifa_supp`, `complaints`, `initials`,
                `hb`, `hiv`, `other`, `fp_counsel`, `fp_method`, `fp_remarks`, `branch_id`, `created_by`, `created_datetime`) 
                VALUES (
                '$company_id','$preg_id','$patient_id','$attend_id','$date','$time','$bp_systolic','$bp_diastolic','$weight','$pulse','$temp','$urine_protein','$urine_sugar',
                '$fundal_height','$loch_colour','$loch_odour','$incision_per','$breast_nipple','$mood_change','$days_ifa_supp','$complaint','$initials','$hb','$hiv',
                '$others','$fp_counsel','$fp_method','$fp_remarks','$branch_id','$user_id',NOW())";
                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    echo "PNC Added Successfully";
                }
                else
                {
                    echo "PNC NOT Added";
                };
            }

            function pnc_check()
            {
                global $con;
                $patient_id = $_POST['patient_id'];
                $attend_id = $_POST['attend_id'];
                $preg_id = $_POST['preg_id'];

                $Data=array();
                $query_preg = "SELECT * from pnc WHERE patient_id='$patient_id' AND preg_id='$preg_id'";
                $query_run_preg = mysqli_query($con, $query_preg);
                if (mysqli_num_rows($query_run_preg) > 0)
                {
                    array_push($Data, 'pnc_preg_exist');
                    $query_attend = "SELECT * from pnc WHERE patient_id='$patient_id' AND attend_id='$attend_id' AND preg_id='$preg_id'";
                    $query_run_attend = mysqli_query($con, $query_attend);
                    if (mysqli_num_rows($query_run_attend) > 0)
                    {
                        array_push($Data, 'pnc_attend_exist');
                    }
                    else
                    {
                        array_push($Data, 'pnc_attend_none');
                    };
                }
                else
                {
                    array_push($Data, 'pnc_preg_none','pnc_attend_none');
                };

                
                echo json_encode($Data);
            }

            function pnc_view()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $value = "";
                $value = '<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                            <tbody class="pv-table-body">';

                $query_pnc = "SELECT * from pnc WHERE patient_id='$patient_id' AND preg_id='$preg_id'";
                $query_run_pnc = mysqli_query($con, $query_pnc);
                if (mysqli_num_rows($query_run_pnc) > 0)
                {
                    while($row_pnc = mysqli_fetch_assoc($query_run_pnc))
                    {
                        if($row_pnc['attend_id'] == $attend_id)
                        {
                            $hidden='false';
                        }
                        else
                        {
                            $hidden='true';
                        };

                        $value .= '<tr style="background-color:#E4E1E0">
                                        <th>Date</th>
                                        <th>BP</th>
                                        <th>Weight</th>
                                        <th>Pulse</th>
                                        <th>Temp</th>
                                        <th>Complaint</th>
                                        <th>Urine Protein</th>
                                        <th>Urine Sugar</th>
                                        <th>Initials</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>';
                                        if($row_pnc['attend_id'] == $attend_id)
                                        {
                                            $value .= '<a href="#" id="btn_edit_pnc" data-id="'.$row_pnc['pnc_id'].'">'.$row_pnc['date'].'</a>';
                                        }
                                        else
                                        {
                                            $value .= $row_pnc['date'];
                                        };
                            $value .= '</td>
                                        <td>
                                            '.$row_pnc['bp_systolic'].'/'.$row_pnc['bp_diastolic'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['weight'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['pulse'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['temp'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['urine_protein'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['urine_sugar'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['complaints'].'
                                        </td>
                                        <td>
                                            '.$row_pnc['initials'].'
                                        </td>
                                        <td>';
                                        if($row_pnc['attend_id'] == $attend_id)
                                        {
                                            $value .= '<button type="button" 
                                            data-id="'.$row_pnc['pnc_id'].'" 
                                            name="add_pnc_child_btn" 
                                            id="add_pnc_child_btn" 
                                            class="btn btn-sm btn-primary">Add Child</button>';
                                        };
                            $value .= '</td>
                                    </tr>';
                        $pnc_id = $row_pnc['pnc_id'];
                        $query_child = "SELECT * from pnc_child WHERE pnc_id='$pnc_id'";
                        $query_run_child = mysqli_query($con, $query_child);
                        if (mysqli_num_rows($query_run_child) > 0)
                        {
                            $child = 1;
                            $value .= '<tr>
                                               <th colspan="10">Children</th>
                                        </tr>
                                        <tr>
                                            <th>No</th>
                                            <th>Weight</th>
                                            <th>Length</th>
                                            <th>Head Circ.</th>
                                            <th>Resp. Rate</th>
                                            <th>Temp</th>
                                            <th>Feeding</th>
                                            <th>Activities</th>
                                            <th>Pallor</th>
                                            <th>Remarks</th>
                                        </tr>';
                            while($row_child = mysqli_fetch_assoc($query_run_child))
                            {
                                $value .= '<tr>
                                            <td>
                                                <a href="#" id="btn_edit_pnc_child" data-id="'.$row_child['pnc_child_id'].'">Child '.$child.'</a>
                                            </td>
                                            <td>
                                                '.$row_child['weight'].'
                                            </td>
                                            <td>
                                                '.$row_child['length'].'
                                            </td>
                                            <td>
                                                '.$row_child['head_circ'].'
                                            </td>
                                            <td>
                                                '.$row_child['resp_rate'].'
                                            </td>
                                            <td>
                                                '.$row_child['temp'].'
                                            </td>
                                            <td>
                                                '.$row_child['feeding'].'
                                            </td>
                                            <td>
                                                '.$row_child['activities'].'
                                            </td>
                                            <td>
                                                '.$row_child['pallor'].'
                                            </td>
                                            <td>
                                                '.$row_child['remarks'].'
                                            </td>
                                        </tr>';
                                        $child ++;
                            };
                        }
                        else
                        {
                            $value .= '<tr>
                                               <th colspan="10">No Child </th>
                                        </tr>';
                        };

                    };
                }
                else
                {
                    $value .= '<tr>
                                       <th colspan="10">No PNC </th>
                                </tr>';
                };

                echo $value;
            }

            function pnc_edit()
            {
                global $con;
                $pnc_id = $_POST['pnc_id'];
                $patient_id = $_POST['patient_id'];
                $Data=array();
                $query = "SELECT * FROM pnc WHERE pnc_id='$pnc_id' AND patient_id='$patient_id'";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    array_push($Data, 
                        $row['pnc_id'],$row['date'],$row['time'],$row['bp_systolic'],$row['bp_diastolic'],$row['weight'],$row['pulse'],
                        $row['temp'],$row['urine_protein'],$row['urine_sugar'],$row['fundal_height'],$row['loch_colour'],$row['loch_odour'],$row['incision_per'],
                        $row['breast_nipple'],$row['mood_change'],$row['days_ifa_supp'],$row['complaints'],$row['initials'],$row['hb'],$row['hiv'],$row['other'],
                        $row['fp_counsel'],$row['fp_method'],$row['fp_remarks']
                    );
                };
                echo json_encode($Data);
            }

            function pnc_update()
            {
                global $con;
                $pnc_id = $_POST['pnc_id'];
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $date = $_POST['pnc_date'];
                $time = $_POST['pnc_time'];
                $bp_systolic = $_POST['pnc_bp_systolic'];
                $bp_diastolic = $_POST['pnc_bp_diastolic'];
                $weight = $_POST['pnc_weight'];
                $pulse = $_POST['pnc_pulse'];
                $temp = $_POST['pnc_temp'];
                $urine_protein = $_POST['pnc_urine_protein'];
                $urine_sugar = $_POST['pnc_urine_sugar'];
                $fundal_height = $_POST['pnc_fundal_height'];
                $loch_colour = $_POST['pnc_loch_colour'];
                $loch_odour = $_POST['pnc_loch_odour'];
                $incision_per = $_POST['pnc_incision_per'];
                $breast_nipple = $_POST['pnc_breast_nipple'];
                $mood_change = $_POST['pnc_mood_change'];
                $days_ifa_supp = $_POST['pnc_days_ifa_supp'];
                $hb = $_POST['pnc_hb'];
                $hiv = $_POST['pnc_hiv'];
                $others = $_POST['pnc_others'];
                $fp_counsel = $_POST['pnc_fp_counsel'];
                $fp_method = $_POST['pnc_fp_method'];
                $fp_remarks = $_POST['pnc_fp_remarks'];
                $complaint = $_POST['pnc_complaint'];
                $initials = $_POST['pnc_initials'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "UPDATE `pnc` SET
                `preg_id`='$preg_id', `patient_id`='$patient_id', `attend_id`='$attend_id', `date`='$date', 
                `time`='$time', `bp_systolic`='$bp_systolic', `bp_diastolic`='$bp_diastolic', `weight`='$weight', 
                `pulse`='$pulse', `temp`='$temp', `urine_protein`='$urine_protein', `urine_sugar`='$urine_sugar', 
                `fundal_height`='$fundal_height', `loch_colour`='$loch_colour', `loch_odour`='$loch_odour', 
                `incision_per`='$incision_per', `breast_nipple`='$breast_nipple', `mood_change`='$mood_change', 
                `days_ifa_supp`='$days_ifa_supp', `complaints`='$complaint', `initials`='$initials',
                `hb`='$hb', `hiv`='$hiv', `other`='$others', `fp_counsel`='$fp_counsel', 
                `fp_method`='$fp_method', `fp_remarks`='$fp_remarks', `altered_by`='$user_id', `altered_datetime`=NOW()
                WHERE `pnc_id`='$pnc_id'";
                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    echo "PNC Updated Successfully";
                }
                else
                {
                    echo "PNC NOT Updated";
                };
            }

            function pnc_child_save()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $date = $_POST['pc_date'];
                $pnc_id = $_POST['pnc_id_child'];
                $time = $_POST['pc_time'];
                $weight = $_POST['pc_weight'];
                $length = $_POST['pc_length'];
                $head_circ = $_POST['pc_head_circ'];
                $resp_rate = $_POST['pc_resp_rate'];
                $temp = $_POST['pc_temp'];
                $feeding = $_POST['pc_feeding'];
                $activities = $_POST['pc_activities'];
                $pallor = $_POST['pc_pallor'];
                $jaundice = $_POST['pc_jaundice'];
                $head = $_POST['pc_head'];
                $eye = $_POST['pc_eye'];
                $abdomen = $_POST['pc_abdomen'];
                $limbs = $_POST['pc_limbs'];
                $back = $_POST['pc_back'];
                $skin = $_POST['pc_skin'];
                $heart_rate = $_POST['pc_heart_rate'];
                $pass_urine = $_POST['pc_pass_urine'];
                $pass_stool = $_POST['pc_pass_stool'];
                $attend_type = $_POST['pc_attend_type'];
                $hiv_date = $_POST['pc_hiv_date'];
                $hiv_result = $_POST['pc_hiv_result'];
                $hiv_remarks = $_POST['pc_hiv_remarks'];
                $umbelical_cord = $_POST['pc_umbelical_cord'];
                $initials = $_POST['pc_initials'];
                $remarks = $_POST['pc_remarks'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "INSERT INTO `pnc_child`(
                `preg_id`, `patient_id`, `attend_id`, `date`, `time`, `head_circ`, `length`, `weight`, 
                `heart_rate`, `temp`, `resp_rate`, `feeding`, `activities`, `pallor`, `jaundice`, `head`, 
                `eye`, `abdomen`, `limbs`, `back`, `skin`,`passing_urine`, `passing_stool`, `attendance_type`, 
                `hiv_date`, `hiv_result`, `hiv_remarks`, `condition_of_u_cord`, `initials`, `remarks`, `pnc_id`,
                `company_id`, `branch_id`, `created_by`, `created_datetime`) 
                VALUES (
                '$preg_id','$patient_id','$attend_id','$date','$time','$head_circ','$length','$weight',
                '$heart_rate','$temp','$resp_rate','$feeding','$activities','$pallor','$jaundice','$head',
                '$eye','$abdomen','$limbs','$back','$skin','$pass_urine','$pass_stool','$attend_type',
                '$hiv_date','$hiv_result','$hiv_remarks','$umbelical_cord','$initials','$remarks','$pnc_id',
                '$company_id','$branch_id','$user_id',NOW())";
                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    echo "Child Added Successfully";
                }
                else
                {
                    echo "Child NOT Added";
                };
            }

            function pnc_child_edit()
            {
                global $con;
                $pnc_child_id = $_POST['pnc_child_id'];
                $Data=array();
                $query = "SELECT * FROM pnc_child WHERE pnc_child_id='$pnc_child_id'";
                $result = mysqli_query($con,$query);
                while($row=mysqli_fetch_assoc($result))
                {
                    array_push($Data, 
                        $row['pnc_child_id'],$row['pnc_id'],$row['preg_id'],$row['patient_id'],$row['attend_id'],$row['date'],
                        $row['time'],$row['weight'],$row['length'],$row['head_circ'],$row['heart_rate'],$row['resp_rate'],$row['temp'],$row['feeding'],
                        $row['activities'],$row['pallor'],$row['jaundice'],$row['head'],$row['eye'],$row['abdomen'],$row['limbs'],$row['back'],$row['skin'],
                        $row['passing_urine'],$row['passing_stool'],$row['attendance_type'],$row['hiv_date'],$row['hiv_result'],$row['hiv_remarks'],
                        $row['condition_of_u_cord'],$row['initials'],$row['remarks']
                    );
                }
                echo json_encode($Data);
            }

            function pnc_child_update()
            {
                global $con;
                $pnc_child_id = $_POST['pnc_child_id'];
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $date = $_POST['pc_date'];
                $pnc_id = $_POST['pnc_id_child'];
                $time = $_POST['pc_time'];
                $weight = $_POST['pc_weight'];
                $length = $_POST['pc_length'];
                $head_circ = $_POST['pc_head_circ'];
                $resp_rate = $_POST['pc_resp_rate'];
                $temp = $_POST['pc_temp'];
                $feeding = $_POST['pc_feeding'];
                $activities = $_POST['pc_activities'];
                $pallor = $_POST['pc_pallor'];
                $jaundice = $_POST['pc_jaundice'];
                $head = $_POST['pc_head'];
                $eye = $_POST['pc_eye'];
                $abdomen = $_POST['pc_abdomen'];
                $limbs = $_POST['pc_limbs'];
                $back = $_POST['pc_back'];
                $skin = $_POST['pc_skin'];
                $heart_rate = $_POST['pc_heart_rate'];
                $pass_urine = $_POST['pc_pass_urine'];
                $pass_stool = $_POST['pc_pass_stool'];
                $attend_type = $_POST['pc_attend_type'];
                $hiv_date = $_POST['pc_hiv_date'];
                $hiv_result = $_POST['pc_hiv_result'];
                $hiv_remarks = $_POST['pc_hiv_remarks'];
                $umbelical_cord = $_POST['pc_umbelical_cord'];
                $initials = $_POST['pc_initials'];
                $remarks = $_POST['pc_remarks'];
                $company_id = $_SESSION['company_id'];
                $branch_id = $_SESSION['branch_id'];
                $user_id = $_SESSION['user_id'];
                
                $query = "UPDATE `pnc_child` SET
                `preg_id`='$preg_id', `patient_id`='$patient_id', `attend_id`='$attend_id', `date`='$date', `time`='$time', `head_circ`='$head_circ', 
                `length`='$length', `weight`='$weight', `heart_rate`='$heart_rate', `temp`='$temp', `resp_rate`='$resp_rate', `feeding`='$feeding', 
                `activities`='$activities', `pallor`='$pallor', `jaundice`='$jaundice', `head`='$head', `eye`='$eye', `abdomen`='$abdomen', `limbs`='$limbs', 
                `back`='$back', `skin`='$skin', `passing_urine`='$pass_urine', `passing_stool`='$pass_stool', `attendance_type`='$attend_type', `hiv_date`='$hiv_date',
                `hiv_result`='$hiv_result', `hiv_remarks`='$hiv_remarks', `condition_of_u_cord`='$umbelical_cord', `initials`='$initials', `remarks`='$remarks', 
                `pnc_id`='$pnc_id',`altered_by`='$user_id',`altered_datetime`=NOW()
                WHERE `pnc_child_id`='$pnc_child_id'";

                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    echo "Child Added Successfully";
                }
                else
                {
                    echo "Child NOT Added";
                };
            }
        //MATERNITY LEAVE
            function maternity_leave_open()
            {
                global $con;
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $Data=array();
                $value = "";
                $query = "SELECT * FROM maternity_leave WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row=mysqli_fetch_assoc($query_run);
                    array_push($Data, 'exist',$row['mat_leave_id']);
                }
                else
                {
                    array_push($Data, 'none');
                };
                 echo json_encode($Data);
            }

            function maternity_leave_save()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $delivery_id = $_POST['delivery_id'];
                $patient_name = $_POST['patient_name'];
                $delivery_date = $_POST['delivery_date'];
                $remarks = $_POST['remarks'];
                $issue_date = $_POST['issue_date'];
                $medical_officer = $_POST['medical_officer'];
                $company_id = $_SESSION['company_id'];
                
                $query = "INSERT INTO `maternity_leave`(`company_id`, `patient_id`, `attend_id`, `preg_id`, `delivery_id`, `name`, `date_of_delivery`, `remarks`, `date_issue`, `medical_officer`) 
                VALUES ('$company_id','$patient_id','$attend_id','$preg_id','$delivery_id','$patient_name','$delivery_date','$remarks','$issue_date','$medical_officer')";
                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    $_SESSION['patient_id'] = $_POST['patient_id'];
                    $_SESSION['preg_id'] = $_POST['preg_id'];
                    echo "Maternity Leave Added Successfully";
                }
                else
                {
                    echo "Maternity Leave NOT Added";
                };
            }

            function maternity_leave_edit()
            {
                global $con;
                $patient_id = $_POST['patient_id'];
                $mat_leave_id = $_POST['mat_leave_id'];
                $Data=array();
                $query = "SELECT * FROM maternity_leave WHERE mat_leave_id='$mat_leave_id' AND patient_id='$patient_id'";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    $row=mysqli_fetch_assoc($query_run);
                    array_push($Data, $row['mat_leave_id'],$row['name'],$row['date_of_delivery'],$row['date_issue'],$row['medical_officer'],$row['remarks']);
                };
                 echo json_encode($Data);
            }

            function maternity_leave_update()
            {
                global $con;
                $attend_id = $_POST['attend_id'];
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $delivery_id = $_POST['delivery_id'];
                $patient_name = $_POST['patient_name'];
                $delivery_date = $_POST['delivery_date'];
                $remarks = $_POST['remarks'];
                $issue_date = $_POST['issue_date'];
                $medical_officer = $_POST['medical_officer'];
                $mat_leave_id = $_POST['mat_leave_id'];
                
                $query = "UPDATE `maternity_leave` SET `patient_id`='$patient_id', `attend_id`='$attend_id', `preg_id`='$preg_id', `delivery_id`='$delivery_id', `name`='$patient_name', `date_of_delivery`='$delivery_date', `remarks`='$remarks', `date_issue`='$issue_date', `medical_officer`='$medical_officer' WHERE `mat_leave_id`='$mat_leave_id'";
                $query_run = mysqli_query($con, $query);
                if ($query_run)
                {
                    $_SESSION['patient_id'] = $_POST['patient_id'];
                    $_SESSION['preg_id'] = $_POST['preg_id'];
                    echo "Maternity Leave Updated Successfully";
                }
                else
                {
                    echo "Maternity Leave NOT Updated";
                };
            }

            function maternity_leave_view()
            {
                global $con;
                $patient_id = $_POST['patient_id'];
                $preg_id = $_POST['preg_id'];
                $value = "";
                $query = "SELECT * FROM maternity_leave WHERE preg_id='$preg_id' AND patient_id='$patient_id'";
                $query_run = mysqli_query($con, $query);
                if (mysqli_num_rows($query_run) > 0)
                {
                    while($row = mysqli_fetch_assoc($query_run))
                    {
                        $value .='<table class="table table-hover table-bordered table-sm" width="100%" cellspacing="0" style="font-size: 14px">
                                    <tbody class="pv-table-body">
                                        <tr style="background-color:#E4E1E0">
                                            <th>Patient Name</th>
                                            <th>Date of Delivery</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                '.$row['name'].'
                                            </td>
                                            <td>
                                                '.$row['date_of_delivery'].'
                                            </td>
                                        </tr>
                                        <tr style="background-color:#E4E1E0">
                                            <th colspan="2">Remarks</th>
                                        </tr>
                                        <tr>
                                            <td colspan="2">
                                                '.$row['remarks'].'
                                            </td>
                                        </tr>
                                        <tr style="background-color:#E4E1E0">
                                            <th>Date of Issue</th>
                                            <th>Medical Officer</th>
                                        </tr>
                                        <tr>
                                            <td>
                                                '.$row['date_issue'].'
                                            </td>
                                            <td>
                                                '.$row['medical_officer'].'
                                            </td>
                                        </tr>
                                    </tbody>
                                  </table>';
                    }
                            echo $value;
                };
            }
    
?>
