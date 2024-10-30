@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">{{ __('Dashboard') }}</h5>
                    <i class="bi bi-bar-chart-fill"></i>
                </div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('status') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Statistics Section -->
                    <h5 class="mb-3 text-secondary">{{ __('Statistics') }}</h5>
                    <div class="row text-center mb-4">
                        <div class="col-6">
                            <div class="card border-0 bg-light py-3">
                                <h6 class="fw-bold text-primary">{{ $statistics['total_articles'] }}</h6>
                                <small class="text-muted">Total Articles</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card border-0 bg-light py-3">
                                <h6 class="fw-bold text-primary">{{ $statistics['pending_articles'] }}</h6>
                                <small class="text-muted">Pending Articles</small>
                            </div>
                        </div>
                    </div>

                    <!-- Categories Section -->
                    <h5 class="mb-3 text-secondary">{{ __('Articles per Category') }}</h5>
                    <ul class="list-group list-group-flush">
                        @foreach ($statistics['categories'] as $category)
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                {{ $category->name }}
                                <span class="badge bg-primary rounded-pill">{{ $category->articles_count }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
