<?php
	session_start();
	$conn = mysqli_connect("localhost", "root", "", "db_cbt");
	date_default_timezone_set("Asia/Jakarta");
	class Controller
	{
		private $conn;
		public function __construct()
		{
			global $conn;
			$this->conn = $conn;
		}
		public function login($username, $password){

	        $username = htmlspecialchars($username);
	        $password = htmlspecialchars($password);

	        $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE username = '$username'");

	        // cek username
	        if(mysqli_num_rows($result) === 1){
	            // cek password
	            $row = mysqli_fetch_assoc($result);
	            if(password_verify($password, $row['password'])){
	                $_SESSION['level'] = $row['level'];
	               	$_SESSION['id_anggota'] = $row['id_anggota'];

	                if(isset($_POST['remember'])){
	                    setcookie('key1', $row['id_anggota'] , time() + 86400 * 7);
	                    setcookie('key2', hash('sha256', $row['id_anggota']), time() + 86400 * 7);
	                }
	                return true;
	            }
	            else {
	           		return false;
	           	}
			}
			else {
				return false;
			}
		}

		public function register($field, $sebagai, $foto=null)
		{
			array_walk($field, array($this, 'arrayTrim'));
			if ($sebagai == "Guru") {
				$username = htmlspecialchars($field['username']);
				$cekuser = $this->countTable("tb_user WHERE username='$username'");
				if ( $cekuser > 0 ) {
					$output['status'] = "already";
					$output['already'] = "Username";
				}
				else {
					$nip = htmlspecialchars($field['nip']);
					$ceknip = $this->countTable("tb_guru WHERE nip='$nip'");
					if ($ceknip > 0) {
						$output['status'] = "already";
						$output['already'] = "NIP";
					}
					else {
						if (!is_null($foto)) {
							$gambar = $this->uploadGambar($foto);
						}
						else {
							$gambar = "noprofile.png";
						}
						if ($gambar == "invalid" || $gambar == "toolarge") {
							$output['status'] = $gambar;
						}
						else {
							$nama = htmlspecialchars($field['nama']);
							$tempat_lahir = htmlspecialchars($field['tempat_lahir']);
							$tanggal_lahir = $field['tanggal_lahir'];
							$jk = $field['jk'];
							$alamat = htmlspecialchars($field['alamat']);
							$no_telp = htmlspecialchars($field['no_telp']);
							$email = htmlspecialchars($field['email']);
							$id_guru = $this->autokode("tb_guru","id_guru","GR",5);
							$sql = "'$id_guru','$nip','$nama','$jk','$tempat_lahir','$tanggal_lahir','$alamat','$no_telp','$email','$gambar'";
							$input = $this->insertData("tb_guru",$sql);
							if ($input) {
								$password = htmlspecialchars($field['password']);
								$password = password_hash($password, PASSWORD_DEFAULT);
								$register = $this->insertData("tb_user","'$username','$password','$id_guru','Guru'");
								if ($register) {
									$output['status'] = "ok";
								}
								else {
									$output['status'] = "fail";
								}
								
							}
							else {
								$output['status'] = "fail";
							}
						}
					}
				}
			}
			elseif ($sebagai == "Siswa") {
				$username = htmlspecialchars($field['username']);
				$cekuser = $this->countTable("tb_user WHERE username='$username'");
				if ( $cekuser > 0 ) {
					$output['status'] = "already";
					$output['already'] = "Username";
				}
				else {
					$nis = htmlspecialchars($field['nis']);
					$ceknis = $this->countTable("tb_siswa WHERE nis='$nis'");
					if ($ceknis > 0) {
						$output['status'] = "already";
						$output['already'] = "NIS";
					}
					else {
						if (!is_null($foto)) {
							$gambar = $this->uploadGambar($foto);
						}
						else {
							$gambar = "noprofile.png";
						}
						if ($gambar == "invalid" || $gambar == "toolarge") {
							$output['status'] = $gambar;
						}
						else {
							$nama = htmlspecialchars($field['nama']);
							$tempat_lahir = htmlspecialchars($field['tempat_lahir']);
							$tanggal_lahir = $field['tanggal_lahir'];
							$jk = $field['jk'];
							$alamat = htmlspecialchars($field['alamat']);
							$no_telp = htmlspecialchars($field['no_telp']);
							$email = htmlspecialchars($field['email']);
							$id_siswa = $this->autokode("tb_siswa","id_siswa","SW",5);
							$sql = "'$id_siswa','$nis','$nama','$jk','$tempat_lahir','$tanggal_lahir','$alamat','$no_telp','$email','$gambar'";
							$input = $this->insertData("tb_siswa",$sql);
							if ($input) {
								$password = htmlspecialchars($field['password']);
								$password = password_hash($password, PASSWORD_DEFAULT);
								$register = $this->insertData("tb_user","'$username','$password','$id_siswa','Siswa'");
								if ($register) {
									$output['status'] = "ok";
								}
								else {
									$output['status'] = "fail";
								}
								
							}
							else {
								$output['status'] = "fail";
							}
						}
					}
				}
			}
			elseif ($sebagai == "Admin") {
				$username = htmlspecialchars($field['username']);
				$cekuser = $this->countTable("tb_user WHERE username='$username'");
				if ( $cekuser > 0 ) {
					$output['status'] = "already";
					$output['already'] = "Username";
				}
				else {
					$gambar = !is_null($foto) ? $this->uploadGambar($foto) : "noprofile.png";
					if ($gambar == "invalid" || $gambar == "toolarge") {
						$output['status'] = $gambar;
					}
					else {
						$nama = htmlspecialchars($field['nama']);
						$tempat_lahir = htmlspecialchars($field['tempat_lahir']);
						$tanggal_lahir = $field['tanggal_lahir'];
						$jk = $field['jk'];
						$alamat = htmlspecialchars($field['alamat']);
						$no_telp = htmlspecialchars($field['no_telp']);
						$email = htmlspecialchars($field['email']);
						$id_admin = $this->autokode("tb_admin","id_admin","AD",5);
						$sql = "'$id_admin','$nama','$jk','$tempat_lahir','$tanggal_lahir','$alamat','$no_telp','$email','$gambar'";
						$input = $this->insertData("tb_admin",$sql);
						if ($input) {
							$password = htmlspecialchars($field['password']);
							$password = password_hash($password, PASSWORD_DEFAULT);
							$register = $this->insertData("tb_user","'$username','$password','$id_admin','Admin'");
							if ($register) {
								$output['status'] = "ok";
							}
							else {
								$output['status'] = "fail";
							}
							
						}
						else {
							$output['status'] = "fail";
						}
					}
				}
			}
			return $output;	
		}

		public function editUser($field)
		{
			$username = htmlspecialchars($field['username']);
			$nama = htmlspecialchars($field['nama']);
			$tempatlahir = htmlspecialchars($field['tempat_lahir']);
			$tanggallahir = htmlspecialchars($field['tanggal_lahir']);
			$alamat = htmlspecialchars($field['alamat']);
			$jk = strtoupper($field['jk']);
			$level = strtolower($_SESSION['level']);
			$sql = "";
			$cek = $username != $this->tampilData("tb_user WHERE id_anggota='". $_SESSION['id_anggota'] ."'","username")[0]['username'];
			if ($cek) {
				$cekuser = mysqli_query($this->conn, "SELECT id_anggota FROM tb_user WHERE username = '$username'");
				if ( mysqli_num_rows($cekuser) > 0 ) {
					$get = mysqli_fetch_assoc($cekuser);
					if ($get['id_anggota'] != $_SESSION['id_anggota']) {
						return "already";
					}
				}
				else {
					$updateuser = $this->updateData("tb_user", "username='$username'", "id_anggota = '" . $_SESSION['id_anggota'] . "'");
					$output['isUsernameEdit'] = true;
				}
			}
			else {
				$output['isUsernameEdit'] = false;
			}
			$updatedata = $this->updateData("tb_" . $level, "nama='$nama' ,jk='$jk', tempat_lahir='$tempatlahir', tanggal_lahir='$tanggallahir',alamat='$alamat'", "id_" . $level . "='" . $_SESSION['id_anggota'] . "'");
			$output['isDataEdit'] = $updatedata;
			return $output;
		}

		public function cekCookie(){

	        if(isset($_COOKIE['key1']) && isset($_COOKIE['key2'])){
	            $key1 = $_COOKIE['key1'];
	            $key2 = $_COOKIE['key2'];

	            // ambil username berdasarkan id_anggota
	            $result = mysqli_query($this->conn, "SELECT * FROM tb_user WHERE id_anggota = '$key1'");
	            $row = mysqli_fetch_assoc($result);
	            // cek cookie dan usename
	            if($key2 === hash('sha256', $row['username'])){
	                
						// cek level
						if($row['level'] === "Guru"){
							$_SESSION['level'] = "Guru";
						}else if($row['level'] === "Siswa"){
							$_SESSION['level'] = "Siswa";
						}
	            	}
	        	}
    	}

    	public function cekSession($level)
		{
			return $_SESSION['level'] == $level;
		}

		public function gantiPass($field) {
			
			$cekuser = $this->tampilData("tb_user WHERE id_anggota = '" . $_SESSION['id_anggota'] . "'","password")[0];
			if (password_verify($field['passwordlama'], $cekuser['password'])) {
				$password = password_hash($field['passwordbaru'], PASSWORD_DEFAULT);
				$hasil = mysqli_query($this->conn, "UPDATE tb_user SET password = '$password' WHERE id_anggota = '" . $_SESSION['id_anggota'] . "'");
				if (mysqli_affected_rows($this->conn) === 1) {
					return "true";
				}
				else {
					return "false";
				}
			}
			else {
				return "wrong";
			}
		}

		public function autokode($table,$field,$pre,$maxzero){
            $zero = "0";
            for ($i=1; $i < $maxzero; $i++) { 
            	$zero = $zero . "0";
            }
            $number		= $this->tampilData($table,"COUNT($field) as jumlah")[0];
            if($number['jumlah'] > 0){
                $sql    = "SELECT MAX($field) as kode FROM $table";
                $query  = mysqli_query($this->conn,$sql);
                $number = mysqli_fetch_assoc($query);
                $strnum = substr($number['kode'], 2,$maxzero);
                $strnum = $strnum + 1;
                
                for ($i=1; $i <= $maxzero; $i++) { 
                	$zero = substr($zero, 0, -1);
				    if (strlen($strnum) == $i) {
				    	$kode = $pre . $zero . $strnum;
				    	break;
				    }
                }
            }else{
            	$zero = substr($zero, 0, -1);
                $kode = $pre.$zero."1";
            }

            return $kode;
        }

        public function insertData($table, $field)
        {
        	$sql = "INSERT INTO $table VALUES(" . $field . ")";
        	$hasil = mysqli_query($this->conn, $sql);
        	if (mysqli_affected_rows($this->conn) == 1) {
				return true;
			}
			else {
				return false;
			}
        }

        public function updateData($table, $field, $where)
        {
        	$sql = "UPDATE $table SET " . $field . " WHERE " . $where;
        	$hasil = mysqli_query($this->conn, $sql);
        	if (mysqli_affected_rows($this->conn) == 1) {
				return true;
			}
			else {
				return false;
			}
        }

        public function deleteData($table, $where)
        {
        	$sql = "DELETE FROM $table WHERE " . $where;
        	$hasil = mysqli_query($this->conn, $sql);
        	if (mysqli_affected_rows($this->conn) == 1) {
				return true;
			}
			else {
				return false;
			}
        }
        function uploadGambar($file, $folder="img-db") {
			$namafile = $file["name"];
			$ukuranfile = $file["size"];
			$error = $file["error"];
			$tmpname = $file["tmp_name"];

			// If image not selected
			if ($error === 4) {
				return "noimage";
			}

			$validext = ['jpg','jpeg','png', 'bmp']; // Valid Extension of Files
			$get_ext = strtolower(pathinfo($namafile, PATHINFO_EXTENSION));
			if (!in_array($get_ext, $validext)) {
				return 'invalid';
			}
			if ($ukuranfile > 1048576) { // If a File too large (>2 MB)
				return 'toolarge';
			}
			// Generate Random name
			$newname = uniqid() . '.' . $get_ext;

			move_uploaded_file($tmpname, $folder . '/' . $newname);
			return $newname;
		}

        public function countTable($table)
        {
        	$cek = mysqli_query($this->conn, "SELECT * FROM $table");
        	return mysqli_num_rows($cek);
        }
        public function getKonfigurasi()
        {
        	return $this->tampilData("tb_konfigurasi")[0];
        }
        public function getNama(){
        	$sebagai = strtolower($_SESSION['level']);
        	$table = "tb_" . $sebagai;
        	$id = "id_" . $sebagai;
        	$sql = "SELECT nama FROM $table WHERE $id = '" . $_SESSION['id_anggota'] . "'";
        	$cek = mysqli_query($this->conn, $sql);
        	$nama = mysqli_fetch_assoc($cek);
        	return $nama['nama'];
        }
        public function getLevel()
        {
        	return $_SESSION['level'];
        }
        public function cekLevel($level)
        {
        	return $level == $_SESSION['level'];
        }
        public function isLogin()
        {
        	return (isset($_SESSION['level']) && isset($_SESSION['id_anggota']));
        }
        public function tampilData($table, $field = "*")
        {
        	$query = mysqli_query($this->conn, "SELECT $field FROM $table");
        	if (mysqli_num_rows($query) == 0) {
        		return null;
        	}
        	while ($data = mysqli_fetch_assoc($query)) {
        		$isi[] = $data;
        	}
        	return $isi;
        }
        public function resetSoal()
        {
        	unset($_SESSION['id_level']);
        	unset($_SESSION['id_soal']);
            unset($_SESSION['nomorsoal']);
            unset($_SESSION['nyawa']);
            unset($_SESSION['total']);
            unset($_SESSION['sisawaktu']);
            unset($_SESSION['cheated']);
        }
        public function getProgress($diff)
        {
        	$progress['selesai'] = $this->countTable("v_nilai WHERE kesulitan='$diff' AND nilai='100' AND id_siswa='" . $_SESSION['id_anggota'] . "' GROUP BY id_level");
            $progress['total'] = $this->countTable("tb_level WHERE kesulitan='$diff'");
            if ($progress['total'] == 0) {
            	$progress['progress'] = 0;
            } else {
                $progress['progress'] = ceil(($progress['selesai'] / $progress['total']) * 100);
            }
            return $progress;
        }
        public function cekAjaxLoad()
        {
        	return (isset($_SERVER["HTTP_X_REQUESTED_WITH"]) &&
        		strtolower(@$_SERVER["HTTP_X_REQUESTED_WITH"]) == "xmlhttprequest");
        }
        public function cekPermainan()
        {
        	$cek = $this->tampilData("tb_progresskuis WHERE id_siswa = '" . $_SESSION['id_anggota'] . "'")[0];
        	if ($this->cekLevel("Siswa") && !is_null($cek)) {
        		$_SESSION['id_level'] = $cek['id_level'];
        		return true;
        	}
        	else {
        		return false;
        	}
        }
        public function arrayTrim(&$value) // USE array_walk()
        {
        	$value = trim($value);
        }
        public function cropImage($location, $x, $y, $w, $h)
        {
        	$ext = strtolower(pathinfo($location, PATHINFO_EXTENSION));
        	$dst_r = imagecreatetruecolor(256, 256);
			imagesavealpha($dst_r, true);
			$transparent = imagecolorallocatealpha($dst_r, 0, 0, 0, 127);
			imagefill($dst_r, 0, 0, $transparent);
			//imagecreatefromjpeg, imagecreatefrompng, imagecreatefrombmp
			switch ($ext) {
				case 'jpg':
				case 'jpeg':
					$img_r = imagecreatefromjpeg($location);
					break;
				case 'png':
					$img_r = imagecreatefrompng($location);
					break;
				case 'bmp':
					$img_r = imagecreatefrombmp($location);
					break;
			}
			imagecopyresampled($dst_r,$img_r,0,0,$x,$y,256,256,$w,$h);
			$res = imagepng($dst_r, $location);
			return $res;
        }
        public function DiffForHumans($datetime, $full = false)
		{
			$now = new DateTime;
		    $ago = new DateTime($datetime);
		    $diff = $now->diff($ago);

		    $diff->w = floor($diff->d / 7);
		    $diff->d -= $diff->w * 7;

		    $string = array(
		        'y' => 'tahun',
		        'm' => 'bulan',
		        'w' => 'minggu',
		        'd' => 'hari',
		        'h' => 'jam',
		        'i' => 'menit',
		        's' => 'detik',
		    );
		    foreach ($string as $k => &$v) {
		        if ($diff->$k) {
		            $v = $diff->$k . ' ' . $v;
		        } else {
		            unset($string[$k]);
		        }
		    }

		    if (!$full) $string = array_slice($string, 0, 1);
		    return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
		}
	}
?>