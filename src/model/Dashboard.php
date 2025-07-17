<?php

/*
This file is created by ZeHua Yan

Purpose of this 
*/

    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Base.php';
    
    include_once($_SERVER['DOCUMENT_ROOT'] . "/dashboard-framework-v1/db_conn.php");

    class Dashboard
    {
        public int $id;
        public string $name;
        public int $status_id;
        public string $uuid;
        public DateTime $created_at;
        
        public function getUserInfoFromID($id){
            global $mysqli;
            $query = "SELECT * FROM `user` WHERE `id` = " . $id;
            $result = mysqli_query($mysqli, $query);
            $e = mysqli_fetch_assoc($result);
            return $e;
        }

        public function getOrgInfoFromID($id){
          global $mysqli;
          $query = "SELECT * FROM `organisation` WHERE `id` = " . $id;
          $result = mysqli_query($mysqli, $query);
          $e = mysqli_fetch_assoc($result);
          return $e;
      }

      public function getMonthlySupervisedEvents($id){
        global $mysqli;
        $month = date('m');
        $year = date('Y');

        $query = "SELECT * FROM `event` AS e where `supervisor` = ". $id . " AND YEAR(e.event_date) = ". $year ." AND MONTH(e.event_date) =". $month;
        $results = mysqli_query($mysqli, $query);
        return $results;
      }

      public function getMonthlyJoinedEvents($id){
          global $mysqli;

          $month = date('m');
          $year = date('Y');
          $query = "SELECT * FROM `event_has_participant` AS ep RIGHT JOIN `event` AS e ON e.id = ep.event_id WHERE ep.user_id =". $id . " AND YEAR(e.event_date) = ". $year ." AND MONTH(e.event_date) =".$month ;
          $results = mysqli_query($mysqli, $query);
          return $results;
      }

      public function getMonthlyHandledRequests($id){
        global $mysqli;
        
        $month = date('m');
        $year = date('Y');

        $query_all = "SELECT * FROM `timesheet` WHERE `supervisor` =". $id . " AND YEAR(`date`) = ". $year ." AND MONTH(`date`) =".$month ;
        $results_all = mysqli_query($mysqli, $query_all);

        $query_handled = "SELECT * FROM `timesheet` WHERE `supervisor` =". $id ." AND `status` BETWEEN 8 AND 9 AND YEAR(`date`) = ". $year ." AND MONTH(`date`) =".$month ;
        $results_handled = mysqli_query($mysqli, $query_handled);

        if($results_handled->num_rows == 0){
          return 0;
        }else{
          $rate = round(($results_handled->num_rows / $results_all->num_rows),2) * 100;

          return $rate;
        }


    }

      public function getMonthlyApprovedRequests($id){
        global $mysqli;
        
        $month = date('m');
        $year = date('Y');

        $query_all = "SELECT * FROM `timesheet` WHERE `volunteer_id` =". $id . " AND YEAR(`date`) = ". $year ." AND MONTH(`date`) =".$month ;
        $results_all = mysqli_query($mysqli, $query_all);

        $query_approved = "SELECT * FROM `timesheet` WHERE `volunteer_id` =". $id ." AND `status`=8 AND YEAR(`date`) = ". $year ." AND MONTH(`date`) =".$month ;
        $results_approved = mysqli_query($mysqli, $query_approved);

        if($results_approved->num_rows == 0){
          return 0;
        }else{
          $rate = round(($results_approved->num_rows / $results_all->num_rows),2) * 100;

          return $rate;
        }
    }


        public function getEvents($num = 3, $eventId = -1){
            global $mysqli;
            $string = "";
            
            // if it appears in the dashboard page
            if ($num == 3) {
                # SELECT curdate() > '2023-08-21';
                $query = "SELECT * FROM `event` WHERE status = 6 AND `event_date` > CURRENT_DATE() ORDER BY `event_date` ASC LIMIT 0, " . $num;
                $result = mysqli_query($mysqli, $query);
                while($e = mysqli_fetch_assoc($result)){
                    #print_r($e);
                    $supervisor_info = $this->getUserInfoFromID($e["supervisor"]);
                    $string .= '
                            <div class="row" style="padding: 5px;" >
                              <a href="view-event.view.php?eventId='. $e["id"] .'">
                                <div class="card">
                                  <div class="d-flex align-items-end row">
                                    <div class="col-sm-3">
                                      <div class="card-body" style="text-align: center;">
                                        <span style="clear: both; display: inline-block; overflow: hidden; white-space: nowrap;">
                                          <h1 style="color: #1775F1;">
                                            '. $this->getDay($e["event_date"]) .'<br>
                                            '. $this->getMonth($e["event_date"]) .'
                                          </h1>
                                          <h6 >
                                            '. $this->getAmPm($e["start_time"]) .'
                                          </h6>
                                        </span>
                                      </div>  
                                    </div>
                                    <div class="col-sm-9 text-sm-left">
                                      <div class="card-body">
                                        <h5 class="card-title">'. $e["name"] .'</h5>
                                        <p class="mb-4" style="color: black;">
                                          '. $e["description"] .' 
                                          <br>
                                          <small class="text-muted"> Supervisor: '. $supervisor_info["first_name"] .'</small>
                                        </p>
                                        
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                    ';
                }
                return $string;
            }
            
            if ($eventId != -1) {
                $query = "SELECT * FROM `event` WHERE `id` = " . $eventId;
                $result = mysqli_query($mysqli, $query);
                $e = mysqli_fetch_assoc($result);
                return $e;
            }
        }
        
        private function getMonth($date){
            $MONTHS = ["JAN", "FEB" , "MAR", "ARP", "MAY", "JUN", "JUL", "AUG", "SEP", "OCT", "NOV", "DEC"];
            $temp = explode("-", $date);
             return $MONTHS[$temp[1] - 1];
        }
        
        private function getDay($date){
            return substr($date, -2);
        }
        
        private function getAmPm($time){
            $temp = explode(":", $time);
            $string = "";
            if ($temp[0] == 12) {
                $string .= $temp[0] . ":" . $temp[1] . " PM";
            } elseif ($temp[0] > 12) {
                $string .= ($temp[0] - 12) . ":" . $temp[1] . " PM";
            } else {
                $string .= $temp[0] . ":" . $temp[1] . " AM";
            }
            return $string;
        }
        
        public function getTimesheets($num = 3){
          global $mysqli;
          $string = "";
          if ($num == 3){
              $query = "SELECT * FROM `timesheet` WHERE `status` = 11 LIMIT 0," . $num;
              $result = mysqli_query($mysqli, $query);
              while($e = mysqli_fetch_assoc($result)){
                $supervisor_info = $this->getUserInfoFromID($e["supervisor"]);
                $img_src ="";
                if($supervisor_info['photo_path'] == null)
                {
                  $img_src = "../assets/img/avatars/1.png";
                }else
                  $img_src = $supervisor_info['photo_path'];
        
                  $string .= '
                      <div class="row" style="padding: 5px;" >
                        <a href="requests.view.php?timesheetId='. $e["id"] .'">
                          <div class="card">
                            <div class="d-flex align-items-end row">
                              <div class="col-sm-4" style="text-align: center;padding-top: 6.5px;">
                                <img
                                  src="'. $img_src .'"
                                  height="136"
                                  alt="View Badge User"
                                  data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                  data-app-light-img="illustrations/man-with-laptop-light.png"
                                  style="border-radius: 50%;"
                                /> 
                                <p style="color: black; padding-top: 5px; text-align: center;">
                                  Supervisor: '. $supervisor_info["first_name"].'
                                </p>
                              </div>
                              <div class="col-sm-8 text-sm-left">
                                <div class="card-body" style="padding-bottom: 8%;">
                                  <h5 class="card-title">'. $this->getTimeGap($e["start_time"], $e["end_time"]) .'</h5>
                                  <p class="mb-4" style="color: black;">
                                    Type: '. $e["activities_type"] .' 
                                    <br>
                                    <small class="text-muted">'. $this->getDay($e["date"]) .' '.$this->getMonth($e["date"]) .'</small>
                                    <br>
                                  </p>
                                  
                                </div>
                              </div>
                            </div>
                          </div>
                        </a>
                      </div>
                  ';
              }
              return $string;
          }
        }

        public function getRequests($num = 3){
            global $mysqli;
            $string = "";
            if ($num == 3){
                $query = "SELECT * FROM `timesheet` WHERE `status` = 11 LIMIT 0," . $num;
                $result = mysqli_query($mysqli, $query);
                while($e = mysqli_fetch_assoc($result)){
                  $volunteer_info = $this->getUserInfoFromID($e["volunteer_id"]);
                  $img_src ="";
                  if($volunteer_info['photo_path'] == null)
                  {
                    $img_src = "../assets/img/avatars/1.png";
                  }else
                    $img_src = $volunteer_info['photo_path'];
          
                    $string .= '
                        <div class="row" style="padding: 5px;" >
                          <a href="requests.view.php?timesheetId='. $e["id"] .'">
                            <div class="card">
                              <div class="d-flex align-items-end row">
                                <div class="col-sm-4" style="text-align: center;padding-top: 6.5px;">
                                  <img
                                    src="'. $img_src .'"
                                    height="136"
                                    alt="View Badge User"
                                    data-app-dark-img="illustrations/man-with-laptop-dark.png"
                                    data-app-light-img="illustrations/man-with-laptop-light.png"
                                    style="border-radius: 50%;"
                                  /> 
                                  <p style="color: black; padding-top: 5px; text-align: center;">
                                    Volunteer: '. $volunteer_info["first_name"].'
                                  </p>
                                </div>
                                <div class="col-sm-8 text-sm-left">
                                  <div class="card-body" style="padding-bottom: 8%;">
                                    <h5 class="card-title">'. $this->getTimeGap($e["start_time"], $e["end_time"]) .'</h5>
                                    <p class="mb-4" style="color: black;">
                                      Type: '. $e["activities_type"] .' 
                                      <br>
                                      <small class="text-muted">'. $this->getDay($e["date"]) .' '.$this->getMonth($e["date"]) .'</small>
                                      <br>
                                    </p>
                                    
                                  </div>
                                </div>
                              </div>
                            </div>
                          </a>
                        </div>
                    ';
                }
                return $string;
            }
            
        }
        
        private function getTimeGap($timeBegin, $timeEnd){
            $B = explode(":", $timeBegin);
            $E = explode(":", $timeEnd);
            $strting = "";
            if ( $E[0] - $B[0] < 0 ) {
                $string = ($E[1] - $B[1]) . " minute";
                return $string;
            }
            
            if ( $E[0] - $B[0] > 0 ) {
                if ($E[1] - $B[1] == 0) {
                    $string = ($E[0] - $B[0]) . " hour";
                    return $string;
                } else {
                    $string = ($E[0] - $B[0]) . " hour " . ($E[1] - $B[1]) . " minute";
                    return $string;
                }
            } 
        }
        
        public function getMonthlyEventAttendance(){
            global $mysqli;
            $year = date("Y");
            $monthly = [0,0,0,0,0,0,0,0,0,0,0,0];
            $string = "";
   
            for ($i  = 1; $i <= 12; $i++) {
                $attendance = 0;
                //$query = "SELECT `participants`, `attendance` FROM `event` WHERE `event_date` LIKE '". $year ."%' AND `event_date` LIKE '%". $i ."-'";
                //$query = "SELECT `participants`, `attendance` FROM `d_attandance` WHERE `year` = '". $year ."%' AND `month` = '". $i ."'";
                $query = "SELECT `date` FROM `timesheet` WHERE MONTH(`date`) = " . $i ;
          
                #print_r($query);
                $result = mysqli_query($mysqli, $query);
                while($e = mysqli_fetch_assoc($result)){
                    $attendance += 1;
                }
                $monthly[$i - 1] = $attendance;
            }
                
           

            $string = '
var attendance_report_options = {
    series: [{
      name: "Attendance",
      data: ['.$monthly[0].', '.$monthly[1].', '.$monthly[2].', '.$monthly[3].', '.$monthly[4].', '.$monthly[5].', '.$monthly[6].', '.$monthly[7].', '.$monthly[8].', '.$monthly[9].', '.$monthly[10].', '.$monthly[11].']
    }],
    chart: {
    height: 350,
    type: "area",
    zoom: {
      enabled: false
    }
    },
    dataLabels: {
    enabled: false
    },
    stroke: {
    curve: "straight"
    },
    title: {
    text: "Monthly Activity attendance ('.$year.')",
    align: "centre"
    },
    grid: {
    row: {
      colors: ["#f3f3f3", "transparent"], // takes an array which will be repeated on columns
      opacity: 0.5
    },
    },
    xaxis: {
    categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
    title: {
      text: "Month"
    }
    },
    yaxis: {
    axisBorder: {
      show: false
    },
    axisTicks: {
      show: false,
    },
    labels: {
      show: true,
      formatter: function (val) {
      return val ;
      }
    },
    title: {
      text: "Attendance percentage"
    }
    
    }
};

var attendance_report = new ApexCharts(document.querySelector("#attendance_report"), attendance_report_options);
attendance_report.render();
            ';


            return $string;
            #print_r($monthly);
        }
        
        public function getMonthlyNewVolunteers(){
            global $mysqli;
            $year = (date("Y") - 1);
            $male = [0,0,0,0,0,0,0,0,0,0,0];
            $female = [0,0,0,0,0,0,0,0,0,0,0];
            $string = "";
            for ($i  = 1; $i <= 12; $i++) {
                $query = "SELECT `gender`, `count` FROM `monthly_new_volunteers` WHERE `year` LIKE '". $year ."%' AND `month` = ". $i;
                $result = mysqli_query($mysqli, $query);
                $e = mysqli_fetch_assoc($result);
                if ($e["gender"] == "MALE") {
                    $male[$i - 1] = $e["count"];
                }
                if ($e["gender"] == "FEMALE") {
                    $female[$i - 1] = $e["count"];
                }
            }
            return $string; # where to render the char?????
        }
        
        public function getVolunteerOfTheYear(){
            global $mysqli;
            $year = date("Y");
        }
        
        public function getTypeOfActivity(){
            global $mysqli;
            $year = date("Y");
            $type = ["PROJECT", "EVENT", "OTHER"];
            $count = array();
            $total = 0;
            $string = "";
            for ($i = 0; $i < count($type); $i++) { array_push($count, 0); }
            for ($i = 0; $i < count($type); $i++) {
                $query = "SELECT COUNT(`id`) FROM `timesheet` WHERE YEAR(`date`) = ". $year ." AND `activities_type` = '" . $type[$i] . "'";
                $result = mysqli_query($mysqli, $query);
                $e = mysqli_fetch_assoc($result);
                #print_r($e["COUNT(`id`)"]);
                $count[$i] = $e["COUNT(`id`)"];
                $total += $e["COUNT(`id`)"];
            }
            for ($i = 0; $i < count($type); $i++) { $count[$i] = $count[$i] / $total * 100; }
            $string = '
var activity_type_report_options = {
	series: ['.$count[0].', '.$count[1].', '.$count[2].'],
	colors: ["#8bbaf8", "#1775F1", "#0b3a78"],
	chart: {
	height: 380,
	type: "pie",
  },
  title: {
	text: "Type of activity ('. $year .')",
	align: "centre"
  },
  labels: ["Project", "Event", "Other"],
  responsive: [{
	breakpoint: 480,
	options: {
	  chart: {
		width: "auto"
	  },
	  legend: {
		position: "bottom"
	  }
	}
  }]
  };

var activity_type_report = new ApexCharts(document.querySelector("#activity_type_report"), activity_type_report_options);
activity_type_report.render();
            ';
            return $string; # where to render the char?????
        }
        
        public function getMonthlyVolunteerEngagement(){
            global $mysqli;
            $year = (date("Y") - 1);
            
        }
        
        public function getVolunteerAge(){
            global $mysqli;
            $year = (date("Y") - 1);
            $ageGroup = [9,14,19,24,29,34,39,44,49,54,59,64,69,74,75];
        }
    }

?>