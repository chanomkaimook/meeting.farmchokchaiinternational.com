<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Format_date
{
	// private $path_barcode = FCPATH . 'asset/image/barcode/';

	public function __construct()
	{
	}

	public function format_datatable($date)
	{
		# code...
		//=	 call database	=//
		$ci = &get_instance();
		$ci->load->database();
		//===================//

		$yearindent = date('y');
		$year = date('Y');
		$month = date('m');

		$day = date('D',strtotime($date));

		// $format = date('D',strtotime($date));

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