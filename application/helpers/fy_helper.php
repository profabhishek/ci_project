<?php function getFinancialYears($from, $nexttoyears) {
		$CI =& get_instance();
        $currentDate = $from;
        $lastFY = date('Y-m-d', strtotime('+' . $nexttoyears . ' years'));
        return $CI->calcFY($currentDate, $lastFY);
    }
	
	
 function calcFY($startDate, $endDate) {

        $prefix = '';

        $ts1 = strtotime($startDate);
        $ts2 = strtotime($endDate);

        $year1 = date('Y', $ts1);
        $year2 = date('Y', $ts2);

        $month1 = date('m', $ts1);
        $month2 = date('m', $ts2);

        //get months
        $diff = (($year2 - $year1) * 12) + ($month2 - $month1);

        /**
         * if end month is greater than april, consider the next FY
         * else dont consider the next FY
         */
        $total_years = ($month2 > 4) ? ceil($diff / 12) : floor($diff / 12);

        $fy = array();

        while ($total_years >= 0) {

            $prevyear = $year1 - 1;

            //We dont need 20 of 20** (like 2014)
            //  $fy[] = $prefix.substr($prevyear,-2).'-'.substr($year1,-2);
            $fy[] = $prevyear . '-' . $year1;

            $year1 += 1;

            $total_years--;
        }
        /**
         * If start month is greater than or equal to april, 
         * remove the first element
         */
        if ($month1 >= 4) {
            unset($fy[0]);
        }
        /* Concatenate the array with ',' */
        return $fy;
    }
	?>