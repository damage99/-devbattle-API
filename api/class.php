<?

class Converter
{
   protected 
   $exrate = array();
   
   private 
   $SE = array(
   "post"=>'POST аргументы не определены!',
   "get"=>'GET аргументы не определены!',
   "args"=>'Неверные аргументы конвертации!',
   "valute"=>'Заданные валюты не поддерживаются, или переводимая валюта с конечной - равны!',
   "value"=>'Неверный тип значения для перевода!',
   "exrload"=>'Не удалось загрузить актуальный курс валют'
   );
   
   function __construct() {
	   $this->LoadExRate();
   }
   
   public function Finish($res="") {
	   die(json_encode(array("status"=>'success', "value"=>$res))); 
   }

   public function Error($abrerr="") {
       die(json_encode(array("status"=>'error', "description"=>$this->SE[$abrerr])));
   }
   
   public function doPrintAV() {
	   $array_result = array();
	   
	   foreach(array_keys($this->exrate['Valute']) as $valute)
	   array_push($array_result,array('name'=>strtolower($valute),'title'=>$this->exrate['Valute'][$valute]['Name']));
	   
	   echo '[';
	   
	   foreach($array_result as $ar_index => $ar_value) {
		   if($ar_index)
			   echo ',';
		   echo json_encode($ar_value);
	   }
	   
	   echo ']';
   }
   public function TryConvert($P) {
	   if( $this->is_valute($from=mb_strtoupper($P['from'])) && $this->is_valute($to=mb_strtoupper($P['to'])) && ($from!=$to) ) 
	   {
		   if( is_int($value=(float)$P['value']) || is_float($value) )
			   $this->doConvert($from,$to,$value);
		   else
			   $this->Error('value'); 
	   }
	   else
		   $this->Error('valute');
   }
   
   private function doConvert($f,$t,$v) {
	   $vov = $this->LoadVoV($f,$t);
	   
	   $eFrom=$vov[0];
	   $eTo=$vov[1];
	   
	   $this->Finish(
	   ($eFrom * $v / $eTo)
	   );
	   
   }
   
   private function is_valute($s) {
	   return !array_key_exists( $s, $this->exrate['Valute'] )?false:true;
   }
   
   private function LoadVov($f,$t) {
	   return array( ($this->exrate['Valute'][$f]['Value']), ($this->exrate['Valute'][$t]['Value']) );
   }
   
   private function LoadExRate() {
	
	$curl = curl_init();
    curl_setopt( $curl, CURLOPT_URL, 'https://www.cbr-xml-daily.ru/daily_json.js' );
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt( $curl, CURLOPT_POST, false );
    $response = curl_exec( $curl );
    curl_close( $curl );
               
    if ( ($this->exrate = json_decode( $response, true )) !== null ) {
		$this->exrate['Valute']['RUB']['Value'] = 1;
		$this->exrate['Valute']['RUB']['Name'] = 'Российский Рубль';
		return true;		
	}
	
	$this->Error("loadexr");
	
	return false;
   }
}

?>
