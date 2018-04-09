<section id="two">
    <h2>近期文章</h2>
    <div class="row" id="card-list-container">
        @foreach($posts as $post)
            <article class="6u 12u$(xsmall) work-item">
                <a href="{{ route('home.posts.show', ['id' => $post->id]) }}" class="image fit thumb">
                    <div class="post-card" style="background-image: url('/images/thumbs/0{{ $post->id % 6 + 1 }}.jpg')">
                        <div style="height: 90%">
                            <p>{{ $post->description }}</p>
                        </div>
                        <div style="height: 10%">
                            <p>{{ date('m 月 d 日', strtotime($post->created_at)) }}</p>
                        </div>
                    </div>
                </a>
                <a href="{{ route('home.posts.show', ['id' => $post->id]) }}"><h3>{{ $post->title }}</h3></a>
            </article>
        @endforeach
    </div>
</section>