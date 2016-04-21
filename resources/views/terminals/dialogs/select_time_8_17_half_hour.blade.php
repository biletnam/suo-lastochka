
                @php($index = 0)
                @for ($row = 0; $row < 4; $row++)
                <div class="row">
                    <div class="row"><div class="col-md-12">&nbsp;</div></div>
                    @for ($col = 0; $col < 4; $col++)
                    @php($time = $times[$index]['caption'])
                    @php($disabled = $times[$index]['disabled'])
                    @php($class = ('true' != $disabled) ? '' : ' suo-terminal-record-button-disabled')
                    <div class="col-md-3">
                        <div class="suo-terminal-record-button{{ $class }}" onclick="onClickTime( '{{ $time }}', {{ $disabled }} ); return false;">
                            <p class="suo-terminal-record-button-on-middle">{{ $time }}</p>
                        </div>
                    </div>

                    @php($index++)
                    @endfor
                </div>

                @endfor
