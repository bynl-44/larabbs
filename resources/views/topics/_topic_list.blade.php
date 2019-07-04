@if (count($topics))
  <ul class="list-unstyled">
    @foreach($topics as $topic)
      <li class="media">
        <div class="media-left">
          <a href="{{ route('user.show', [$topic->user]) }}">
            <img class="media-object img-thumbnail mr-3" src="{{ $topic->user->avatar }}"
                 title="{{ $topic->user->name }}"
                 style="width: 52px; height: 52px;" alt="">
          </a>
        </div>
        <div class="media-body">
          <div class="media-heading mt-0 mb-1">
            <a href="{{ route('topics.show', $topic) }}" title="{{ $topic->title }}">{{ $topic->title }}</a>
            <a href="{{ route('topics.show', $topic) }}" class="float-right">
              <span class="badge badge-secondary badge-pill">{{ $topic->reply_count }}</span>
            </a>
          </div>
          <small class="media-body meta text-secondary">
            <a href="{{ route('categories.show', $topic->category) }}" class="text-secondary" title="{{ $topic->category->name }}">
              <i class="far fa-folder"></i>
              {{ $topic->category->name }}
            </a>
            <span> • </span>
            <a href="{{ route('user.show', $topic->user) }}" class="text-secondary" title="{{ $topic->user->name }}">
              <i class="far fa-user"></i>
              {{ $topic->user->name }}
            </a>
            <span> • </span>
            <i class="far fa-clock"></i>
            <span class="timeago" title="最后活跃于：{{ $topic->updated_at }}">{{ $topic->updated_at->diffForHumans() }}</span>
          </small>
        </div>
      </li>
      @if (!$loop->last)
        <hr>
      @endif
    @endforeach
  </ul>
  @else
  <div class="empty-block">暂无数据...</div>
@endif
