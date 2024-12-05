@extends('admin.theme.default')
@section('content')
@include('admin.breadcrumb')
<div class="container-fluid">
    <section class="gallery-section">
        @include('admin.gallery.card-view')
    </section>
</div>
@endsection
@section('script')
<script src="{{url(env('ASSETSPATHURL').'admin-assets/assets/js/custom/gallery.js') }}"></script>
@endsection