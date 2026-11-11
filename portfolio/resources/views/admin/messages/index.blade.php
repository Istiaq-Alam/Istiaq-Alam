@extends('admin.layout')

@section('title', 'Messages')

@section('content')
  <h1>Contact Messages</h1>
  @if ($messages->isEmpty())
    <div class="card empty">No messages yet.</div>
  @else
    <div class="item-list">
      @foreach ($messages as $message)
        <div class="item">
          <div class="item-head" style="justify-content:space-between">
            <div class="item-title {{ $message->is_read ? '' : 'unread' }}" style="min-width:0">{{ $message->fullname }}</div>
            <span class="item-meta" style="white-space:nowrap">{{ $message->created_at?->diffForHumans() }}</span>
          </div>
          <div class="item-meta">{{ $message->email }}</div>
          <p class="item-body">{{ $message->message }}</p>
          <div class="item-actions">
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
          </div>
        </div>
      @endforeach
    </div>
  @endif
@endsection
