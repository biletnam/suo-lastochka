<?php

namespace suo\Repositories;

use suo\Check;

/**
 * Description of CheckRepository
 *
 * @author Ilia Garaga <ilia at suo>
 */
class CheckRepository
{
    public function newCheckToDate($date)
    {
        $date = date('Y-m-d', strtotime($date));
        $number = $this->getMaxNumberToDate($date);
        $number++;

        $check = new Check(['number' => $number, 'admission_date' => $date]);

        $check->save();

        return $check;
    }

    public function getMaxNumberToDate($date)
    {
        return Check::where('admission_date', $date)->max('number');;
    }

}
