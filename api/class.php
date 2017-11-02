<?
class Converter
{
   private 
   $SE = array(
   "post"=>'POST аргументы не определены!',
   "get"=>'GET аргументы не определены!',
   "args"=>'Неверные аргументы конвертации!',
   "valute"=>'Заданные виды валют - не поддерживаются!',
   "value"=>''
   );

   public function Error($abrerr="") {
       die(json_encode(array("status"=>'error', "description"=>$this->SE[$abrerr])));
   }
   
   public function TryConvert($P) {
	   if( $this->isVV($from=(string)$P['from']) && $this->isVV($to=(string)$P['to']) ) 
	   {
		   if( $this->isVF($value=(double)$P['value']) )
			   $this->doConvert($from,$to,$value);
		   else
			   Error('value'); 
	   }
	   else
		   Error('valute');
		   
   }
   
   private function doConvert($f,$t,$v) {
	   
   }
   
   
   private function isVV($s) {
	   
   }
   
   private function isVF($d) {
	   
   }
}
?>