<!-- Most Populer News Start -->
<div class="container-fluid populer-news py-5">
    <div class="container py-5">
        <div class="tab-class mb-4">
            <div class="row g-4">
                <div class="col-lg-8 col-xl-9">
                    <div class="d-flex flex-column flex-md-row justify-content-md-between border-bottom mb-4">
                        <h1 class="mb-4">What’s New</h1>
                        <ul class="nav nav-pills d-inline-flex text-center">
                            @foreach ($categories as $category)
                            <li class="nav-item mb-3">
                                <a class="d-flex py-2 bg-light rounded-pill {{ $loop->first ? 'active' : '' }} me-2"
                                    data-bs-toggle="pill" href="#tab-{{ $category->id }}">
                                    <span class="text-dark" style="width: 100px;">{{ $category->name }}</span>
                                </a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="tab-content mb-4">
                        @foreach ($whats_new['categories'] as $category)
                            <div id="tab-{{ $category->id }}" class="tab-pane fade {{ $loop->first ? 'show active' : '' }} p-0">
                                <div class="row g-4">
                                    <div class="col-lg-8">
                                        @php
                                            // Ambil artikel terbaru untuk kategori ini
                                            $latestArticle = $whats_new['latest_articles']->firstWhere('category_id', $category->id);
                                        @endphp

                                        @if ($latestArticle)
                                            <div class="position-relative rounded overflow-hidden mb-4">
                                                <img src="{{ asset('storage/images/' . $latestArticle->image) }}"
                                                    class="img-zoomin img-fluid rounded w-100" alt="{{ $latestArticle->title }}">
                                                <div class="position-absolute text-white px-4 py-2 bg-primary rounded"
                                                    style="top: 20px; right: 20px;">
                                                    {{ $category->name }}
                                                </div>
                                                <div class="my-4">
                                                    <a href="{{ route('articles.show', $latestArticle->slug) }}"
                                                        class="h4">{{ $latestArticle->title }}</a>
                                                </div>
                                                <div class="d-flex justify-content-between">
                                                    <a href="#" class="text-dark link-hover me-3"><i class="fa fa-user-edit"></i>
                                                        {{ $latestArticle->user->name }}</a>
                                                    <a href="#" class="text-dark link-hover me-3"><i class="fa fa-eye"></i>
                                                        {{ $latestArticle->views }} Views</a>
                                                    <a href="#" class="text-dark link-hover me-3"><i class="fa fa-calendar-alt"></i> {{ date('d M Y', strtotime($latestArticle->published_at)) }}</a>
                                                </div>
                                                <p class="my-4">{{ Str::limit($latestArticle->content, 200) }}</p>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="col-lg-4">
                                        <div class="row g-4">
                                            @php
                                                // Dapatkan semua artikel lain yang termasuk dalam kategori ini, kecuali yang pertama
                                                $otherArticles = $whats_new['latest_articles']->filter(function($article) use ($category, $latestArticle) {
                                                    return $article->category_id == $category->id && $article->id != $latestArticle->id;
                                                });
                                            @endphp

                                            <!-- Menampilkan artikel lain berdasarkan kategori -->
                                            @foreach ($otherArticles as $latest)
                                                <div class="col-12">
                                                    <div class="row g-4 align-items-center">
                                                        <div class="col-5">
                                                            <div class="overflow-hidden rounded">
                                                                <img src="{{ asset('storage/images/' . $latest->image) }}"
                                                                    class="img-zoomin img-fluid rounded w-100" alt="{{ $latest->title }}">
                                                            </div>
                                                        </div>
                                                        <div class="col-7">
                                                            <div class="features-content d-flex flex-column">
                                                                <p class="text-uppercase mb-2">{{ $category->name }}</p>
                                                                <a href="{{ route('articles.show', $latest->slug) }}" class="h6">{{ $latest->title }}</a>
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
                            </div>
                        @endforeach
                    </div>
                    <div class="border-bottom mb-4">
                        <h2 class="my-4">Most Views News</h2>
                    </div>
                    <div class="whats-carousel owl-carousel">
                        {{-- <div class="latest-news-item">
                            <div class="bg-light rounded">
                                <div class="rounded-top overflow-hidden">
                                    <img src="{{ asset('assets/frontend') }}/img/news-7.jpg"
                                        class="img-zoomin img-fluid rounded-top w-100" alt="">
                                </div>
                                <div class="d-flex flex-column p-4">
                                    <a href="#" class="h4">tai1,</a>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="small text-body link-hover">by Willium Smith</a>
                                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> Dec 9,
                                            2024</small>
                                    </div>
                                </div>
                            </div>
                        </div> --}}
                        @foreach ($most_view as $item)
                        <div class="whats-item">
                            <div class="bg-light rounded">
                                <div class="rounded-top overflow-hidden">
                                    <img src="{{ asset('storage/images/' . $item->image) }}"
                                        class="img-zoomin img-fluid rounded-top w-100" alt="{{ $item->title }}">
                                </div>
                                <div class="d-flex flex-column p-4">
                                    <a href="{{ route('articles.show', $item->slug) }}" class="h4">{{ $item->title }}</a>
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="small text-body link-hover">by {{ $item->user->name }}</a>
                                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i> {{ date('d M Y', strtotime($item->published_at)) }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="p-3 rounded border">
                                <h4 class="mb-4">Stay Connected</h4>
                                <div class="row g-4">
                                    <div class="col-12">
                                        <a href="#"
                                            class="w-100 rounded btn btn-primary d-flex align-items-center p-3 mb-2">
                                            <i
                                                class="fab fa-facebook-f btn btn-light btn-square rounded-circle me-3"></i>
                                            <span class="text-white">13,977 Fans</span>
                                        </a>
                                        <a href="#"
                                            class="w-100 rounded btn btn-warning d-flex align-items-center p-3 mb-2">
                                            <i class="fab fa-youtube btn btn-light btn-square rounded-circle me-3"></i>
                                            <span class="text-white">7,999 Subscriber</span>
                                        </a>
                                        <a href="#"
                                            class="w-100 rounded btn btn-dark d-flex align-items-center p-3 mb-2">
                                            <i
                                                class="fab fa-instagram btn btn-light btn-square rounded-circle me-3"></i>
                                            <span class="text-white">19,764 Follower</span>
                                        </a>
                                    </div>
                                </div>
                                <h4 class="my-4">Popular Articles</h4>
                                <div class="row g-4">
                                    @foreach ($popular_articles as $articles)
                                        <div class="col-12">
                                            <div class="row g-4 align-items-center features-item">
                                                <div class="col-4">
                                                    <div class="rounded-circle position-relative">
                                                        <div class="overflow-hidden rounded-circle">
                                                            <img src="{{ asset('storage/images/'.$articles->image) }}"
                                                                class="img-zoomin img-fluid rounded w-100" alt="{{ $articles->title }}">
                                                        </div>
                                                        <span
                                                            class="rounded-circle border border-2 border-white bg-primary btn-sm-square text-white position-absolute"
                                                            style="top: 10%; right: -10px;">{{ $articles->views }}</span>
                                                    </div>
                                                </div>
                                                <div class="col-8">
                                                    <div class="features-content d-flex flex-column">
                                                        <p class="text-uppercase mb-2">{{ $articles->category->name }}</p>
                                                        <a href="{{ route('articles.show', $articles->slug) }}" class="h6">
                                                        {{ $articles->title }}
                                                        </a>
                                                        <small class="text-body d-block"><i class="fas fa-calendar-alt me-1"></i>
                                                            {{ date('d M Y', strtotime($articles->published_at)) }}
                                                        </small>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach

                                    <div class="col-lg-12">
                                        <div class="border-bottom my-3 pb-3">
                                            <h4 class="mb-0">Tags</h4>
                                        </div>
                                        <ul class="nav nav-pills d-inline-flex text-center mb-4">
                                            @foreach ($tags as $tag)
                                            <li class="nav-item mb-3">
                                                <a class="d-flex py-2 bg-light rounded-pill me-2" href="{{ route('frontend.tag', $tag->slug) }}">
                                                    <span class="text-dark link-hover" style="width: 90px;">#{{ $tag->name }}</span>
                                                </a>
                                            </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="position-relative banner-2">
                                            <img src="{{ asset('assets/frontend') }}/img/banner-2.jpg" class="img-fluid w-100 rounded"
                                                alt="">
                                            <div class="text-center banner-content-2">
                                                <h6 class="mb-2">The Most Populer</h6>
                                                <p class="text-white mb-2">News & Magazine WP Theme</p>
                                                <a href="#" class="btn btn-primary text-white px-4">Shop Now</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Most Populer News End -->
