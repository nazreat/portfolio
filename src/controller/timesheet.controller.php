<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Timesheet.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    $path = new Path();
    $fields = ['id','activities', 'activities_type', 'supervisor', 'status', 'date','start_time', 'end_time', 'volunteer_id'];
    $conditions = [];

    if(isset($_POST["activiy_name"]) && $_POST["activiy_name"]!=""){
      $conditions['activities'] = $_POST["activiy_name"];
  }
  if (isset($_POST["activity_type"]) && $_POST["activity_type"]!="" ) {
      $conditions['activities_type'] = $_POST["activity_type"];
  }
  if (isset($_POST["date_after"]) || isset($_POST["date_before"])) {
      if($_POST["date_after"]!= "" && $_POST["date_before"] !=""){
        $conditions['date'] = [$_POST["date_after"], $_POST["date_before"]];
      }
  }
  if (isset($_POST["supervisor"]) && $_POST["supervisor"]!="") {
      $conditions['supervisor'] = $_POST["supervisor"];
  }
  if (isset($_POST["status"]) &&  $_POST["status"]!="") {
      $conditions['status'] = $_POST["status"];
  }


    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_SESSION['timesheet_per_page']) ? intval($_SESSION['timesheet_per_page']) : 5;
    if (isset($_POST['per_page'])) {
        $perPage = intval($_POST['per_page']);
        $_SESSION['timesheet_per_page'] = $perPage;
    }

    $filter_timesheet = new Timesheet(true);
    $timesheets = $filter_timesheet->filter_timesheet($fields, $conditions, $page, $perPage);

    $totalRecords = $timesheets['totalRecords'];
    $timesheets = $timesheets['data'];

    $totalPages = ceil($totalRecords / $perPage);
    $fromRecord = $totalRecords=='0' ? '0' : ($page - 1) * $perPage + 1;
    $toRecord = min($page * $perPage, $totalRecords);

    $prevPage = ($page > 1) ? $page - 1 : 1;
    $nextPage = ($page < $totalPages) ? $page + 1 : $totalPages;

    function generatePaginationLinks($currentPage, $totalPages) {
        $links = '';

        $links .= "<li class='page-item prev'>
                      <a class='page-link' href='?page=1'
                        ><i class='tf-icon bx bx-chevrons-left'></i
                      ></a>
                    </li>";

        if ($currentPage > 1) {
            $prevPage = $currentPage - 1;
            $links .= "<li class='page-item prev'>
                      <a class='page-link' href='?page=$prevPage'
                        ><i class='tf-icon bx bx-chevron-left'></i
                      ></a>
                    </li>";
        } else {
            $links .= "<li class='page-item prev'>
                      <a disabled class='page-link' href='javascript:void(0);'
                        ><i class='tf-icon bx bx-chevron-left'></i
                      ></a>
                    </li>";
        }

        for ($i = 1; $i <= $totalPages; $i++) {
            if ($i == $currentPage) {
                $links .= "<li class='page-item active'>
                      <a class='page-link' href='javascript:void(0);'>$i</a>
                    </li>";
            } else {
                $links .= "<li class='page-item'>
                      <a class='page-link' href='?page=$i'>$i</a>
                    </li>";
            }
        }

        if ($currentPage < $totalPages) {
            $nextPage = $currentPage + 1;
            $links .= "<li class='page-item next'>
                      <a class='page-link' href='?page=$nextPage'
                        ><i class='tf-icon bx bx-chevron-right'></i
                      ></a>
                    </li>";
        } else {
            $links .= "<li class='page-item next'>
                      <a disabled class='page-link' href='javascript:void(0);'
                        ><i class='tf-icon bx bx-chevron-right'></i
                      ></a>
                    </li>";
        }

        $links .= "<li class='page-item next'>
                      <a class='page-link' href='?page=$totalPages'
                        ><i class='tf-icon bx bx-chevrons-right'></i
                      ></a>
                    </li>";

        return $links;
    }
    


?>