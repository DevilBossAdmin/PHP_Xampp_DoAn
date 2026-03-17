<?php  
	class DP {
		// Phương thức kết nối
		private static function connect_DB() {
			$host = 'localhost';
			$dbname = 'laravel';
			$us = 'root';
			$pass = '';
			try {
				$conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $us, $pass, 
				array(
					PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
					PDO::ATTR_PERSISTENT => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
					)
				);
				return $conn;
			}
			catch (PDOException $e) {
				error_log('DB connect error: ' . $e->getMessage());
				return null;
			}
		}
		// Phương thức xác định kiểu dữ liệu truyền vào của tham số câu truy vấn
		private static function get_type($var) {
			switch (gettype($var)) {
				case 'integer': return PDO::PARAM_INT;
				case 'boolean': return PDO::PARAM_BOOL;
				case 'NULL': return PDO::PARAM_NULL;
				default: return PDO::PARAM_STR;
			}
		}
		// Phương thức thực thi truy vấn
		public static function run_query($query,$paras,$type) {
			try {
				$con = DP::connect_DB();
				if(!$con){
					return ($type === 2) ? array() : false;
				}
				$h = $con->prepare($query);
				foreach ($paras as $key=>$para) {
					$h->bindValue($key+1,$para,DP::get_type($para));
				}
				$h->execute();
				switch($type)
				{
					case 1:
						$result = true;
						break;
					case 2:
						$result = $h->fetchAll(PDO::FETCH_ASSOC);
						break;
					case 3:
						$result = $con->lastInsertId();
						break;
					default:
						$result = false;
				}
				$con = NULL;
				return $result;
			} catch (PDOException $e) {
				error_log('DB query error: ' . $e->getMessage() . ' | SQL: ' . $query);
				return ($type === 2) ? array() : false;
			}
		}
	}
?>
