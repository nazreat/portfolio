<?php
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/model/Event.php';
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/src/class/Path.php';
    session_start();
    $path = new Path();
    $fields = ['id','name', 'location', 'supervisor', 'status', 'participants', 'event_date'];
    $conditions = [];
    if(isset($_POST["name"]) && $_POST["name"]!=""){
        $conditions['name'] = $_POST["name"];
    }
    if (isset($_POST["location"]) && $_POST["location"]!="") {
        $conditions['location'] = $_POST["location"];
    }

    if (isset($_POST["supervisor"]) && $_POST["supervisor"]!="") {
        $conditions['supervisor'] = $_POST["supervisor"];
    }
    if (isset($_POST["status"]) && $_POST["status"]!="") {
        $conditions['status'] = $_POST["status"];
    } 
    if(isset($_POST["name"]) && $_POST["name"] != ""){
      $conditions['name'] = $_POST["name"];
    }

    if (isset($_POST["date_after"]) || isset($_POST["date_before"])) {
      if($_POST["date_before"]!="" && $_POST["date_before"] !=""){
        $conditions['event_date'] = [$_POST["date_after"], $_POST["date_before"]];
      }
    } 

    
    $page = isset($_GET['page']) ? intval($_GET['page']) : 1;
    $perPage = isset($_SESSION['per_page']) ? intval($_SESSION['per_page']) : 5;
    if (isset($_POST['per_page'])) {
        $perPage = intval($_POST['per_page']);
        $_SESSION['per_page'] = $perPage;
    }

    $filter_event = new Event(true);
    $events = $filter_event->filter_event($fields, $conditions, $page, $perPage);

    $totalRecords = $events['totalRecords'];
    $events = $events['data'];

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
    
    $firstDayOfMonth = date("Y-m-01");
    $lastDayOfMonth = date("Y-m-t");
    $conditions['event_date'] = [$firstDayOfMonth, $lastDayOfMonth];
    $activities = $filter_event->filter_event($fields, $conditions, 1, 99);
    $total = $activities['totalRecords'];
?>