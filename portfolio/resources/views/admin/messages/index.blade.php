@extends('admin.layout')

@section('title', 'Messages')

@section('content')
  <h1>Contact Messages</h1>
  <div class="card">
    @if ($messages->isEmpty())
      <p>No messages yet.</p>
    @else
      <div class="table-wrap"><table>
        <thead>
          <tr><th>From</th><th>Email</th><th>Message</th><th>Received</th><th></th></tr>
        </thead>
        <tbody>
          @foreach ($messages as $message)
            <tr>
              <td class="{{ $message->is_read ? '' : 'unread' }}">{{ $message->fullname }}</td>
              <td>{{ $message->email }}</td>
              <td>{{ $message->message }}</td>
              <td>{{ $message->created_at?->diffForHumans() }}</td>
              <td>
                @unless ($message->is_read)
                  <form method="POST" action="{{ route('admin.messages.read', $message) }}" class="inline">
                    @csrf @method('PATCH')
                    <button class="btn secondary" type="submit">Mark read</button>
                  </form>
                @endunless
                <form method="POST" action="{{ route('admin.messages.destroy', $message) }}" class="inline" onsubmit="return confirm('Delete this message?')">
                  @csrf @method('DELETE')
                  <button class="btn danger" type="submit">Delete</button>
                </form>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table></div>
    @endif
  </div>
@endsection
