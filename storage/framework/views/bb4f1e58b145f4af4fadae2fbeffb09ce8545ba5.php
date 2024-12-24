<div class="col-lg-4 col-md-6 col-auto">
    <div class="card rounded-4 overflow-hidden">
        <a href="<?php echo e(URL::to('/blogs-' . $bloglist->slug)); ?>"><img src="<?php echo e(helper::image_path($bloglist->image)); ?>"
                class="card-img-top" alt="..."></a>
        <div class="blog-layer">
        </div>
        <div class="card-body w-100">
            <h5 class="card-title fw-500 dark_color"><a href="<?php echo e(URL::to('/blogs-' . $bloglist->slug)); ?>"
                    class="text-white"><?php echo e($bloglist->title); ?></a></h5>
            <div class="d-flex align-items-center justify-content-between">
                <div class="col-auto blog-date mb-0">
                    <span><?php echo e(helper::date_format($bloglist->created_at)); ?></span>
                </div>
                <a href="<?php echo e(URL::to('/blogs-' . $bloglist->slug)); ?>"
                    class="btn d-flex p-0 align-items-center text-white border-0 <?php echo e(session()->get('direction') == '2' ? 'float-start' : 'float-end'); ?>"><?php echo e(trans('labels.read_more')); ?>

                    <i class="fa-solid fa-arrow-right mx-1"></i></a>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/web/blogs/blogview.blade.php ENDPATH**/ ?>