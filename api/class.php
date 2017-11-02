<?
class Converter
{
   private 
   $SE = array(
   "post"=>'POST аргументы не определены!',
   "get"=>'GET аргументы не определены!',
   "args"=>'Неверные аргументы конвертации!',
   "valute"=>'Заданные валюты не поддерживаются, или переводимая валюта с конечной - равны!',
   "value"=>'Неверный тип значения для перевода!'
   );
   
   public function Finish($res="") {
	   die(json_encode(array("status"=>'success', "value"=>$res))); 
   }

   public function Error($abrerr="") {
	   echo $this->SE[$abrerr];
       die(json_encode(array("status"=>'error', "description"=>$this->SE[$abrerr])));
   }
   
   public function TryConvert($P) {
	   if( $this->is_valute($from=$P['from']) && $this->is_valute($to=$P['to']) && ($from!=$to) ) 
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
	   
	   $this->Finish((($vov[0]*$v)/$vov[1]));
	   
   }
   
   private function is_valute($s) {
	   return in_array($s,array("usd","rub","eur"));
   }
   
   private function LoadVov($f,$t) {
	   $cur = array(
	   "rub"=>1,
	   "usd"=>58.3,
	   "eur"=>68.0
	   );
	   
	   return array($cur[$f],$cur[$t]);
   }
   
}
?>