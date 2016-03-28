                            <tr>
                                <!-- Panel Name -->
                                <td class="table-text">
                                    <div>{{ $panel->ip_address }}</div>
                                </td>

                                <td>
                                    <div>{{ $panel->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $panel->description }}</div>
                                </td>

                                <td>
                                    <form action="{{ url('panel/select') }}" method="POST">
                                        {!! csrf_field() !!}

                                        <input type="hidden" name="panel" value="{{ $panel->id }}">
                                        <button type="submit" id="select-panel-{{ $panel->id }}" class="btn btn-danger">
                                            <i class="fa fa-btn fa-trash"></i>Select
                                        </button>
                                    </form>
                                </td>
                            </tr>
