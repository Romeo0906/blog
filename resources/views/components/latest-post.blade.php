<section id="one">
    <header class="major">
        <h2>{{ $post->title }}</h2>
    </header>
    <p>{{ $post->description }}</p>
    <ul class="actions">
        <li><a href="{{ route('home.posts.show', ['id' => $post->id]) }}" class="button">查看文章</a></li>
    </ul>
</section>