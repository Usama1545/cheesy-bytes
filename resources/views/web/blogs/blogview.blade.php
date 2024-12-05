<div class="col-lg-4 col-md-6 col-auto">
    <div class="card rounded-4 overflow-hidden">
        <a href="{{ URL::to('/blogs-' . $bloglist->slug) }}"><img src="{{ helper::image_path($bloglist->image) }}"
                class="card-img-top" alt="..."></a>
        <div class="blog-layer">
        </div>
        <div class="card-body w-100">
            <h5 class="card-title fw-500 dark_color"><a href="{{ URL::to('/blogs-' . $bloglist->slug) }}"
                    class="text-white">{{ $bloglist->title }}</a></h5>
            <div class="d-flex align-items-center justify-content-between">
                <div class="col-auto blog-date mb-0">
                    <span>{{ helper::date_format($bloglist->created_at) }}</span>
                </div>
                <a href="{{ URL::to('/blogs-' . $bloglist->slug) }}"
                    class="btn d-flex p-0 align-items-center text-white border-0 {{ session()->get('direction') == '2' ? 'float-start' : 'float-end' }}">{{ trans('labels.read_more') }}
                    <i class="fa-solid fa-arrow-right mx-1"></i></a>
            </div>
        </div>
    </div>
</div>
