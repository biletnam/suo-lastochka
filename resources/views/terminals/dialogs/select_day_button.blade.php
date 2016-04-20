                    <div class="col-md-4">
                        @php($disabled = ($i >= $indexToday) ? "" : ' suo-terminal-record-button-disabled')
                        <div id="btn-record-day-{{ $i }}" class="suo-terminal-record-button{{ $disabled }}" onclick="onClickDay( '{{ $i }}' ); return false;">
                            <p id="text-record-day-{{ $i }}" class="suo-terminal-record-button-on-middle">{{ $week0[$i] }}</p>
                            <p class="suo-terminal-record-button-record-count" id="text-record-day-ticket-count-{{ $i }}"></p>
                        </div>
                    </div>
