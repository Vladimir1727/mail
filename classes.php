<?php
class tools
{
	static private $param;
	static function setparam($host,$user,$pass,$dbname){
		tools::$param=array($host,$user,$pass,$dbname);
	}
	static function connect(){
		$dsn='mysql:host='.tools::$param[0].';dbname='.tools::$param[3].';charset=utf8;';//строка подключения
		$options=array(
			PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION,//при ошибке - прерывать работу и сигнализировать об ошибке
			PDO::ATTR_DEFAULT_FETCH_MODE=>PDO::FETCH_ASSOC,//получание данных в ассоциативном массиве
			PDO::MYSQL_ATTR_INIT_COMMAND=>'set names "utf8"',
			);//массив параметров для PDO
		$pdo = new PDO($dsn,tools::$param[1],tools::$param[2],$options);
		return $pdo;
	}
}

class mess{
	protected $from,$to,$text,$date,$theme,$user;
	function __construct($from,$to,$text,$theme){
		if ($from=='') $this->from=$_SESSION['email']; else $this->from=$from;
		if ($to=='') $this->to=$_SESSION['email']; else $this->to=$to;
		$this->text=$text;
		$this->date=time();
		$this->theme=$theme;
		$this->user=$_SESSION['id'];
	}
	function send(){
		tools::setparam('localhost','root','123456','mail');
		$pdo=tools::connect();
		$ins=$pdo->prepare('insert into outbox(mto,mtxt,mdate,mtheme,user) values (:mto,:mtxt,:mdate,:mtheme,:user)');
		$data=array('mto'=>$this->to,'mtxt'=>$this->text,'mdate'=>$this->date,'mtheme'=>$this->theme,'user'=>$this->user);
		$ins->execute($data);
		$headers = 'From: '.$this->from."\r\n" .
    		'Reply-To: '.$this->from. "\r\n" .
    		'X-Mailer: PHP/' . phpversion();
		mail($this->to,$this->theme,$this->text,$headers);
	}
	static function load_all($sort,$dir,$usid){
		if (!$sort==''){
			$order='order by '.$sort.' '.$dir;
		}
		else $order='';
		tools::setparam('localhost','root','123456','mail');
		$pdo=tools::connect();
		$sel=$pdo->query('select o.id,o.mto,o.mtheme,o.mdate from outbox o, users u where u.login="'.$usid.'" '.$order);
		while ($row=$sel->fetch()){
			echo '<tr>';
			echo '<td><input type="checkbox" name="itemid[]" value='.$row['id'].'></td>';
			echo '<td>'.$row['mto'].'</td>';
			echo '<td>'.$row['mtheme'].'</td>';
			echo '<td>'.date("d M Y H:i",$row['mdate']).'</td>';
			echo '</tr>';
		}
	}
	static function show_mes($messid){
		tools::setparam('localhost','root','123456','mail');
		$pdo=tools::connect();
		$sel=$pdo->query('select mtxt from outbox where id='.$messid);
		$row=$sel->fetch();
		echo $row['mtxt'];
	}
}