@php($func=(0 != $room->can_record) ? 'recordTicket' : 'createTicket')
                    <button id="create-ticket-{{ $room->id }}" class="btn suo-terminal-button" onclick="{{ $func }}( {{ $room->id }} ); return false;">
                        <div>
                            {{ $room->description }}
                        </div>
                        @if(0 == $room->can_record && 0 != $room->max_day_record)

                        <div>
                            Уже записалось <span id="suo-tickets-count-{{ $room->id }}">0</span>.
                            Максимум <span id="suo-max-day-record-{{ $room->id }}">{{ $room->max_day_record }}</span>.
                        </div>
                        @endif

                    </button>
