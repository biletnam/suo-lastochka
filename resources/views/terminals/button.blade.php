
                    <button class="btn suo-terminal-button" onclick="onClickRoom( {{ $room->id }} ); return false;">
                        <div>
                            {{ $room->description }}
                        </div>
                        @if(0 == $room->can_record && 0 != $room->max_day_record)

                        <div>
                            Уже записалось <span id="suo-tickets-count-{{ $room->id }}">0</span>. Максимум {{ $room->max_day_record }}.
                        </div>
                        @endif

                    </button>
