<?php
    use Atk4\Dsql\Query;
    require_once $_SERVER['DOCUMENT_ROOT'] . '/dashboard-framework-v1/Config.php';

    #create connection
    class Base {
        public PDO $PDO_conn;
        public Atk4\Dsql\Connection $DSQL_conn;

        public function __construct(bool $get_PDO_connection = false, bool $get_DSQL_connection = false)
        {   
            $config = new Config();
            
            $dsn = "mysql:host=" . $config->server_name . ";port=" . $config->port . ";dbname=" . $config->db_name;

            if ($get_PDO_connection) {
                $this->PDO_conn = new PDO($dsn, $config->username, $config->password);
                // echo "created PDO connection";
            }

            if ($get_DSQL_connection) {
                $this->DSQL_conn = Atk4\Dsql\Connection::connect($dsn, $config->username);
                // echo "created DSQL connection";
            }
        }

        public function getData(Query $query, string $fetch_mode, string $class_name) {
            $stmt = $this->PDO_conn->prepare($query->render(), [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);

            if ($fetch_mode == 'class') {
                $mode = PDO::FETCH_CLASS;
            }

            $stmt->setFetchMode($mode, $class_name);
            $stmt->execute($query->params);

            //check if there is matched record
            if ($stmt->rowCount() > 0) {
                $data = $stmt->fetchAll();
                // $stmt = null;
                // $this->PDO_conn = null;
                return $data;
            } else {
                // $stmt = null;
                // $this->PDO_conn = null;
                return false;
            }

        }

        public function insertData(array $data, string $table_name) {
            $fields = implode(', ', array_keys($data));
            $placeholders = implode(', ', array_fill(0, count($data), '?'));

            $query = "INSERT INTO $table_name ($fields) VALUES ($placeholders)";
            $stmt = $this->PDO_conn->prepare($query);

            $values = array_values($data);
            $stmt->execute($values);

            return $this->PDO_conn->lastInsertId();
        }


        public function filterDataAndPage(string $table_name, array $fields, array $conditions = [], int $page = 1, int $perPage = 10)
        {
            $limit = $perPage;
            $offset = ($page - 1) * $perPage;

            $query = "SELECT " . implode(', ', $fields) . " FROM $table_name";

            $params = [];
            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $field => $value) {
                    if (is_array($value) && count($value) === 2) {
                        $where[] = "$field BETWEEN ? AND ?";
                        $params[] = $value[0];
                        $params[] = $value[1];
                    } else {
                        $where[] = "$field = ?";
                        $params[] = $value;
                    }
                }
                $query .= " WHERE " . implode(' AND ', $where);
            }

            $query .= " LIMIT $limit OFFSET $offset";

            $stmt = $this->PDO_conn->prepare($query);
            $stmt->execute($params);

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, stdClass::class);

            $totalQuery = "SELECT COUNT(*) as total FROM $table_name";
            if (!empty($conditions)) {
                $totalQuery .= " WHERE " . implode(' AND ', $where);
            }

            $totalStmt = $this->PDO_conn->prepare($totalQuery);
            $totalStmt->execute($params);
            $totalResult = $totalStmt->fetch(PDO::FETCH_ASSOC);
            $totalRecords = $totalResult['total'];

            return [
                'data' => $data,
                'totalRecords' => $totalRecords,
            ];
        }


        public function filterData(string $table_name, array $fields, array $conditions = [], int $limit = 0) 
        {
            $query = "SELECT " . implode(', ', $fields) . " FROM $table_name";

            $params = [];
            if (!empty($conditions)) {
                $where = [];
                foreach ($conditions as $field => $value) {
                    if (is_array($value) && count($value) === 2) {
                        $where[] = "$field BETWEEN ? AND ?";
                        $params[] = $value[0];
                        $params[] = $value[1];
                    } else {
                        $where[] = "$field = ?";
                        $params[] = $value;
                    }
                }
                $query .= " WHERE " . implode(' AND ', $where);
            }

            if ($limit > 0) {
                $query .= " LIMIT $limit";
            }

            $stmt = $this->PDO_conn->prepare($query);
            $stmt->execute($params);

            $data = $stmt->fetchAll(PDO::FETCH_CLASS, stdClass::class);
            return $data;
        }

        public function updateData(string $table_name, array $data, array $conditions)
        {

            $set_clause = [];
            $params = [];

            foreach ($data as $field => $value) {
                $set_clause[] = "$field = ?";
                $params[] = $value;
            }


            $where_clause = [];
            
            foreach ($conditions as $field => $value) {
                if (is_array($value) && count($value) === 2) {
                    $where_clause[] = "$field BETWEEN ? AND ?";
                    $params[] = $value[0];
                    $params[] = $value[1];
                } else {
                    $where_clause[] = "$field = ?";
                    $params[] = $value;
                }
            }


            $query = "UPDATE $table_name SET " . implode(', ', $set_clause);

            if (!empty($where_clause)) {
                $query .= " WHERE " . implode(' AND ', $where_clause);
            }


            $stmt = $this->PDO_conn->prepare($query);
            $stmt->execute($params);


            return $stmt->rowCount();
        }

        
        public function deleteData(string $table_name,  array $conditions)
        {
            $params = [];

            $where_clause = [];
            
            foreach ($conditions as $field => $value) {
                if (is_array($value) && count($value) === 2) {
                    $where_clause[] = "$field BETWEEN ? AND ?";
                    $params[] = $value[0];
                    $params[] = $value[1];
                } else {
                    $where_clause[] = "$field = ?";
                    $params[] = $value;
                }
            }


            $query = "DELETE FROM $table_name";

            if (!empty($where_clause)) {
                $query .= " WHERE " . implode(' AND ', $where_clause);
            }

            $stmt = $this->PDO_conn->prepare($query);
            $stmt->execute($params);

            return $stmt->rowCount();
        }
        
    }
    
?>