<?php

namespace suo;

/**
 * Класс для выдачи периодов работы по дням
 *
 * Должен выдавать, работает ли данный кабинет (оператор) в определённый день и час
 */
class Worktime
{
    protected $template = 1;

    public function isRoomWorkByDate($date)
    {
        $result = false;

        return $result;
    }

    
}
