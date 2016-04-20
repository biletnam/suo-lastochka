
                @php($index = 0)
                @for ($row = 0; $row < 4; $row++)
                <div class="row">
                    <div class="row"><div class="col-md-12">&nbsp;</div></div>
                    @for ($col = 0; $col < 4; $col++)

                    <div class="col-md-3">
                        <div class="suo-terminal-record-button" onclick="onClickTime( '{{ $times[$index] }}' ); return false;">
                            <p class="suo-terminal-record-button-on-middle">{{ $times[$index] }}</p>
                        </div>
                    </div>

                    @php($index++)
                    @endfor
                </div>

                @endfor
