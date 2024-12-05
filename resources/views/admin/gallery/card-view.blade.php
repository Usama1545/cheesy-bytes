@if (count($getgalleries) > 0)
    <div class="row g-3 row-cols-xl-5 row-cols-lg-3 row-cols-md-3 row-cols-sm-3 row-cols-2">
        @foreach ($getgalleries as $gallery)
            <div class="col">
                <div class="card border-0 text-center">
                    <div class="card-body border-0">
                        <img src="{{ helper::image_path($gallery->image) }}" class="img-fluid gallery-img rounded"
                            alt="">
                        <div class="mt-2">
                            <div class="d-flex flex-wrap gap-1 justify-content-center">
                                <a class="btn btn-sm btn-info square" href="{{ URL::to('admin/gallery-' . $gallery->id) }}"><i
                                        class="fa-solid fa-pen-to-square"></i></a>
                                <a class="btn btn-sm btn-danger square" href="javascript:void(0)"
                                    @if (env('Environment') == 'sendbox') onclick="myFunction()" @else onclick="Delete('{{ $gallery->id }}','{{ URL::to('admin/gallery/delete') }}')" @endif><i
                                        class="fa fa-trash"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    @include('admin.nodata')
@endif
