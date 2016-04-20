
                @for ($row = 0; $row <= 4; $row++)
                <div class="row">
                    @for ($col = 0; $col <= 4; $col++)

                    <div class="col-md-2">
                        <div class="suo-terminal-record-button" onclick="onClickTime( '{{ $row }} {{ $col }}' ); return false;">
                            <p class="suo-terminal-record-button-on-middle">{{ $row }} {{ $col }}</p>
                        </div>
                    </div>

                    @endfor
                </div>

                @endfor
