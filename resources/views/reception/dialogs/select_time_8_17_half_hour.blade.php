
                @php($index = 0)
                @for ($row = 0; $row < 4; $row++)
                <div class="row"><div class="col-md-12">&nbsp;</div></div>
                <div class="row">
                    @for ($col = 0; $col < 4; $col++)
                    <div class="col-md-3">
                        @include('reception.buttons.time')
                    </div>

                    @php($index++)
                    @endfor
                </div>

                @endfor
