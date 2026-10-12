    <?php
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/bdd.php');
        require_once($_SERVER['DOCUMENT_ROOT'] .'/includes/db.php');
        date_default_timezone_set("Africa/Accra");

        $company_id = $_SESSION['company_id'];
        $appoint_type = $_SESSION['appoint_type'];
        $appoint_doctor = $_SESSION['appoint_doctor'];
        $appoint_theatre = $_SESSION['appoint_theatre'];
        $appoint_start = $_SESSION['appoint_start'];
        $appoint_end = $_SESSION['appoint_end'];

        if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE company_id='$company_id'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND company_id='$company_id'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND company_id='$company_id'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE theatre_id = '$appoint_theatre' AND company_id='$company_id'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre == 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND company_id='$company_id'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor == 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND theatre_id = '$appoint_theatre' AND company_id='$company_id'";
        }
        else if($appoint_type !== 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE appoint_type_id = '$appoint_type' AND doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND company_id='$company_id'";
        }
        else if($appoint_type == 'all_appointments' && $appoint_doctor !== 'all_doctors' && $appoint_theatre !== 'all_theatres')
        {
            $sql = "SELECT * FROM appointment WHERE doctor = '$appoint_doctor' AND theatre_id = '$appoint_theatre' AND company_id='$company_id'";
        };

        $req = $bdd->prepare($sql);
        $req->execute();
        $events = $req->fetchAll();
    ?>
    
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <!--<meta http-equiv="refresh" content="60"> -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="">
        <meta name="author" content="">
        <link rel="shortcut icon" href="/img/favicon.png">
        <title>Calendar Generic</title>

        <!-- Bootstrap Core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <!-- FullCalendar -->
        <!-- <link href='css/fullcalendar.css' rel='stylesheet' /> -->
        <link href='/css/fullcalendarxx.min.css' rel='stylesheet' />
        <link href='/css/sweetalert.css' rel='stylesheet'/>
        <link href='/css/AdminLTE.min.css' rel='stylesheet'/>
        <!-- Custom CSS -->
        <style>
            body {
                padding-top: 70px;
                /* Required padding for .navbar-fixed-top. Remove if using .navbar-static-top. Change if height of navigation changes. */
            }
            #calendar {
                max-width: 1300px;
            }
            .col-centered{
                float: none;
                margin: 0 auto;
            }
            .tooltip{
                width:auto;
                height:20%;
                color:black;
                background:#E5E5E5;
                position:absolute;
                z-index:10001;
                border-radius:5px;
                top: -300%;
                left:50%;
                padding:5px 10px;
                margin-left:-60px;
                bottom: 150%;
                font-size: 15px;
            }
            .colors{
                font-size: 14px;
                box-shadow: 0 1px 3px rgba(0,0,0,0.12), 0 1px 2px rgba(0,0,0,0.24);
                background: white;
                 /*border-style: solid;
                 border-width: 3px;
                 border-color: #C6CFD6;
                 border-radius:20px; */
                 height:500px;
                 width: 15%;
                 margin: 0px 0px;
                 padding: 0px 0px;

                }
            .colors-div{
                    font-size: 14px;
                    background: white;
                 /*border-style: solid;
                 border-width: 3px;
                 border-color: #C6CFD6;
                 border-radius:20px; */
                 padding: 5px;
                }
            .colors-header{
                    margin: 0 auto;
                    background-color:#379441;
                    width: 115%;
                    height: 9%;
                    padding: 10px;
                    border-style: solid;
                    border-top-left-radius: 18px;
                    border-top-right-radius: 18px;
                    border-color: transparent;
                    margin-left: -15px;
                }
            .color-scheme-text{
                    font-size: 14px;

                }
            .color-text{
                    font-size: 10px;
        </style>
    </head>

    <body  style="background: #ECF0F5;">

        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" style="background-color: #379441;border: 0;" role="navigation">
            <?php include('calendar_header_user.php');?>
            <div class="container">
                <!-- Brand and toggle get grouped for better mobile display -->

                <!-- Collect the nav links, forms, and other content for toggling -->

                <!-- /.navbar-collapse -->
            </div>
            <!-- /.container -->
        </nav>

        <!-- Page Content -->
        <div class="form-row">
            <div class="col-md-10">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="row">
                            <div class="col-md-12">
                                <table id="example1" class="table table-bordered table-hover" style="margin-right:-10px">
                                    <div id="calendar" class="col-centered">
                                    </div>
                                </table>
                            </div><!--col end -->
                        </div><!--row end-->
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col (right) -->
            <div class="col-md-2 colors">
                <div class="box box-success">
                    <div class="box-body">
                        <div class="form-row">
                            <div class="col-md-10 colors-div">
                                <label class="color-scheme-text">ACTIVITY COLOR SCHEME:</label><br>
                                <a id="1" data-id="1" href="#" style="background:#FF0000;"class="btn btn-block text-white btn_appoint_type">SURGERY</a>
                                <a id="2" data-id="2" href="#" style="background:#008000;"class="btn btn-block text-white btn_appoint_type">CONSULTATION</a>
                                <a id="4" data-id="4" href="#" style="background:#FF8C00;"class="btn btn-block text-white btn_appoint_type">ENDOSCOPY</a>
                                <a id="3" data-id="3" href="#" style="background:#0071c5;"class="btn btn-block text-white btn_appoint_type">DIALYSIS</a>
                                <a id="all_appointments" data-id="all_appointments" href="#" style="background:gray;"class="btn btn-block text-white btn_appoint_type">ALL</a>

                                <hr class="sidebar-divider">

                                <div class="form-row">
                                    <input type="hidden" name="appoint_company_id" class="form-control" id="appoint_company_id" value="<?php echo $_SESSION['company_id'];?>">
                                    <input type="hidden" name="appoint_user_super_id" class="form-control" id="appoint_user_super_id">
                                    <input type="hidden" name="appoint_type_cl" class="form-control" id="appoint_type_cl" value="<?php echo $_SESSION['appoint_type'];?>">
                                    <div class="col-md-12 mb-12 form-group">
                                        <label for="appoint_doctor_cl">Doctor</label>
                                        <select class="form-control bg-light" name="appoint_doctor_cl" id="appoint_doctor_cl"> 
                                            <option value="all_doctors">ALL</option>
                                                <?php
                                                    $sql_doctor = "SELECT * FROM users WHERE user_type_id = 6 ORDER BY first_name ASC";
                                                    $result_doctor = mysqli_query($con,$sql_doctor);
                                                    while($row_doctor = mysqli_fetch_array($result_doctor))
                                                    {
                                                        if ($_SESSION['appoint_doctor'] !== 'all_doctors' && $row_doctor['first_name'] == $_SESSION['appoint_doctor']) {
                                                            echo '<option value = "'.$row_doctor['first_name'].'" selected="selected">'.$row_doctor['first_name'].'</option>';
                                                        }
                                                        else
                                                        {
                                                            echo '<option value = "'.$row_doctor['first_name'].'">'.$row_doctor['first_name'].'</option>';
                                                        };
                                                    };
                                                ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="col-md-12 mb-12 form-group">
                                        <label for="appoint_theatre_cl" class="control-label">Theatre</label>
                                        <select name="appoint_theatre_cl" class="form-control" id="appoint_theatre_cl">
                                            <option value="all_theatres">ALL</option>
                                            <?php
                                                $sql_theatre = "SELECT * FROM theatre ORDER BY theatre ASC";
                                                $result_theatre = mysqli_query($con,$sql_theatre);
                                                while($row_theatre = mysqli_fetch_array($result_theatre))
                                                {
                                                    if ($_SESSION['appoint_theatre'] !== 'all_theatres' && $row_theatre['theatre_id'] == $_SESSION['appoint_theatre']) {
                                                        echo '<option value = "'.$row_theatre['theatre_id'].'" selected="selected">'.$row_theatre['theatre'].'</option>';
                                                    }
                                                    else
                                                    {
                                                        echo '<option value = "'.$row_theatre['theatre_id'].'">'.$row_theatre['theatre'].'</option>';
                                                    };
                                                };
                                            ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div><!--row end-->
                    </div><!-- /.box-body -->
                </div>
                <!-- Date range -->
            </div>
            <!-- /.row -->
            <?php include('calendar_modal.php');?>
        </div>
        <!-- /.container -->

    <!-- jQuery Version 1.11.1 -->
    <script src="/js/jquery.js"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="/js/bootstrap.min.js"></script>
    <!-- FullCalendar -->
    <script src='/js/moment.min.js'></script>
    <!-- <script src='js/fullcalendar.min.js'></script> -->
    <script src='/js/fullcalendarxx.min.js'></script>
    <script src='/js/sweetalert.min.js'></script>
    <script src='/packages/list/main.js'></script>
    <script>
        $(document).ready(function() 
        {
            $('#calendar').fullCalendar({
            plugins: [ 'interaction', 'dayGrid', 'timeGrid', 'list' ],
            header: {
                left: 'prev,next',
                center: 'title',
                //right: 'month,agendaWeek,agendaDay,listDay,listWeek,listMonth',
                right: 'today,month,listWeek,listMonth',
            },
            views: {
                listDay: { buttonText: 'List day' },
                listWeek: { buttonText: 'List week' },
                listMonth: { buttonText: 'List month' },
                month: { buttonText: 'Month' },
                today: { buttonText: 'Today' },
                agendaWeek: { buttonText: 'Week' },
            },
            editable: true,
            eventLimit: true, // allow "more" link when too many events
            selectable: true,
            selectHelper: true,
            timeFormat:"h:mma",
            defaultView:'month',
            scrollTime: '08:00', // undo default 6am scrollTime
            eventOverlap:false,
            allDaySlot: false,

                select: function(start, end) 
                {
                    var dt = new Date();
                    var time = dt.getHours() + ":" + dt.getMinutes() + ":" + dt.getSeconds();
                    //$('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #date').val(moment(start).format('YYYY-MM-DD'));
                    $('#ModalAdd #time').val(time);
                    $('#ModalAdd #start').val(moment(start).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd #end').val(moment(end).format('YYYY-MM-DD HH:mm:ss'));
                    $('#ModalAdd').modal('show');
                },
                eventRender: function(event, element) 
                {
                    element.bind('dblclick', function() 
                    { //gawin mong CLICK yung parameter para maging single
                        $('#ModalEdit #patient_id').val(event.patient_id);
                        $('#ModalEdit #attend_id').val(event.attend_id);
                        $('#ModalEdit #name').val(event.name);
                        $('#ModalEdit #sex').val(event.gender_id);
                        $('#ModalEdit #age').val(event.age);
                        $('#ModalEdit #phone').val(event.phone);
                        $('#ModalEdit #email').val(event.email);
                        $('#ModalEdit #appoint_type').val(event.appoint_type_id);
                        $('#ModalEdit #doctor').val(event.doctor);
                        $('#ModalEdit #surgery').val(event.surgery);
                        $('#ModalEdit #anesthetist').val(event.anesthetist);
                        $('#ModalEdit #theatre').val(event.theatre_id);
                        $('#ModalEdit #id').val(event.id);
                        $('#ModalEdit #title').val(event.title);
                        $('#ModalEdit #color').val(event.color);
                        //$('#ModalEdit #start').val(event.start);
                        $('#ModalEdit #date').val(moment(event.date).format('YYYY-MM-DD'));
                        $('#ModalEdit #time').val(event.time);
                        $('#ModalEdit #start').val(moment(event.start).format('YYYY-MM-DD HH:mm:ss'));
                        $('#ModalEdit #end').val(moment(event.end).format('YYYY-MM-DD HH:mm:ss'));
                        //	$('#ModalEdit #end').val(event.end);
                        $('#ModalEdit').modal('show');
                          //var formattedTime = $.fullCalendar.formatDates(event.start, event.end, "HH:mm { - HH:mm}");
                    });
                },

                eventDrop: function(event, delta, revertFunc) 
                { 
                    edit(event);
                },
                eventResize: function(event, dayDelta, minuteDelta, revertFunc) 
                { 
                    edit(event);
                },
                eventMouseover: function(Event, jsEvent) 
                {
                    var tooltip = '<div class="tooltip" >' +'<b>NAME :</b>&nbsp;'+ Event.name + '<br><b>AGE :</b>&nbsp;'+Event.age + '<br><b>TIME :</b>&nbsp;'+Event.time+'<br><b>DOCTOR :</b>&nbsp;'+Event.doctor+'<br><b>SURGERY :</b>&nbsp;'+Event.surgery+'</div>';
                    var $tooltip = $(tooltip).appendTo('body');
                    $(this).mouseover(function(e) {
                        $(this).css('z-index', 10000);
                        $tooltip.fadeIn('500');
                        $tooltip.fadeTo('10', 1.9);
                    }).mousemove(function(e) {
                        $tooltip.css('top', e.pageY + 10);
                        $tooltip.css('left', e.pageX + 20);
                    });
                },

                eventMouseout: function(Event, jsEvent) 
                {
                    $(this).css('z-index', 8);
                    $('.tooltip').remove();
                },

                events: [
                <?php foreach($events as $event):
                    $start = explode(" ", $event['start']);
                    $end = explode(" ", $event['end']);
                    if($start[1] == '00:00:00')
                    {
                        $start = $start[0];
                    }
                    else
                    {
                        $start = $event['start'];
                    }
                    if($end[1] == '00:00:00')
                    {
                        $end = $end[0];
                    }
                    else
                    {
                        $end = $event['end'];
                    }
                ?>
                    {
                        id: '<?php echo $event['id']; ?>',
                        title: '<?php echo $event['title']; ?>',
                        date: '<?php echo $event['date']; ?>',
                        time: '<?php echo $event['time']; ?>',
                        start: '<?php echo $start; ?>',
                        end: '<?php echo $end; ?>',
                        color: '<?php echo $event['color']; ?>',
                        patient_id: '<?php echo $event['patient_id'];?>',
                        attend_id: '<?php echo $event['attend_id'];?>',
                        gender_id: '<?php echo $event['gender_id'];?>',
                        age: '<?php echo $event['age'];?>',
                        phone: '<?php echo $event['phone'];?>',
                        email: '<?php echo $event['email'];?>',
                        appoint_type_id: '<?php echo $event['appoint_type_id'];?>',
                        doctor: '<?php echo $event['doctor'];?>',
                        surgery: '<?php echo $event['surgery_id'];?>',
                        anesthetist: '<?php echo $event['anesthetist'];?>',
                        theatre_id: '<?php echo $event['theatre_id'];?>',
                        name: '<?php echo $event['name'];?>',
                        title: '<?php echo $event['title'];?>',
                        color: '<?php echo $event['color'];?>',
                    },
                <?php endforeach; ?>
                ]
            });


            function edit(event){
                start = event.start.format('YYYY-MM-DD HH:mm:ss');
                if(event.end)
                {
                    end = event.end.format('YYYY-MM-DD HH:mm:ss');
                }else
                {
                    end = start;
                };
                date = event.date;
                time = event.time;
                id =  event.id;
                patient_id = event.patient_id;
                attend_id = event.attend_id;
                gender_id = event.gender_id;
                age = event.age;
                phone = event.phone;
                email = event.email;
                appoint_type_id = event.appoint_type_id;
                doctor = event.doctor;
                surgery = event.surgery_id;
                anesthetist = event.anesthetist;
                theatre_id = event.theatre_id;
                name = event.name;
                title = event.title;
                color = event.color;

                Event = [];
                Event[0] = id;
                Event[1] = start;
                Event[2] = end;
                Event[3] = patient_id;
                Event[4] = attend_id;
                Event[5] = gender_id;
                Event[6] = age;
                Event[7] = phone;
                Event[8] = email;
                Event[9] = appoint_type_id;
                Event[10] = doctor;
                Event[11] = surgery;
                Event[12] = anesthetist;
                Event[13] = theatre_id;
                Event[14] = name;
                Event[15] = title;
                Event[16] = color;
                Event[17] = date;
                Event[18] = time;

                $.ajax({
                    url: 'calendar_editEventDate.php',
                    type: "POST",
                    data: {Event:Event},
                    success: function(rep) 
                    {
                        if(rep == 'OK')
                        {
                            swal("Done!","Successfully MOVED!","success");
                        }
                        else
                        {
                            swal("Cancelled", "Could not be saved. Please try again", "error");
                        }
                    }
                });
            }
        });
    </script>
    <script src="/js/functionsx.js"></script>
    </body>

    </html>
