<tr>
    <td class="table-text">
        <button id="create-ticket-{{ $room->id }}" class="btn btn-danger btn-create-ticket" value="{{ $room->id }}" onclick="createTicket(this.value); return false;">
            <div>{{ $room->description }}</div>
        </button>
    </td>
</tr>
