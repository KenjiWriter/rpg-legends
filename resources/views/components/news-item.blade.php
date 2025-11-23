@props(['news'])

<div class="news-item rpgui-container framed @if($news->is_pinned) news-pinned @endif">
    <div class="news-header">
        <h3 class="news-title">
            @if($news->is_pinned)
                <span class="pin-icon">📌</span>
            @endif
            {{ $news->title }}
        </h3>
        <span class="news-date">{{ $news->published_at->diffForHumans() }}</span>
    </div>
    
    <div class="news-content">
        <p>{{ $news->content }}</p>
    </div>
    
    @if($news->author)
        <div class="news-footer">
            <span class="news-author">~ {{ $news->author->name }}</span>
        </div>
    @endif
</div>
