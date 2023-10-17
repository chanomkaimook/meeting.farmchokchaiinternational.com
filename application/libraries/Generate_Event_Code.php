<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Generate_Event_Code
{
	// private $path_barcode = FCPATH . 'asset/image/barcode/';

	public function __construct()
	{
	}

	public function gen_code()
	{
		# code...
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//

		$yearindent = date('y');
		$year = date('Y');
		$month = date('m');

		$optional = array(
			'year(date_starts)'		=> $year,
			'month(date_starts)'	=> $month
		);
		$query = $ci->mdl_event->get_data(null, $optional);
		$num = count($query);
		if ($num) {
			$numnext = (int) $num + 1;
			$numpad = str_pad($numnext, 3, '0', STR_PAD_LEFT);
			$code = $yearindent . "" . $month . "" . $numpad;
		} else {
			$numpad = "001";
			$code = $yearindent . "" . $month . "" . $numpad;
		}

		$result = $code;

		return $result;
	}


}