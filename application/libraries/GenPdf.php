<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

require_once 'csspdf/autoload.inc.php';

use Dompdf\Dompdf;
use Dompdf\Options;

/**
 * 
 */
class GenPdf extends Dompdf
{
	
	function __construct()
	{
		parent ::__construct();
	}
}

?>