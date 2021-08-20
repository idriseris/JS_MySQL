<?PHP
class MySQL {
    static $pdo,$last = null;
    public static function request(){
		return self::$pdo == null ? self::connect() : self::$pdo;
    }
    public static function connect(){
        try {
            self::$pdo = new PDO("mysql:host=".MYSQL_HOST.";dbname=".MYSQL_DB,MYSQL_USER,MYSQL_PASS);
            self::$pdo->exec('SET NAMES `UTF-8` COLLATE `utf8`');
			self::$pdo->exec('SET CHARACTER SET utf8');
			self::$pdo->exec('SET COLLATION_CONNECTION = `utf8`');
            self::$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
            return self::$pdo;
        } catch(PDOException $e) {
            die();
        }
    }
    public static function query($query){
        self::$last = self::request()->query($query);
        if(self::$last){
            return self::$last;  
        }
    }
    public static function add($table,$arg){
        $label_d = array();
        foreach($arg as $key=>$data){
            array_push($label_d, '`'.$key.'`');
        }
        $label = implode(',', $label_d);
        $keys = array_keys($arg);
        $regular = array_map("self::unison",$arg);
        $value = "'".implode("','",$regular)."'";
        if(self::query("INSERT INTO ".$table." (".$label.") VALUES (".$value.")")){
            return self::$pdo->lastInsertId();
        }
    }
    public static function update($table,$arg,$where=array()){
        $data_array = array();
        foreach($arg as $key=>$data){
            $path = (gettype($data)=="integer")?"":"'";
            $data = self::unison($data);
            array_push($data_array,'`'.$key.'`'."=$path".$data."$path");
        }
        $query = "UPDATE $table SET ".implode(', ', $data_array).self::where($where);
        if(self::query($query)){
            return true;
        }
    }
    public static function delete($table,$where=array()){
        $must = self::where($where);
        if($must){
            $query = "DELETE FROM $table $must";
        } else {
            $query = "TRUNCATE TABLE $table";
        }
        if(self::query($query)){
            return true;
        }
    }
    public static function count($table,$where=array()){
        return self::query("SELECT * FROM $table".self::where($where))->rowCount();
    }
    public static function fetch($table,$where=array("id"=>1)){
        return (object)self::query("SELECT * FROM $table".self::where($where))->fetch(PDO::FETCH_ASSOC);
    }
    public static function where($array){
        $where_array = array();
        foreach($array as $key=>$data){
            $path = (gettype($data)=="integer")?"":"'";
            $data = self::unison($data);
            array_push($where_array,"`".$key."`"."=$path".$data."$path");
        }
        if(count($where_array)){
            return " WHERE ".implode(' AND ', $where_array);
        }
    }
    public static function unison($data){
        $in = array("'","&uuml;","&Uuml;","&ouml;","&Ouml;","&ccedil;","&Ccedil;","&rsquo;");
        $out = array("\'","ü","Ü","ö","Ö","ç","Ç","\'");
        return str_replace($in, $out, $data);
    }
    public static function __callStatic($key,$arg){
		return call_user_func_array(array(self::request(),$key), $arg);
	}
}
?>