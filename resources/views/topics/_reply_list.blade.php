<ul class="list-unstyled">
  @foreach($replies as $index => $reply)
    <li class="media" name="reply{{ $reply->id }}" id="reply{{ $reply->id }}">
      <div class="media-left">
        <a href="{{ route('users.show', $reply->user) }}">
          <img src="{{ $reply->user->avatar }}" alt="{{ $reply->user->name }}" class="media-object img-thumbnail mr-3" style="width:48px; height: 48px;">
        </a>
      </div>
      <div class="media-body">
        <div class="media-heading mt-0 mb-1 text-secondary">
          <a href="{{ route('users.show', $reply->user) }}" title="{{ $reply->user->name }}">
            {{ $reply->user->name }}
          </a>
          <span class="text-secondary"> · </span>
          <span class="meta text-secondary" title="{{ $reply->created_at }}">
            {{ $reply->created_at->diffForHumans() }}
          </span>
          {{-- 回复删除按钮 --}}
          @can('destroy', $reply)
            <form action="{{ route('replies.destroy', $reply) }}" method="post" onsubmit="return confirm('确定要删除此评论？')">
              <span class="meta float-right">
                @csrf
                @method('delete')
                <button type="submit" class="btn btn-default btn-xs fa-pull-left text-secondary">
                  <i class="far fa-trash-alt"></i>
                </button>
              </span>
            </form>
          @endcan
        </div>
        <div class="reply-content text-secondary">
          {!! $reply->content !!}
        </div>
      </div>
    </li>

    @if (!$loop->last)
      <hr>
    @endif

  @endforeach
</ul>
