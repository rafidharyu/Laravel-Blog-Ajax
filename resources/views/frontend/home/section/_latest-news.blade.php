<!-- Latest News Start -->
<div class="container-fluid latest-news py-5">
    <div class="container py-5">
        <h2 class="mb-4">Latest Articles</h2>
        <div class="latest-news-carousel owl-carousel">
            @foreach ($latest_articles as $latest)
            <div class="latest-news-item">
                <div class="bg-light rounded">
                    <div class="rounded-top overflow-hidden">
                        <img src="{{ asset('storage/images/'.$latest->image) }}"
                            class="img-zoomin img-fluid rounded-top w-100" alt="">
                    </div>
                    <div class="d-flex flex-column p-4">
                        <a href="{{ route('articles.show', $latest->slug) }}" class="h4">{{ $latest->title }}</a>
                        <div class="d-flex justify-content-between">
                            <a href="#" class="small text-body link-hover">
                                by {{ $latest->user ? $latest->user->name : 'User Tidak Ditemukan' }}
                            </a>
                            <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                {{ date('d M Y', strtotime($latest->published_at)) }}
                            </small>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- Latest News End -->
