<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Timetemplate extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description'];

    public function room()
    {
        return $this->belongsTo('suo\Room');
    }

    public function getTimeCaption($busyTimes)
    {
        $method = 'getTimeCaption_' . $this->name;

        return $this->$method($busyTimes);
    }

    private function getTimeCaption_8_17_half_hour($busyTimes)
    {
        $result = [];

        $date1 = strtotime("8 hour midnight");
        $date2 = strtotime("17 hour midnight");
        $add = 30 * 60; // полчаса

        for ($date = $date1; $date < $date2; $date += $add) {
            if (12 == date("H", $date)) {
                continue;
            }
            $time = date("H:i", $date);
            $disabled = 'false';
            if (isset($busyTimes[$time])) {
                $disabled = 'true';
            }

            $result[] =  ['caption' => $time, 'disabled' => $disabled];
        }

        return $result;
    }

    private function getTimeCaption_8_17_third_hour($busyTimes)
    {
        $result = [];

        $date1 = strtotime("8 hour midnight");
        $date2 = strtotime("17 hour midnight");
        $add = 20 * 60; // треть часа

        for ($date = $date1; $date < $date2; $date += $add) {
            if (12 == date("H", $date)) {
                continue;
            }
            $time = date("H:i", $date);
            $disabled = 'false';
            if (isset($busyTimes[$time])) {
                $disabled = 'true';
            }

            $result[] =  ['caption' => $time, 'disabled' => $disabled];
        }

        return $result;
    }

}
