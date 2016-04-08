                <tr>
                    <!-- Panel Name -->
                    <td class="table-text">{{ $panel->ip_address }}</td>

                    <td>{{ $panel->name }}</td>

                    <td>{{ $panel->description }}</td>

                    <td>
                        <form action="{{ url('panel/select') }}" method="POST">
                            {!! csrf_field() !!}

                            <input type="hidden" name="panel" value="{{ $panel->id }}">
                            <button type="submit" id="select-panel-{{ $panel->id }}" class="btn btn-warning">
                                Выбрать
                            </button>
                        </form>
                    </td>
                </tr>
