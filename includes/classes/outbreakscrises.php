<?php



class outbreak
{

    public static function getConnection(){
        $dbConfig = database::getDBConfigs();
        $servername = $dbConfig['host'];
        $username = $dbConfig['user'];
        //$password = "";
        $password = $dbConfig['password'];
        $dbname = $dbConfig['database'];

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {

            die("Connection failed: " . $conn->connect_error);
        }

        return $conn;

    }

    public static function getOutbreaksData()
    {

        $content = '

                          <div class="card mb-2">
								<!--begin::Card body-->
								<div class="card-body p-10 p-lg-15">
									<!--begin::Title-->
									<h2 class="fw-bolder text-dark mb-12 ps-0">Filter Date Range</h2>
									<!--end::Title-->
									<!--begin::Row-->
									<div class="row">
										
									
<div class="col-lg-2">
	<form action="#" method="post">
	<label class="fs-6 form-label fw-bolder text-dark">Date From</label>
<input type="date" name="date_from" class="form-control form-control form-control-solid" required>
	</div>
<div class="col-lg-2">
<label class="fs-6 form-label fw-bolder text-dark">Date to</label>
<input type="date" class="form-control form-control form-control-solid" name="date_to" required>
																
															</select>
</div>

<div class="col-lg-3">
<label class="fs-6 form-label fw-bolder text-dark">&nbsp; </label> <br />
<input type="hidden" name="action" value="getOutbreaksCrises">
<button type="submit" class="btn btn-primary me-5">Get Outbreak/Crises </button>
	</form>



</div>
										
										
										
									</div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>



                  
										
										
										
									




';


        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {

            $date_from =$_REQUEST['date_from'];
            $date_to =$_REQUEST['date_to'];

            $_SESSION['outbreak_datefrom'] = $date_from;
            $_SESSION['outbreak_dateto'] = $date_to;


            $content .= '
 <div class="card mb-2">
								<!--begin::Card body-->
								<div class="card-body p-10 p-lg-15">
									<!--begin::Title-->
									<h3 class="fw-bold text-dark mb-12 ps-0">Heat Map showing Incidents reports in the period  from  '.$date_from.' to '.$date_to.'</h3>
									<!--end::Title-->
									<!--begin::Row-->
									<div class="row">

<div class="panel-body" style="padding-left:20px;">
<div class="row col-md-10" >
<div class="col-md-9">
<div id="map"></div>
</div>
<div class="col-md-3" style="padding-top: 100px;padding-left: 50px">
<table>
<tr>
<td style="background-color: #2d931d">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">No Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ddd72c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">1 - 3 Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ed1717">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">4+ Incidents Reported</td>
</tr>
</table>
</div>

</div>

';
            $sql = database::performQuery("SELECT DATE(a8) as a8 FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(a8)");
            if ($sql->num_rows > 0) {


                $dates=[];
                $crisis = [];
                $outbreaks = [];
                //Set heat map here
                while ($data = $sql->fetch_assoc()) {
                    $dates[] = "'$data[a8]'";
                    $crisis[] = self::countCrisesOnDate($data['a8']);
                    $outbreaks[] = self::countOutbreakOnDate($data['a8']);
                }

                $_SESSION['outbreaks_dates'] = implode(',',$dates);
                $_SESSION['outbreaks_crises'] = implode(',',$crisis);
                $_SESSION['outbreaks_outbreaks'] = implode(',',$outbreaks);
                $_SESSION['outbreaks_title'] = "Outbreaks and Crises reported in the period  from  $date_from to $date_to";
                $content .= '


</div>
</div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>


 <div class="card mb-2">
								<!--begin::Card body-->
								<div class="card-body p-10 p-lg-15">
									<!--begin::Title-->
									<h3 class="fw-bold text-dark mb-12 ps-0"> Incidents Graph reports in the period  from  '.$date_from.' to '.$date_to.'</h3>
									<!--end::Title-->
									<!--begin::Row-->
									<div class="row">

<div class="col-md-6"><div class="panel-body" id="outbreakcrisishisto"></div></div>
<div class="col-md-6"><div class="panel-body" id="container"></div></div>

</div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>
							
							
							
							<div class="card mb-2">
								<!--begin::Card body-->
								<div class="card-body p-10 p-lg-15">
									<!--begin::Title-->
									<h3 class="fw-bold text-dark mb-12 ps-0">Incidents data in the period  from  '.$date_from.' to '.$date_to.'</h3>
									<!--end::Title-->
									<!--begin::Row-->
									<div class="row">

';
              //Paginate Results here

                //Main query
                $pages = new Paginator;
                $pages->default_ipp = 10;
                $sql_forms = database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'");
                $pages->items_total = $sql_forms->num_rows;
                $pages->mid_range = 7;
                $pages->paginate();


                $result	=	database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' ORDER BY id DESC ".$pages->limit." ");

                $content .=' <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    
                                 
                                    </div>
                                        <table  id="basic-datatable" class="table table-bordered table-striped ">
                                            <thead>
                                                <tr class="bold fw-bolder">
                                                    <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Entreprize</th>
                                                    <th>Location/<br />Subcounty/Parish</th>
                                                    <th>Status</th>
                                                    <th>Ref/<br />Phone</th>
                                                     <th>Description</th>
                                               
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>';


                if($pages->items_total>0){
                    while($data  =   $result->fetch_assoc()){


                        $content .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td>'.$data['a10'].'</td>
                                        
                                    </tr>';

                    }
                }
                $content.='</tbody>
		                                          </table>
                                           
                                     <div class="clearfix"></div>

                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

                if($pages->items_total > 0) {
                    $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
                    $content.= '<td>'.$pages->display_items_per_page().'</td>';
                    $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
                }
                $content.=' </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';






  $content .= '

</div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>

';


            } else {
                $content .= 'No records found for this location for that period.';
                $_SESSION['location_title'] = '';
                $_SESSION['next7daysprecamount'] = '';
                $_SESSION['next7daysprecchance'] = '';
                $_SESSION['next7daystempmin'] = '';
                $_SESSION['next7daystempmax'] = '';
                $_SESSION['next7daysdates'] = '';


                $content .= '


</div>
</div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>


';
            }


        }

        return $content;
    }

    public static function getOutbreaksData3()
    {
        $scripts = '
            <script src="https://code.highcharts.com/highcharts.js"></script>
            <script src="https://code.highcharts.com/modules/series-label.js"></script>
            <script src="https://code.highcharts.com/modules/exporting.js"></script>
            <script src="https://code.highcharts.com/modules/export-data.js"></script>

            <script type="text/javascript">       
                  /*Outbreaks Histo*/
                Highcharts.chart(\'outbreakcrisishisto\', {
                    title: {
                        text: \'Incidents Reported\'
                    },
                    subtitle: {
                        text:  \'' . $_SESSION['outbreaks_title'] . '\'
                    },
                    yAxis: {
                        title: {
                            text: \'No. of Incidents Reported\'
                        }
                    },
                    legend: {
                        layout: \'vertical\',
                        align: \'right\',
                        verticalAlign: \'middle\'
                    },
                   xAxis: {
                        categories: [' . $_SESSION['outbreaks_dates'] . ']
                    },
                    series: [{
                        name: \'Crises\',
                        data: [' . $_SESSION['outbreaks_crises'] . ']
                    },{
                        name: \'Outbreaks\',
                        data: [' . $_SESSION['outbreaks_outbreaks'] . ']
                    }],

                    responsive: {
                        rules: [{
                            condition: {
                                maxWidth: 500
                            },
                            chartOptions: {
                                legend: {
                                    layout: \'horizontal\',
                                    align: \'center\',
                                    verticalAlign: \'bottom\'
                                }
                            }
                        }]
                    }

                });


                // Build the chart
                Highcharts.chart(\'outbreakcrisispie\', {
                    chart: {
                        plotBackgroundColor: null,
                        plotBorderWidth: null,
                        plotShadow: false,
                        type: \'pie\'
                    },
                    title: {
                        text: \'Incidents Reported by Type\'
                    },
                    tooltip: {
                        pointFormat: \'{series.name}: <b>{point.percentage:.1f}%</b>\'
                    },
                    accessibility: {
                        point: {
                            valueSuffix: \'%\'
                        }
                    },
                    plotOptions: {
                        pie: {
                            allowPointSelect: true,
                            cursor: \'pointer\',
                            dataLabels: {
                                enabled: false
                            },
                            showInLegend: true
                        }
                    },
                    series: [{
                        name: \'Incidents\',
                        colorByPoint: true,
                        data: [{
                            name: \'Outbreaks\',
                            y: '.$_SESSION['outbreaks_all'].',
                            sliced: true,
                            selected: true
                        }, {
                            name: \'Crises\',
                            y: '.$_SESSION['crises_all'].'
                        }]
                    }]
                });
                  
                </script>


                <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.3/jquery.mousewheel.min.js"></script>
                <script type="text/javascript" src="' . ROOT . '/includes/theme/maps/js/mapsvg.min.js"></script>
                ' . js::prepJs().'

                '.map::plotOutbreaksHeatMap();

        $content = '<div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Filter Crises/Outbreaks by Date Range!</strong></p>
                                            <!-- form -->
                                                <form action="#" method="POST">

                                                <div class="row"> 
                                                    <div class="form-group col-lg-5">
                                                        <label class="form-label mb-1 text-2">Date FROM</label>
                                                        <input type="date" name="date_from" class="form-control text-3 h-auto py-2" required>
                                                    </div>
                                                    <div class="form-group col-lg-5">
                                                        <label class="form-label mb-1 text-2">Date TO</label>
                                                        <input type="date" class="form-control text-3 h-auto py-2" name="date_to" required>
                                                    </div>
                                                    <div class="form-group col-lg-2">
                                                        <input type="hidden" name="action" value="getOutbreaksCrises">
                                                        <input type="submit" value="Filter" class="btn btn-primary btn-modern" style="margin-top: 1.9rem !important" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- map row -->

                    <!-- new row -->

                </div>';


        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {

            $date_from =$_REQUEST['date_from'];
            $date_to =$_REQUEST['date_to'];

            $_SESSION['outbreak_datefrom'] = $date_from;
            $_SESSION['outbreak_dateto'] = $date_to;


            $content .= '

                <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                        <div class="card mb-2">
                              <!--begin::Card body-->
                              <div class="card-body p-10 p-lg-15">
                                <!--begin::Title-->
                                <h4 class="fw-bold text-dark mb-12 ps-0">Heat Map showing Incidents reports in the period from '.$date_from.' to '.$date_to.'</h4>
                                <!--end::Title-->
                                <!--begin::Row-->
                                <div class="row">
                                  <div class="panel-body" style="padding-left:20px;">
                                    <div class="row col-md-10">
                                      <div class="col-md-9">
                                        <div id="map"></div>
                                      </div>
                                      <div class="col-md-3" style="padding-top: 100px;padding-left: 50px">
                                        <table>
                                          <tr>
                                            <td style="background-color: #2d931d">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="padding-left: 10px">No Incidents Reported</td>
                                          </tr>
                                          <tr>
                                            <td style="background-color: #ddd72c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="padding-left: 10px">1 - 3 Incidents Reported</td>
                                          </tr>
                                          <tr>
                                            <td style="background-color: #ed1717">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                            <td style="padding-left: 10px">4+ Incidents Reported</td>
                                          </tr>
                                        </table>
                                      </div>
                                    </div>';

            $sql = database::performQuery("SELECT DATE(a8) as a8 FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(a8)");
            if ($sql->num_rows > 0) {


                $dates=[];
                $crisis = [];
                $outbreaks = [];
                //Set heat map here
                while ($data = $sql->fetch_assoc()) {
                    $dates[] = "'$data[a8]'";
                    $crisis[] = self::countCrisesOnDate($data['a8']);
                    $outbreaks[] = self::countOutbreakOnDate($data['a8']);
                }
                $_SESSION['outbreaks_all'] = self::countAllOutbreakOnDates();
                $_SESSION['crises_all']  = self::countAllCrisesOnDates();
                $_SESSION['outbreaks_dates'] = implode(',',$dates);
                $_SESSION['outbreaks_crises'] = implode(',',$crisis);
                $_SESSION['outbreaks_outbreaks'] = implode(',',$outbreaks);
                $_SESSION['outbreaks_title'] = "Outbreaks and Crises reported in the period  from  $date_from to $date_to";
                $content .= '


                                        </div>
                                        </div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>
                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->



                <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                             <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported </h4>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">

                                        <div class="col-md-12 col-xxl-12"><div class="panel-body" id="outbreakcrisispie"></div></div>
                                
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->  


                <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                             <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported per given day</h4>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">

                                        <div class="col-md-12 col-xxl-12"><div class="panel-body" id="outbreakcrisishisto"></div></div>
                                
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->  


    <div class="container py-4">
        <div class="row mb-2">
            <div class="col">
							
				<div class="card mb-2">
                    <!--begin::Card body-->
                    <div class="card-body p-10 p-lg-15">
                        <!--begin::Title-->
                        <h4 class="fw-bold text-dark mb-12 ps-0">Incidents data in the period  from  '.$date_from.' to '.$date_to.'</h4>
                        <!--end::Title-->
                        <!--begin::Row-->
                        <div class="row">';

                $content .='
                            <div class="col-12">
                                <table  id="basic-datatable" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr class="bold fw-bolder">
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Entreprize</th>
                                            <th>Location/<br />Subcounty/Parish</th>
                                            <th>Status</th>
                                            <th>Ref/<br />Phone</th>
                                            <th>Description</th>
                                       
                                          
                                        </tr>
                                    </thead>
                                    <tbody>';

                //Paginate Results here

                //Main query
                $pages = new Paginator;
                $pages->default_ipp = 10;
                $sql_forms = database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'");
                $pages->items_total = $sql_forms->num_rows;
                $pages->mid_range = 7;
                $pages->paginate();


                $result =   database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'   ORDER BY id DESC ".$pages->limit." ");


                if($pages->items_total>0){
                    while($data  =   $result->fetch_assoc()){


                        $content .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td>'.$data['a10'].'</td>
                                        
                                    </tr>';

                    }
                }

                $content.='</tbody>
                                </table>
                                           
                                     <div class="clearfix"></div>

                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

                if($pages->items_total > 0) {
                    $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
                    $content.= '<td>'.$pages->display_items_per_page().'</td>';
                    $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
                }

                                    $content.=' </div>
                                        </div>
                                    </div>
                                ';

                        $content .= '
                                        </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->';


            } else {
                $content .= 'No records found for that period.';
               //TODO Set outbreaks session variables here


                $content .= '

                                        </div>
                                        </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->';
            }


        }

        else
        {

            $date_from = '12-01-2021';
            $date_to = makeMySQLDate();

            $_SESSION['outbreak_datefrom'] = $date_from;
            $_SESSION['outbreak_dateto'] = $date_to;


            $content .= '

                <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                        <div class="card mb-2">
                               <!--begin::Card body-->
                               <div class="card-body p-10 p-lg-15">
                                 <!--begin::Title-->
                                 <h4 class="fw-bold text-dark mb-12 ps-0">Heat Map showing Incidents reports in the period from '.$date_from.' to '.$date_to.'</h4>
                                 <!--end::Title-->
                                 <!--begin::Row-->
                                 <div class="row">
                                   <div class="panel-body" style="padding-left:20px;">
                                     <div class="row col-md-10">
                                       <div class="col-md-9">
                                         <div id="map"></div>
                                       </div>
                                       <div class="col-md-3" style="padding-top: 100px;padding-left: 50px">
                                         <table>
                                           <tr>
                                             <td style="background-color: #2d931d">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                             <td style="padding-left: 10px">No Incidents Reported</td>
                                           </tr>
                                           <tr>
                                             <td style="background-color: #ddd72c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                             <td style="padding-left: 10px">1 - 3 Incidents Reported</td>
                                           </tr>
                                           <tr>
                                             <td style="background-color: #ed1717">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                                             <td style="padding-left: 10px">4+ Incidents Reported</td>
                                           </tr>
                                         </table>
                                       </div>
                                     </div>';
                                     
            $sql = database::performQuery("SELECT DATE(a8) as a8 FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(a8)");
            if ($sql->num_rows > 0) {


                $dates=[];
                $crisis = [];
                $outbreaks = [];
                //Set heat map here
                while ($data = $sql->fetch_assoc()) {
                    $dates[] = "'$data[a8]'";
                    $crisis[] = self::countCrisesOnDate($data['a8']);
                    $outbreaks[] = self::countOutbreakOnDate($data['a8']);
                }
                $_SESSION['outbreaks_all'] = self::countAllOutbreakOnDates();
                $_SESSION['crises_all']  = self::countAllCrisesOnDates();
                $_SESSION['outbreaks_dates'] = implode(',',$dates);
                $_SESSION['outbreaks_crises'] = implode(',',$crisis);
                $_SESSION['outbreaks_outbreaks'] = implode(',',$outbreaks);
                $_SESSION['outbreaks_title'] = "Outbreaks and Crises reported in the period  from  $date_from to $date_to";
                $content .= '


                                        </div>
                                        </div>
									<!--end::Row-->
								</div>
								<!--end::Card body-->
							</div>
                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->


                    <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                             <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported </h4>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">

                                        <div class="col-md-12 col-xxl-12"><div class="panel-body" id="outbreakcrisispie"></div></div>
                                
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->  


                <div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

                             <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported per given day</h4>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">

                                        <div class="col-md-12 col-xxl-12"><div class="panel-body" id="outbreakcrisishisto"></div></div>
                                
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->   
							
							
				<div class="container py-4">
                    <div class="row mb-2">
                        <div class="col">

							<div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h4 class="fw-bold text-dark mb-12 ps-0">Incidents data in the period  from  '.$date_from.' to '.$date_to.'</h4>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">';



                $content .='
                            <div class="col-12">
                                <table  id="basic-datatable" class="table table-bordered table-striped ">
                                    <thead>
                                        <tr class="bold fw-bolder">
                                            <th>ID</th>
                                            <th>Type</th>
                                            <th>Date</th>
                                            <th>Entreprize</th>
                                            <th>Location/<br />Subcounty/Parish</th>
                                            <th>Status</th>
                                            <th>Ref/<br />Phone</th>
                                             <th>Description</th>
                                       
                                          
                                        </tr>
                                    </thead>
                                    <tbody>';

                //Paginate Results here

                //Main query
                $pages = new Paginator;
                $pages->default_ipp = 10;
                $sql_forms = database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'");
                $pages->items_total = $sql_forms->num_rows;
                $pages->mid_range = 7;
                $pages->paginate();


                $result =   database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'   ORDER BY id DESC ".$pages->limit." ");


                if($pages->items_total>0){
                    while($data  =   $result->fetch_assoc()){


                        $content .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td>'.$data['a10'].'</td>
                                        
                                    </tr>';

                    }
                }
                $content.='</tbody>
                                                  </table>

                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

                if($pages->items_total > 0) {
                    $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
                    $content.= '<td>'.$pages->display_items_per_page().'</td>';
                    $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
                }
                $content.=' </div>
                                        </div>
                                </div>
                        ';






                $content .= '

                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->';


            } else {
                $content .= 'No records found for that period.';
                //TODO Set outbreaks session variables here


                $content .= '

                                        </div>
                                        </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>

                        </div><!--end::Col-->
                    </div><!--end::Row-->
                </div><!--end::Container-->';
            }
        }

        $styles = '
                    <link href="'.ROOT.'/includes/theme/maps/css/mapsvg.css" rel="stylesheet">
                    <style>
                        .table td, .table th {
                            font-size: 14px;
                        }
                    </style>';

        return [
            'content' => $content,
            'styles' => $styles,
            'scripts' => $scripts
        ];
    }

    public static function getOutbreaksData2()
    {

        $content = '
  
                          <div class="card mb-2">
                          
                          
                          <div class ="text-right">
                          <a href="' . ROOT . '/?action=reportOutbreaksCrises" ><button type="button" class="btn btn-primary">Report Outbreak</button></a>
                         </div> 
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h2 class="fw-bolder text-dark mb-12 ps-0">Filter Date Range</h2>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">
                                        
                                    
<div class="col-lg-2">
    <form action="#" method="post">
    <label class="fs-6 form-label fw-bolder text-dark">Date From</label>
<input type="date" name="date_from" class="form-control form-control form-control-solid" required>
    </div>
<div class="col-lg-2">
<label class="fs-6 form-label fw-bolder text-dark">Date to</label>
<input type="date" class="form-control form-control form-control-solid" name="date_to" required>
                                                                
                                                            </select>
</div>
<div class="col-lg-3">
<label class="fs-6 form-label fw-bolder text-dark">&nbsp; </label> <br />
<input type="hidden" name="action" value="getOutbreaksCrises">
<button type="submit" class="btn btn-primary me-5">Get Outbreak/Crises </button>
    </form>
</div>
                                        
                                        
                                        
                                    </div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
              
                                        
                                        
                                        
                                    
';


        if (isset($_REQUEST['date_from']) && isset($_REQUEST['date_to'])) {

            $date_from =$_REQUEST['date_from'];
            $date_to =$_REQUEST['date_to'];

            $_SESSION['outbreak_datefrom'] = $date_from;
            $_SESSION['outbreak_dateto'] = $date_to;


            $content .= '
 <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h3 class="fw-bold text-dark mb-12 ps-0">Heat Map showing Incidents reports in the period  from  '.$date_from.' to '.$date_to.'</h3>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">
<div class="panel-body" style="padding-left:20px;">
<div class="row col-md-10" >
<div class="col-md-9">
<div id="map"></div>
</div>
<div class="col-md-3" style="padding-top: 100px;padding-left: 50px">
<table>
<tr>
<td style="background-color: #2d931d">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">No Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ddd72c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">1 - 3 Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ed1717">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">4+ Incidents Reported</td>
</tr>
</table>
</div>
</div>
';
            $sql = database::performQuery("SELECT DATE(a8) as a8 FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(a8)");
            if ($sql->num_rows > 0) {


                $dates=[];
                $crisis = [];
                $outbreaks = [];
                //Set heat map here
                while ($data = $sql->fetch_assoc()) {
                    $dates[] = "'$data[a8]'";
                    $crisis[] = self::countCrisesOnDate($data['a8']);
                    $outbreaks[] = self::countOutbreakOnDate($data['a8']);
                }
                $_SESSION['outbreaks_all'] = self::countAllOutbreakOnDates();
                $_SESSION['crises_all']  = self::countAllCrisesOnDates();
                $_SESSION['outbreaks_dates'] = implode(',',$dates);
                $_SESSION['outbreaks_crises'] = implode(',',$crisis);
                $_SESSION['outbreaks_outbreaks'] = implode(',',$outbreaks);
                $_SESSION['outbreaks_title'] = "Outbreaks and Crises reported in the period  from  $date_from to $date_to";
                $content .= '
</div>
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
 <div class="card mb-2">
    <!--begin::Card body-->
    <div class="card-body p-10 p-lg-15">
        <!--begin::Title-->
        <h3 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported </h3>
        <!--end::Title-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-6 col-xxl-6"><div class="panel-body" id="outbreakcrisispie"></div></div>
            <div class="col-md-6 col-xxl-6"><div class="panel-body" id="outbreakcrisishisto"></div></div>
    
        </div>
        <!--end::Row-->
    </div>
    <!--end::Card body-->
</div>  
                            
                            
                            
                            <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h3 class="fw-bold text-dark mb-12 ps-0">Incidents data in the period  from  '.$date_from.' to '.$date_to.'</h3>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">
';
                //Paginate Results here

                //Main query
                $pages = new Paginator;
                $pages->default_ipp = 10;
                $sql_forms = database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'");
                $pages->items_total = $sql_forms->num_rows;
                $pages->mid_range = 7;
                $pages->paginate();


                $result =   database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'   ORDER BY id DESC ".$pages->limit." ");



                $content .=' <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    
                                 
                                    </div>
                                        <table  id="basic-datatable" class="table table-bordered table-striped ">
                                            <thead>
                                                <tr class="bold fw-bolder">
                                                    <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Entreprize</th>
                                                    <th>Location/<br />Subcounty/Parish</th>
                                                    <th>Status</th>
                                                    <th>Ref/<br />Phone</th>
                                                     <th>Description</th>
                                               
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>';


                if($pages->items_total>0){
                    while($data  =   $result->fetch_assoc()){


                        $content .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td>'.$data['a10'].'</td>
                                        
                                    </tr>';

                    }
                }
                $content.='</tbody>
                                                  </table>
                                           
                                     <div class="clearfix"></div>
                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

                if($pages->items_total > 0) {
                    $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
                    $content.= '<td>'.$pages->display_items_per_page().'</td>';
                    $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
                }
                $content.=' </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';






                $content .= '
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
';


            } else {
                $content .= 'No records found for that period.';
               //TODO Set outbreaks session variables here


                $content .= '
</div>
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
';
            }


        }

        else
        {




            $date_from = '12-01-2021';
            $date_to = makeMySQLDate();

            $_SESSION['outbreak_datefrom'] = $date_from;
            $_SESSION['outbreak_dateto'] = $date_to;


            $content .= '
 <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h3 class="fw-bold text-dark mb-12 ps-0">Heat Map showing Incidents reports in the period  from  '.$date_from.' to '.$date_to.'</h3>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">
<div class="panel-body" style="padding-left:20px;">
<div class="row col-md-10" >
<div class="col-md-9">
<div id="map"></div>
</div>
<div class="col-md-3" style="padding-top: 100px;padding-left: 50px">
<table>
<tr>
<td style="background-color: #2d931d">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">No Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ddd72c">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">1 - 3 Incidents Reported</td>
</tr>
<tr>
<td style="background-color: #ed1717">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
<td style="padding-left: 10px">4+ Incidents Reported</td>
</tr>
</table>
</div>
</div>
';
            $sql = database::performQuery("SELECT DATE(a8) as a8 FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to' GROUP BY DATE(a8)");
            if ($sql->num_rows > 0) {


                $dates=[];
                $crisis = [];
                $outbreaks = [];
                //Set heat map here
                while ($data = $sql->fetch_assoc()) {
                    $dates[] = "'$data[a8]'";
                    $crisis[] = self::countCrisesOnDate($data['a8']);
                    $outbreaks[] = self::countOutbreakOnDate($data['a8']);
                }
                $_SESSION['outbreaks_all'] = self::countAllOutbreakOnDates();
                $_SESSION['crises_all']  = self::countAllCrisesOnDates();
                $_SESSION['outbreaks_dates'] = implode(',',$dates);
                $_SESSION['outbreaks_crises'] = implode(',',$crisis);
                $_SESSION['outbreaks_outbreaks'] = implode(',',$outbreaks);
                $_SESSION['outbreaks_title'] = "Outbreaks and Crises reported in the period  from  $date_from to $date_to";
                $content .= '
</div>
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
 <div class="card mb-2">
    <!--begin::Card body-->
    <div class="card-body p-10 p-lg-15">
        <!--begin::Title-->
        <h3 class="fw-bold text-dark mb-12 ps-0">Graphical representation of Incidents reported </h3>
        <!--end::Title-->
        <!--begin::Row-->
        <div class="row">
            <div class="col-md-6 col-xxl-6"><div class="panel-body" id="outbreakcrisispie"></div></div>
            <div class="col-md-6 col-xxl-6"><div class="panel-body" id="outbreakcrisishisto"></div></div>
    
        </div>
        <!--end::Row-->
    </div>
    <!--end::Card body-->
</div>  
                            
                            
                            
                            <div class="card mb-2">
                                <!--begin::Card body-->
                                <div class="card-body p-10 p-lg-15">
                                    <!--begin::Title-->
                                    <h3 class="fw-bold text-dark mb-12 ps-0">Incidents data in the period  from  '.$date_from.' to '.$date_to.'</h3>
                                    <!--end::Title-->
                                    <!--begin::Row-->
                                    <div class="row">
';
                //Paginate Results here

                //Main query
                $pages = new Paginator;
                $pages->default_ipp = 10;
                $sql_forms = database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'");
                $pages->items_total = $sql_forms->num_rows;
                $pages->mid_range = 7;
                $pages->paginate();


                $result =   database::performQuery("SELECT * FROM `mod_crisis` WHERE DATE(a8) BETWEEN '$date_from' AND '$date_to'   ORDER BY id ASC ".$pages->limit." ");



                $content .=' <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                    
                                 
                                    </div>
                                        <table  id="basic-datatable" class="table table-bordered table-striped ">
                                            <thead>
                                                <tr class="bold fw-bolder">
                                                    <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Entreprize</th>
                                                    <th>Location/<br />Subcounty/Parish</th>
                                                    <th>Status</th>
                                                    <th>Ref/<br />Phone</th>
                                                     <th>Description</th>
                                               
                                                  
                                                </tr>
                                            </thead>
                                            <tbody>';


                if($pages->items_total>0){
                    while($data  =   $result->fetch_assoc()){


                        $content .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td>'.$data['a10'].'</td>
                                        
                                    </tr>';

                    }
                }
                $content.='</tbody>
                                                  </table>
                                           
                                     <div class="clearfix"></div>
                                     <div class="row marginTop">
                                            <div class="col-sm-12 paddingLeft pagerfwt">';

                if($pages->items_total > 0) {
                    $content.= '<table width="100%"><tr><td>'.$pages->display_pages().'</td>';
                    $content.= '<td>'.$pages->display_items_per_page().'</td>';
                    $content.= '<td>'.$pages->display_jump_menu().'</td></tr></table>';
                }
                $content.=' </div>
                                            <div class="clearfix"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        ';






                $content .= '
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
';


            } else {
                $content .= 'No records found for that period.';
                //TODO Set outbreaks session variables here


                $content .= '
</div>
</div>
                                    <!--end::Row-->
                                </div>
                                <!--end::Card body-->
                            </div>
';
            }






        }

        return $content;
    }

    //Return IDs for District with regions
    public static function activeWarning()
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id,district.name,COUNT(*) FROM district,mod_crisis WHERE district.name=mod_crisis.a1 AND DATE(a8) BETWEEN '$_SESSION[outbreak_datefrom]' AND '$_SESSION[outbreak_dateto]' GROUP BY district.name HAVING COUNT(*) > 0 AND COUNT(*) < 4");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return $content;
    }

    //Return IDs for District with regions
    public static function activeDanger()
    {
        $content = [];

        $sql =  database::performQuery("SELECT map_id,district.name,COUNT(*) FROM district,mod_crisis WHERE district.name=mod_crisis.a1  AND DATE(a8) BETWEEN '$_SESSION[outbreak_datefrom]' AND '$_SESSION[outbreak_dateto]'  GROUP BY district.name HAVING COUNT(*) > 3");
        while($data = $sql->fetch_assoc()){
            $content[]= 'UG-'.$data['map_id'].'';
        }

        return $content;
    }


    public static function prepMapSwitchOutbreaks(){

        $yellow = self::activeWarning();
        $red = self::activeDanger();
        $content = 'switch(region.id){';

        if (count($yellow) > 0) {
            foreach($yellow as $region){

                $content .= "case '$region': ";
            }
            $content .= '
            region.setFill(\'#ddd72c\');
            break;';
        }

        if (count($red) > 0) {
            foreach($red as $region){

                $content .= "case '$region': ";
            }
            $content .= '
            region.setFill(\'#ed1717\');
            break;';
        }

        $content .='default:
        region.setFill(\'#2d931d\');
        break;
        
        }';
        return $content;
    }

    public static function countCrisesOnDate($date)
    {
        $sql =  database::performQuery("SELECT * FROM mod_crisis WHERE a9='Crisis'  AND DATE(a8) ='$date'");
        return $sql->num_rows;
    }


    public static function countAllCrisesOnDates()
    {
        $sql =  database::performQuery("SELECT * FROM mod_crisis WHERE a9='Crisis'  AND DATE(a8) BETWEEN '$_SESSION[outbreak_datefrom]' AND '$_SESSION[outbreak_dateto]'");
        return $sql->num_rows;
    }


    public static function countOutbreakOnDate($date)
    {
        $sql =  database::performQuery("SELECT * FROM mod_crisis WHERE a9='Outbreak'  AND DATE(a8) ='$date'");
        return $sql->num_rows;
    }

    public static function countAllOutbreakOnDates()
    {
        $sql =  database::performQuery("SELECT * FROM mod_crisis WHERE a9='Outbreak'  AND DATE(a8) BETWEEN '$_SESSION[outbreak_datefrom]' AND '$_SESSION[outbreak_dateto]'");
        return $sql->num_rows;
    }

    public function saveCrisisOutbreaks(){

        $district = database::prepData($_REQUEST['a1']);
        $sql= database::performQuery("SELECT `name` FROM district WHERE id=$district  LIMIT 1");
        $data=$sql->fetch_assoc();

        $district = $data['name'];

        $sub_county = database::prepData($_REQUEST['a2']);
        $sql= database::performQuery("SELECT `name` FROM subcounty WHERE id=$sub_county  LIMIT 1");
        $data=$sql->fetch_assoc();

        $sub_county = $data['name'];

        $parish = database::prepData($_REQUEST['a3']);
        $sql= database::performQuery("SELECT `name` FROM parish WHERE id=$parish  LIMIT 1");
        $data=$sql->fetch_assoc();

        $parish = $data['name'];

        $enterprise = database::prepData($_REQUEST['a7']);
        $date_of_event = database::prepData($_REQUEST['a8']);

        $type_of_event = database::prepData($_REQUEST['a9']);
        $description = database::prepData($_REQUEST['a10']);

        $reference_person = database::prepData($_REQUEST['a11']);
        $reference_contact = database::prepData($_REQUEST['a12']);

        $criticality = database::prepData($_REQUEST['a16']);

        $a18 = date("Y-m-d h:i:s");

        $sql = database::performQuery("INSERT INTO `mod_crisis`( `a1`, `a2`, `a3`, `a7`, 
        `a8`, `a9`, `a10`, `a11`, `a12`, `a16`)
        VALUES('$district','$sub_county','$parish','$enterprise',
        '$date_of_event','$type_of_event', '$description', '$reference_person', '$reference_contact', '$criticality')");

        $response['message'] =  "Data inserted successfully";
        http_response_code(200);
        echo json_encode($response);

    }

    public function askQuestion(){

        

        $content = [
            'content' => '
                    <div class="container py-4">

                        <div class="row mb-2">
                            <div class="col">

                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col">

                                                <p class="mb-4"><strong>Fill in the form below!</strong></p>
                                                <!-- form -->
                                                <div class="alert alert-danger" style="display:none", id="Validation-Div">
                                                    <ul id ="Validation">
                                            
                                                    </ul>
                                                </div>

                                                <div class="alert alert-success" style="display:none", id="Success-Div">
                                                    <ul id ="Success">
                                            
                                                    </ul>
                                                </div>
                                                    <form action="#" id="question-form" method="POST" enctype="multipart/form-data">

                                                    <div class="row"> 
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">First name</label>
                                                            <input type="text" class="form-control text-3 h-auto py-2" name="first_name" placeholder="Enter first name" required>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Last name</label>
                                                            <input type="text" class="form-control text-3 h-auto py-2" name="last_name" placeholder="Enter last name" required>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Gender</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="gender" required>
                                                              <option value="">--select gender --</option>  
                                                              <option value="male">Male</option>         
                                                              <option value="female">Female</option>                                                                       
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Language</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="language" id ="sel_language">
                                                            <option value="">--select language--</option>
                                                            '.user::getLanguages().' 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Contact</label>
                                                            <input type="text" class="form-control text-3 h-auto py-2" name="contact" placeholder="Enter contact" required>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">District</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="a1" id="sel_district">
                                                            <option value = "">--select district -- </option>  
                                                            '.district::getAllDistrictsList().'                    
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Subcounty</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="a2" id="sel_subcounty">
                                                            <option value = "">--select sub county -- </option>  
                                                              
                                                            </select>
                                                        </div>
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Parish</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="parish" id="sel_parish">
                                                            <option value = "">--select parish -- </option>  
                                                                          
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col">
                                                            <label class="form-label mb-1 text-2">Question</label>
                                                            <textarea maxlength="5000" data-msg-required="Enter Question here" rows="5" class="form-control text-3 h-auto py-2" name="body" required=""></textarea>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-12">
                                                            <label class="form-label mb-1 text-2">Enterprise</label>
                                                            <select class="select2 form-control form-select text-3 h-auto py-2" name="enterprise" id="sel_enterprise">
                                                            <option value="">--select enterprise--</option>     
                                                            '.user::getEnterprisesWithID().' 
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col-lg-6">
                                                            <label class="form-label mb-1 text-2">Choose file</label>
                                                            <input type="file" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01" name="media">
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="form-group col">
                                                            <input type="hidden" name="action" value="processQuestion">
                                                            <input type="submit" value="Submit Question" class="btn btn-primary btn-modern button-prevent-multiple-submits"  id="confirmButton" data-loading-text="Loading...">
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>',
            'styles' => null,
            'scripts' => '
                    <!-- <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> -->
                  <script src="'.ROOT.'/includes/theme/assets/libs/select2/dist/js/select2.full.min.js"></script>
                  <script src="'.ROOT.'/includes/theme/assets/libs/select2/dist/js/select2.min.js"></script>
                  <!--<script src="'.ROOT.'/includes/theme/dist/js/pages/forms/select2/select2.init.js"></script>  -->
                  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
                    
                    <script>
                    
                    $(document).ready(function(){

                        // $("#sel_district").select2({  
                        //     placeholder: "Select a district"
                        // });                        

                        // $("#sel_subcounty").select2({
                        //     placeholder: "Select a sub county"
                        // });


                        // $("#sel_parish").select2({
                        //     placeholder: "Select a parish"
                        // });


                        

                        // $("#sel_enterprise").select2({
                        //     placeholder: "Select a enterprise"
                        // });

                        // $("#sel_language").select2({
                        //     placeholder: "Select a language"
                        // });

                           
                            $("#sel_district").change(function(){
                                var id = $(this).val();   
                                $.ajax({
                                    url: \''.ROOT.'/?action=getSubCountiesByDistrict\',
                                    method: \'POST\',
                                    data: {"id":id},
                                    success:function(response){
                                        console.log(response);
                                        data = JSON.parse(response);
                                        
                                        $("#sel_subcounty").empty();
                                        $("#sel_parish").empty();
                                        $.each(data, function (key, entry) {
                                            console.log(entry);
                                            $("#sel_subcounty").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                        });
                                    },
                                    error:function(response){
                                        console.log(response);
                                    }
                                });
                            });
                           
                           

                            $("#sel_subcounty").change(function(){
                                var id = $(this).val();
                        
                                $.ajax({
                                    url: \''.ROOT.'/?action=getParishesBySubCounty\',
                                    method: \'POST\',
                                    data: {"id":id},
                                    success:function(response){
                                        data = JSON.parse(response);
                                        console.log(data);
                                        
                                        $("#sel_parish").empty();
                                        $.each(data, function (key, entry) {
                                            console.log(entry);
                                            $("#sel_parish").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");
                                        });
                                    }
                                });
                            });

                          

                            $("#question-form").validate({
                                rules:{
                                    first_name:{
                                        required: true,
                                        maxlength: 35,
                                        minlength: 3
                                    },
        
                                    last_name:{
                                        required: true,
                                        maxlength: 35,
                                        minlength: 3
                                    },
        
                                    gender:{
                                        required: true,
                                      
                                    },
                                    language:{
                                        required: true,
                                       
                                    },
        
                                    contact:{
                                        required: true,
                                      
                                    },

                                    a1:{
                                        required: true,
                                    },

                                    a2:{
                                        required: true
                                    },

                                    parish:{
                                        required: true
                                    },

                                    body:{
                                        required: true
                                    },

                                    enterprise:{
                                        required: true
                                    }
                                },
        
                                errorElement: \'span\',
                                errorPlacement: function (error, element) {
                                error.addClass(\'invalid-feedback\');
                                element.closest(\'.form-group\').append(error);
                                },
        
                                // Called when the element is invalid:
                                highlight: function (element, errorClass, validClass) {
                                    $(element).addClass(\'is-invalid\');
                                },
                    
                                // Called when the element is valid:
                                unhighlight: function (element, errorClass, validClass) {
                                    $(element).removeClass(\'is-invalid\');
                                },
        
                                submitHandler: function(form) {
        
                                    var formData = new FormData(form);
                      
                                    $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit
        
                                    $.ajax({
                                        url: \''.ROOT.'/?action=processQuestion\',
                                        type: \'post\',
                                        data: formData,
                                        processData: false,
                                        contentType: false,
                                        beforeSend:function(){
                                            $(\'#confirmButton\').text(\'Processing...\');
                                        },
        
                                        success: function(response) {
                                            $("#Success").empty();
                                            $(\'#confirmButton\').text(\'Add New\');
                                            console.log(response);
                         
                                            $("#Validation-Div").hide();
                                            
                            
                                            window.scrollTo(0,0) // Scroll to the top to display error message
                                            $("#Success-Div").show(); // Unhide the div
                          
                                            $("#Success").append(\'<li>\' + "Question has been submitted successfully." + \'</li>\');
                                            $("#question-form")[0].reset(); // Reset Form
                        
                                            $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);
                         
                                        }
                                    });
                                }
                                        
        
                            });

                            
                        });
                    
                    </script>'
        ];

        return $content;
    }


    public function processQuestion(){

        $first_name = database::prepData($_REQUEST['first_name']);
        $last_name = database::prepData($_REQUEST['last_name']);
        $contact = database::prepData($_REQUEST['contact']);
        $gender = database::prepData($_REQUEST['gender']);
        $language = database::prepData($_REQUEST['language']);
        $parish = database::prepData($_REQUEST['parish']);
        $body = database::prepData($_REQUEST['body']);
        $enterprise = database::prepData($_REQUEST['enterprise']);
        $parish_id = database::prepData($_REQUEST['parish']);
        //$media = database::prepData($_REQUEST['media']);
        $idstring = uniqid('MAAIF-', true);
        $name =  $first_name.' '. $last_name;

        $sql = database::performQuery("INSERT INTO `db_farmers`( `id_str`, `name`, `gender`, `contact`, 
        `main_language`, `parish_id`)
        VALUES('$idstring','$name','$gender','$contact','$language','$parish_id')");

        $inquiry = 'WEB PORTAL';

        $sender = 'WEB PORTAL';

        $farmer_id = database::getLastInsertID();

        $sql = database::performQuery("INSERT INTO `farmer_questions`( `farmer_id`, `parish_id`, `telephone`, `body`, 
        `enterprise_id`, `inquiry_source`, `sender`)
        VALUES('$farmer_id','$parish_id','$contact','$body','$enterprise','$inquiry', '$sender')");

        $response['message'] =  "Data inserted successfully";
        http_response_code(200);
        echo json_encode($response);



    }


    public function reportOutBreaksCrises(){

        $content = [
            'content' => '
                    <div class="container py-4">

                    <div class="row mb-2">
                        <div class="col">

                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col">

                                            <p class="mb-4"><strong>Fill in the form below!</strong></p>
                                            <div class="alert alert-danger" style="display:none", id="Validation-Div">
                                                    <ul id ="Validation">
                                            
                                                    </ul>
                                                </div>

                                                <div class="alert alert-success" style="display:none", id="Success-Div">
                                                    <ul id ="Success">
                                            
                                                    </ul>
                                                </div>
                                            <!-- form -->
                                                <form action="#" method="POST" id="outbreaks-form">

                                                <div class="row">
                                                        <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">District</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="a1" id="sel_district" required>
                                                        <option value = "">--select district -- </option>  
                                                        '.district::getAllDistrictsList().'                    
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Subcounty</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="a2" id="sel_subcounty">
                                                        <option value = "">--select sub county -- </option>  
                                                        
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                    <label class="form-label mb-1 text-2">Parish</label>
                                                    <select class="select2 form-control form-select text-3 h-auto py-2" name="a3" id="sel_parish">
                                                    <option value= "">--select parish -- </option>  
                                                                  
                                                    </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label mb-1 text-2">Enterprise Affected</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="a7" required id="sel_enterprise">
                                                        <option value="">--select enterprise--</option>     
                                                        '.user::getEnterprises().'                        
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Date of Event</label>
                                                        <input type="date" class="form-control form-control form-control-solid" name="a8" required>
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Type of Event</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="a9" id="sel_event">
                                                        <option value="">--select type of event --</option>    
                                                        <option value="Crisis">Crisis</option>           
                                                        <option value="Outbreak">Outbreak</option>                                           
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label class="form-label mb-1 text-2">Description</label>
                                                        <textarea maxlength="5000" data-msg-required="Enter Description of the event" rows="5" class="form-control text-3 h-auto py-2" name="a10" required=""></textarea>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Name of Reference Person</label>
                                                        <input type="text" class="form-control" name="a11"   placeholder="Name of reference person" >
                                                    </div>
                                                    <div class="form-group col-lg-6">
                                                        <label class="form-label mb-1 text-2">Contact of Reference Person</label>
                                                        <input type="text" class="form-control" name="a12"   placeholder="Contact" >
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-12">
                                                        <label class="form-label mb-1 text-2">How Critical Was the Event</label>
                                                        <select class="select2 form-control form-select text-3 h-auto py-2" name="a16" required id ="sel_level">
                                                        <option value="">--select level of event --</option>  
                                                        <option value="very low">Very Low</option>         
                                                        <option value="low">Low</option> 
                                                        <option value="medium">Medium</option>
                                                        <option value="critical">Critical</option>        
                                                        <option value="very critical">Very Critical</option>                                                                                                                     
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col">
                                                        <input type="hidden" name="action" value="saveCrisisOutbreaks">
                                                        <input type="submit" value="Submit Outbreak/Crisis" id="confirmButton" class="btn btn-primary btn-modern button-prevent-multiple-submits" data-loading-text="Loading...">
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>',
            'styles' => null,
            'scripts' => '
                    <!-- <script src="'.ROOT.'/includes/theme/assets/libs/jquery/dist/jquery.min.js"></script> -->
                    <!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
                    
                    <script>
                    
                    $(document).ready(function(){

                        // $("#sel_district").select2({ 
                        //     placeholder: "Select a district"
                        // });


                        // $("#sel_county").select2({
                        //     placeholder: "Select a county"
                        // });

                        // $("#sel_subcounty").select2({
                        //     placeholder: "Select a sub county"
                        // });


                        // $("#sel_parish").select2({
                        //     placeholder: "Select a parish"
                        // });


                        // $("#sel_village").select2({
                        //     placeholder: "Select a village"
                        // });

                        // $("#sel_enterprise").select2({
                        //     placeholder: "Select a enterprise"
                        // });

                        // $("#sel_level").select2({
                        //     placeholder: "Select a level of event"
                        // });

                        // $("#sel_event").select2({
                        //     placeholder: "Select type of event"
                        // });

                        $("#sel_district").change(function(){
                            var id = $(this).val();   
                            $.ajax({
                                url: \''.ROOT.'/?action=getSubCountiesByDistrict\',
                                method: \'POST\',
                                data: {"id":id},
                                success:function(response){
                                    console.log(response);
                                    data = JSON.parse(response);
                                    
                                    $("#sel_subcounty").empty();
                                    $("#sel_parish").empty();
                                    $.each(data, function (key, entry) {
                                        console.log(entry);
                                        $("#sel_subcounty").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");                               
                                    });
                                },
                                error:function(response){
                                    console.log(response);
                                }
                            });
                        });
                       
                       

                        $("#sel_subcounty").change(function(){
                            var id = $(this).val();
                    
                            $.ajax({
                                url: \''.ROOT.'/?action=getParishesBySubCounty\',
                                method: \'POST\',
                                data: {"id":id},
                                success:function(response){
                                    data = JSON.parse(response);
                                    console.log(data);
                                    
                                    $("#sel_parish").empty();
                                    $.each(data, function (key, entry) {
                                        console.log(entry);
                                        $("#sel_parish").append("<option value=\'"+entry.id+"\'>"+entry.name+"</option>");
                                    });
                                }
                            });
                        });

                      

                        $("#outbreaks-form").validate({
                            rules:{
                                a1:{
                                    required: true,
                                   
                                },
    
                                a2:{
                                    required: true,
                                    
                                },
    
                                gender:{
                                    required: true,
                                  
                                },
                                language:{
                                    required: true,
                                   
                                },
    
                                contact:{
                                    required: true,
                                  
                                },

                                a1:{
                                    required: true,
                                },

                                a2:{
                                    required: true
                                },

                                parish:{
                                    required: true
                                },

                                body:{
                                    required: true
                                },

                                enterprise:{
                                    required: true
                                }
                            },
    
                            errorElement: \'span\',
                            errorPlacement: function (error, element) {
                            error.addClass(\'invalid-feedback\');
                            element.closest(\'.form-group\').append(error);
                            },
    
                            // Called when the element is invalid:
                            highlight: function (element, errorClass, validClass) {
                                $(element).addClass(\'is-invalid\');
                            },
                
                            // Called when the element is valid:
                            unhighlight: function (element, errorClass, validClass) {
                                $(element).removeClass(\'is-invalid\');
                            },
    
                            submitHandler: function(form) {
    
                                var formData = new FormData(form);
                  
                                $(\'.button-prevent-multiple-submits\').attr(\'disabled\', true); // Disable button on clicking submit
    
                                $.ajax({
                                    url: \''.ROOT.'/?action=saveCrisisOutbreaks\',
                                    type: \'post\',
                                    data: formData,
                                    processData: false,
                                    contentType: false,
                                    beforeSend:function(){
                                        $(\'#confirmButton\').text(\'Processing...\');
                                    },
    
                                    success: function(response) {
                                        $("#Success").empty();
                                        $(\'#confirmButton\').text(\'Add New\');
                                        console.log(response);
                     
                                        $("#Validation-Div").hide();
                                        
                        
                                        window.scrollTo(0,0) // Scroll to the top to display error message
                                        $("#Success-Div").show(); // Unhide the div
                      
                                        $("#Success").append(\'<li>\' + "Outbreak has been submitted successfully." + \'</li>\');
                                        $("#outbreaks-form")[0].reset(); // Reset Form
                    
                                        $(\'.button-prevent-multiple-submits\').attr(\'disabled\', false);
                     
                                    }
                                });
                            }
                                    
    
                        });

                            
                        });
                    
                    </script>',
        ];

        return $content;
    }


    public static function manageOutbreaksCrises()
    {



        $content = '<div class="row">
                    
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="zero_config" class="table table-striped table-bordered">
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Entreprize</th>
                                                    <th>Location/<br />Subcounty/Parish</th>
                                                    <th>Status</th>
                                                    <th>Ref/<br />Phone</th>
                                                     <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            '.self::getUserManageList().'                                           
                                           
                                        </tbody>
                                        <tfoot>
                                             <tr>
                                              <th>ID</th>
                                                    <th>Type</th>
                                                    <th>Date</th>
                                                    <th>Entreprize</th>
                                                    <th>Location/<br />Subcounty/Parish</th>
                                                    <th>Status</th>
                                                    <th>Ref/<br />Phone</th>
                                                     <th>Actions</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                ';
        return $content;
    }



    public static function getUserManageList(){



        $sql = database::performQuery("SELECT * FROM `mod_crisis` ORDER BY id desc");

        $rt =  '';
        while($data=$sql->fetch_assoc()){

            $user =  $data['a19'];
            $user_details = user::getUserDetails($user);
            if($user_details['user_category_id'] == 50)
                $addd_btn1 = '   <a href="'.ROOT.'/?action=approveOutbreak&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-success"><i class="fas fa-marker"></i> Approve</button></a> ';
            else
                $addd_btn1 = '';



            $addd_btn2 = '   <a href="'.ROOT.'/?action=respondOutbreak&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-primary"><i class="fas fa-reply"></i> Respond</button></a> ';
            $addd_btn3 = '   <a href="'.ROOT.'/?action=viewOutbreak&id='.$data['id'].'">  <button type="button" class="btn waves-effect waves-light btn-rounded btn-sm btn-warning"><i class="fas fa-eye"></i> View</button></a> ';




            $rt .='<tr>
                                        <td>'.$data['id'].'</td>
                                        <td>'.$data['a9'].'</td>
                                        <td>'.makeMySQLDateFromString($data['a8']).'</td>
                                        <td>'.$data['a7'].'</td>
                                        <td>'.$data['a1'].'<br /> <small>'.$data['a2'].'/'.$data['a3'].'</small></td>
                                        <td>'.$data['a16'].'</td>
                                        <td>'.$data['a11'].'<br /> <small>'.$data['a12'].'</small></td>
                                       <td> '.$addd_btn1.' '.$addd_btn2.' '.$addd_btn3.' </td>
                                        
                                    </tr>';
        }

        return $rt;
    }


}