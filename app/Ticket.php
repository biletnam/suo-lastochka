<?php

namespace suo;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    /*
     * Статусы заявок
     * Жизненный цикл
     *  Циклы
     * 1. (Умолчание) Создана базой данных со значение по умолчанию
     * 2. (Через терминал) NEWTICKET - CALLED - ACCEPTED - CLOSED
     *
     */

    /**
     * Заявка создана базой данных со значение по умолчанию
     */
    const DBDEFAULT = 0;

    /**
     * Заявка создана, ждёт постановки в очередь
     */
    const NEWTICKET = 1;

    /**
     * Заявка закрыта
     */
    const CLOSED = 2;

    /**
     * Вызов оператором
     */
    const CALLED = 3;

    /**
     * Заявка обрабатывается
     */
    const ACCEPTED = 4;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['room_id', 'status', 'check_id', 'admission_date'];

    public function room()
    {
        return $this->belongsTo('suo\Room');
    }

    public function check()
    {
        return $this->belongsTo('suo\Check');
    }
}
