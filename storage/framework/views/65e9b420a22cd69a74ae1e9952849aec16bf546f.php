<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div class="container-fluid">
        <div class="row settings">
            <div class="col-xl-3 mb-3">
                <div class="card card-sticky-top border-0">
                    <ul class="list-group list-options">
                        <a href="#edit_profile" data-tab="edit_profile"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center active"
                            aria-current="true"><?php echo e(trans('labels.edit_profile')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#change_password" data-tab="change_password"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"><?php echo e(trans('labels.change_password')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#contact_settings" data-tab="contact_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"><?php echo e(trans('labels.contact_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#seo_settings" data-tab="seo_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"><?php echo e(trans('labels.seo_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php if(@helper::checkaddons('notification')): ?>
                            <a href="#noti_settings" data-tab="noti_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.noti_settings')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <a href="#theme_settings" data-tab="theme_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.theme_settings')); ?>

                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#business_settings" data-tab="business_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.business_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#website_settings" data-tab="website_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.website_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#social_links" data-tab="social_links"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.social_links')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#footer_settings" data-tab="footer_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.footer_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <a href="#mobile_settings" data-tab="mobile_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.mobile_app_settings')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php if(@helper::checkaddons('pwa')): ?>
                            <a href="#pwa" data-tab="pwa"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.pwa')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('email_settings')): ?>
                            <a href="#email_settings" data-tab="email_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.email_settings')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('recaptcha')): ?>
                            <a href="#google_recaptcha" data-tab="google_recaptcha"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.google_recaptcha')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('google_login')): ?>
                            <a href="#google_login_settings" data-tab="google_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.google_login')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('facebook_login')): ?>
                            <a href="#facebook_login_settings" data-tab="facebook_login_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.facebook_login')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('pixel')): ?>
                            <a href="#pixel_settings" data-tab="pixel_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.pixel_settings')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('product_review')): ?>
                            <a href="#review_settings" data-tab="review_settings"
                                class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                                aria-current="true">
                                <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                    <?php echo e(trans('labels.review_settings')); ?>

                                    <?php if(env('Environment') == 'sendbox'): ?>
                                        <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                    <?php endif; ?>
                                </div>
                                <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                            </a>
                        <?php endif; ?>
                        <a href="#admin_setting" data-tab="admin_setting"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.admin_setting')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php if(@helper::checkaddons('tawk_addons')): ?>
                        <a href="#tawk_settings" data-tab="tawk_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.tawk_to_settings')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('wizz_chat')): ?>
                        <a href="#wizz_chat_settings" data-tab="wizz_chat_settings"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.wizz_chat_settings')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('age_verification')): ?>
                        <a href="#age_verification" data-tab="age_verification"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.age_verification')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('quick_call')): ?>
                        <a href="#quick_call" data-tab="quick_call"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.quick_call')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('sales_notification')): ?>
                        <a href="#fake_sales_notification" data-tab="fake_sales_notification"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.fake_sales_notification')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <?php if(@helper::checkaddons('fake_view')): ?>
                        <a href="#product_fake_view" data-tab="product_fake_view"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true">
                            <div class="w-100 d-flex justify-content-between align-items-center me-1">
                                <?php echo e(trans('labels.product_fake_view')); ?>

                                <?php if(env('Environment') == 'sendbox'): ?>
                                    <span class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                <?php endif; ?>
                            </div>
                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                        <?php endif; ?>
                        <a href="#other" data-tab="other"
                            class="list-group-item basicinfo p-3 list-item-secondary d-flex justify-content-between align-items-center"
                            aria-current="true"> <?php echo e(trans('labels.other')); ?>

                            <i class="fa-regular fa-angle-<?php echo e(session()->get('direction') == '2' ? 'left' : 'right'); ?>"></i>
                        </a>
                    </ul>
                </div>
            </div>

            <div class="col-xl-9">
                <div id="settingmenuContent">
                    <div id="edit_profile">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.edit_profile')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/edit-profile')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="name"><?php echo e(trans('labels.name')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="name"
                                                            id="name" value="<?php echo e(Auth::user()->name); ?>"
                                                            placeholder="<?php echo e(trans('labels.name')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="email"><?php echo e(trans('labels.email')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="<?php echo e(Auth::user()->email); ?>"
                                                            placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.mobile')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numbers_only"
                                                            name="mobile" value="<?php echo e(Auth::user()->mobile); ?>"
                                                            placeholder="<?php echo e(trans('labels.mobile')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.image')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="file" class="form-control" name="profile">
                                                        <img src="<?php echo e(helper::image_path(Auth::user()->profile_image)); ?>"
                                                            class="img-fluid rounded user-profile-image mt-1"
                                                            alt="">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="contact_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="change_password">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.change_password')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/change-password')); ?>" method="post">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="old_password"><?php echo e(trans('labels.old_password')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="password" class="form-control" name="oldpassword"
                                                            id="old_password"
                                                            placeholder="<?php echo e(trans('labels.old_password')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="new_password"><?php echo e(trans('labels.new_password')); ?>

                                                        </label>
                                                        <input type="password" class="form-control" name="newpassword"
                                                            placeholder="<?php echo e(trans('labels.new_password')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for="confirm_password"><?php echo e(trans('labels.confirm_password')); ?>

                                                        </label>
                                                        <input type="password" class="form-control"
                                                            name="confirmpassword"
                                                            placeholder="<?php echo e(trans('labels.confirm_password')); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="contact_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="contact_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.contact_settings')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.email')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="email"
                                                            value="<?php echo e(@$getsettings->email == '' ? old('email') : @$getsettings->email); ?>"
                                                            placeholder="<?php echo e(trans('labels.email')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.mobile')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control numbers_only"
                                                            name="mobile"
                                                            value="<?php echo e(@$getsettings->mobile == '' ? old('mobile') : @$getsettings->mobile); ?>"
                                                            placeholder="<?php echo e(trans('labels.mobile')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.address')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="address"
                                                            id="address" placeholder="<?php echo e(trans('labels.address')); ?>"
                                                            value="<?php echo e(@$getsettings->address == '' ? old('address') : @$getsettings->address); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.address_url')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="address_url"
                                                            id="address_url"
                                                            placeholder="<?php echo e(trans('labels.address_url')); ?>"
                                                            value="<?php echo e(@$getsettings->address_url == '' ? old('address_url') : @$getsettings->address_url); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row mt-3">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="contact_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="seo_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.seo_settings')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.og_title')); ?></label>
                                                        <input type="text" class="form-control"
                                                            placeholder="<?php echo e(trans('labels.og_title')); ?>" name="og_title"
                                                            id="og_title"
                                                            value="<?php echo e(@$getsettings->og_title == '' ? old('og_title') : @$getsettings->og_title); ?>">
                                                        <?php $__errorArgs = ['og_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.og_image')); ?>

                                                            (1200 x 650) </label>
                                                        <input type="file" class="form-control" name="og_image"
                                                            id="og_image">
                                                        <?php $__errorArgs = ['image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span><br>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->og_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.og_description')); ?></label>
                                                        <textarea class="form-control" name="og_description" placeholder="<?php echo e(trans('labels.og_description')); ?>"
                                                            id="og_description" rows="6"><?php echo e(@$getsettings->og_description == '' ? old('og_description') : @$getsettings->og_description); ?></textarea>
                                                        <?php $__errorArgs = ['og_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="seo_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php if(@helper::checkaddons('notification')): ?>
                        <div id="noti_settings">
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="card border-0 box-shadow">
                                        <div class="card-header p-3 bg-secondary">
                                            <h5 class="text-white">
                                                <?php echo e(trans('labels.noti_settings')); ?></h5>
                                        </div>
                                        <div class="card-body">
                                            <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                                enctype="multipart/form-data">
                                                <?php echo csrf_field(); ?>
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for=""><?php echo e(trans('labels.noti_tone')); ?>

                                                                (mp3 only) </label>
                                                            <input type="file" class="form-control" name="noti_tune"
                                                                id="noti_tune" accept="audio/mp3" required>
                                                            <?php $__errorArgs = ['noti_tune'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                                <span class="text-danger"><?php echo e($message); ?></span><br>
                                                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        </div>
                                                    </div>

                                                    <div class="col-md-6">
                                                        <div class="form-group mt-4">
                                                            <?php if($getsettings->notification_tune != ''): ?>
                                                                <audio controls>
                                                                    <source
                                                                        src="<?php echo e(url('/')); ?>/storage/app/public/admin-assets/notification/<?php echo e($getsettings->notification_tune); ?>"
                                                                        type="audio/mp3">
                                                                    Your Browser Does Not Support The Audio Element.
                                                                </audio>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div
                                                        class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                        <button class="btn btn-primary"
                                                            <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="notification_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <div id="theme_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.theme_settings')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-12 selectimg">
                                                    <div class="form-group">
                                                        <label class="form-label"><?php echo e(trans('labels.themes')); ?>

                                                            <span class="text-danger"> * </span> </label>
                                                        <div>
                                                        <?php
                                                            $checktheme = @Helper::checkthemeaddons('theme_');
                                                            $themes = array();
                                                            foreach ($checktheme as $ttlthemes) {
                                                                array_push($themes,str_replace("theme_","",$ttlthemes->unique_identifier));
                                                            }
                                                        ?>
                                                        <?php $__currentLoopData = $themes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <label for="template<?php echo e($item); ?>" class="radio-card position-relative">
                                                            <input type="radio" name="template" id="template<?php echo e($item); ?>" value="<?php echo e($item); ?>" 
                                                            <?php echo e(@$getsettings->theme == $item ? 'checked' : ''); ?>>
                                                            <div class="card-content-wrapper border rounded-2">
                                                                <span class="check-icon position-absolute"></span>
                                                                <div class="selecimg">
                                                                    <img
                                                                        src="<?php echo e(helper::image_path('theme-' . $item . '.png')); ?>">
                                                                </div>
                                                            </div>
                                                        </label>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="theme_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div id="business_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.business_settings')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.currency')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.currency')); ?>"
                                                            value="<?php echo e(@$getsettings->currency == '' ? old('currency') : @$getsettings->currency); ?>"
                                                            class="form-control" name="currency" id="currency" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.currency_position')); ?>

                                                        </label>
                                                        <div>
                                                            <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                                <input class="form-check-input me-0" type="radio"
                                                                    name="currency_position" id="inlineRadio1"
                                                                    value="1" required
                                                                    <?php echo e(@$getsettings->currency_position == 1 ? 'checked' : ''); ?>

                                                                    checked>
                                                                <label class="form-check-label"
                                                                    for="inlineRadio1"><?php echo e(trans('labels.left')); ?></label>
                                                            </div>
                                                            <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                                <input class="form-check-input me-0" type="radio"
                                                                    name="currency_position" id="inlineRadio2"
                                                                    value="2" required
                                                                    <?php echo e(@$getsettings->currency_position == 2 ? 'checked' : ''); ?>>
                                                                <label class="form-check-label"
                                                                    for="inlineRadio2"><?php echo e(trans('labels.right')); ?></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Currency Space -->
                                                <div class="form-group col-md-3">
                                                    <label
                                                        class="form-label"><?php echo e(trans('labels.currency_space')); ?></label>
                                                    <div class="">
                                                        <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                            <input type="radio" class="form-check-input me-0"
                                                                name="currency_space" value="1" id="currency_space1"
                                                                required
                                                                <?php echo e(@$getsettings->currency_space == '1' ? 'checked' : ''); ?>>
                                                            <label for="currency_space1"
                                                                class="form-check-label"><?php echo e(trans('labels.yes')); ?></label>
                                                        </div>
                                                        <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                            <input type="radio" class="form-check-input me-0"
                                                                name="currency_space" value="2" id="currency_space2"
                                                                required
                                                                <?php echo e(@$getsettings->currency_space == '2' ? 'checked' : ''); ?>>
                                                            <label for="currency_space2"
                                                                class="form-check-label"><?php echo e(trans('labels.no')); ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Decimal Number Format -->
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label"><?php echo e(trans('labels.decimal_number_format')); ?></label>
                                                    <input type="text" class="form-control" name="currency_formate"
                                                        value="<?php echo e(@$getsettings->currency_formate); ?>"
                                                        placeholder="<?php echo e(trans('labels.decimal_number_format')); ?>">
                                                </div>
                                                <!-- Decimal Number Separator -->
                                                <div class="form-group col-md-6">
                                                    <label
                                                        class="form-label"><?php echo e(trans('labels.decimal_separator')); ?></label><br>
                                                    <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                        <input class="form-check-input me-0" type="radio"
                                                            name="decimal_separator" id="dot" value="1"
                                                            required
                                                            <?php echo e(@$getsettings->decimal_separator == '1' ? 'checked' : ''); ?>>
                                                        <label for="dot"
                                                            class="form-check-label"><?php echo e(trans('labels.dot')); ?>(.)</label>
                                                    </div>
                                                    <div class="form-check-inline w-100 mb-2 <?php echo e(session()->get('direction') == '2' ? 'd-flex gap-1' : 'form-check'); ?>">
                                                        <input class="form-check-input me-0" type="radio"
                                                            name="decimal_separator" id="comma" value="2"
                                                            required
                                                            <?php echo e(@$getsettings->decimal_separator == '2' ? 'checked' : ''); ?>>
                                                        <label for="comma"
                                                            class="form-check-label"><?php echo e(trans('labels.comma')); ?>(,)</label>
                                                    </div>
                                                </div>
                                                <!-- Time Format -->
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label"><?php echo e(trans('labels.time_format')); ?></label>
                                                    <select class="form-select" name="time_format">
                                                        <option value="2"
                                                            <?php echo e(@$getsettings->time_format == 2 ? 'selected' : ''); ?>>12
                                                            <?php echo e(trans('labels.hour')); ?>

                                                        </option>
                                                        <option value="1"
                                                            <?php echo e(@$getsettings->time_format == 1 ? 'selected' : ''); ?>>24
                                                            <?php echo e(trans('labels.hour')); ?>

                                                        </option>
                                                    </select>
                                                </div>
                                                <!-- Date Format -->
                                                <div class="col-md-6 form-group">
                                                    <label class="form-label"><?php echo e(trans('labels.date_format')); ?></label>
                                                    <select class="form-select" name="date_format">
                                                        <option value="d M, Y"
                                                            <?php echo e(@$getsettings->date_format == 'd M, Y' ? 'selected' : ''); ?>>
                                                            dd MMM, yyyy</option>
                                                        <option value="M d, Y"
                                                            <?php echo e(@$getsettings->date_format == 'M d, Y' ? 'selected' : ''); ?>>
                                                            MMM dd, yyyy</option>
                                                        <option value="d-m-Y"
                                                            <?php echo e(@$getsettings->date_format == 'd-m-Y' ? 'selected' : ''); ?>>
                                                            dd-MM-yyyy</option>
                                                        <option value="m-d-Y"
                                                            <?php echo e(@$getsettings->date_format == 'm-d-Y' ? 'selected' : ''); ?>>
                                                            MM-dd-yyyy</option>
                                                        <option value="d/m/Y"
                                                            <?php echo e(@$getsettings->date_format == 'd/m/Y' ? 'selected' : ''); ?>>
                                                            dd/MM/yyyy</option>
                                                        <option value="m/d/Y"
                                                            <?php echo e(@$getsettings->date_format == 'm/d/Y' ? 'selected' : ''); ?>>
                                                            MM/dd/yyyy</option>
                                                        <option value="Y/m/d"
                                                            <?php echo e(@$getsettings->date_format == 'Y/m/d' ? 'selected' : ''); ?>>
                                                            yyyy/MM/dd</option>
                                                        <option value="Y-m-d"
                                                            <?php echo e(@$getsettings->date_format == 'Y-m-d' ? 'selected' : ''); ?>>
                                                            yyyy-MM-dd</option>
                                                    </select>
                                                </div>
                                                <!-- Referral Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.referral_amount')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.referral_amount')); ?>"
                                                            value="<?php echo e(@$getsettings->referral_amount == '' ? old('referral_amount') : @$getsettings->referral_amount); ?>"
                                                            class="form-control numbers_only" name="referral_amount"
                                                            id="referral_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Max Order Qty -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.max_order_qty')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.max_order_qty')); ?>"
                                                            value="<?php echo e(@$getsettings->max_order_qty == '' ? old('max_order_qty') : @$getsettings->max_order_qty); ?>"
                                                            class="form-control numbers_only" name="max_order_qty"
                                                            id="max_order_qty" required>
                                                    </div>
                                                </div>
                                                <!-- Min Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.min_amount')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.min_amount')); ?>"
                                                            value="<?php echo e(@$getsettings->min_order_amount == '' ? old('min_order_amount') : @$getsettings->min_order_amount); ?>"
                                                            class="form-control numbers_only" name="min_order_amount"
                                                            id="min_order_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Max Amount -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.max_amount')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.max_amount')); ?>"
                                                            value="<?php echo e(@$getsettings->max_order_amount == '' ? old('max_order_amount') : @$getsettings->max_order_amount); ?>"
                                                            class="form-control numbers_only" name="max_order_amount"
                                                            id="max_order_amount" required>
                                                    </div>
                                                </div>
                                                <!-- Maintenance Mode -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.maintenance_mode')); ?>

                                                        </label>
                                                        <input id="maintenance_mode-switch" type="checkbox"
                                                            class="checkbox-switch" name="maintenance_mode"
                                                            value="1"
                                                            <?php echo e($getsettings->maintenance_mode == 1 ? 'checked' : ''); ?>>
                                                        <label for="maintenance_mode-switch" class="switch">
                                                            <span
                                                                class="switch__circle <?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                            <span
                                                                class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <!-- Online Table Booking -->
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.online_table_booking')); ?>

                                                        </label>
                                                        <input id="online_table_booking-switch" type="checkbox"
                                                            class="checkbox-switch" name="online_table_booking"
                                                            value="1"
                                                            <?php echo e($getsettings->online_table_booking == 1 ? 'checked' : ''); ?>>
                                                        <label for="online_table_booking-switch" class="switch">
                                                            <span
                                                                class="switch__circle <?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                                    class="switch__circle-inner"></span></span>
                                                            <span
                                                                class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                            <span
                                                                class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label" for=""><?php echo e(trans('labels.timezone')); ?>

                                                        </label>
                                                        <select class="form-control" name="timezone" id="timezone"
                                                            data-live-search="true">
                                                            <option value="" selected>
                                                                <?php echo e(trans('labels.select')); ?>

                                                            </option>
                                                            <option value="Pacific/Midway" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Midway' ? 'selected' : ''); ?>>
                                                                (GMT-11:00) Midway Island, Samoa</option>
                                                            <option value="America/Adak" <?php echo e(@$getsettings->timezone ==
                                                                'America/Adak' ? 'selected' : ''); ?>>
                                                                (GMT-10:00) Hawaii-Aleutian</option>
                                                            <option value="Etc/GMT+10" <?php echo e(@$getsettings->timezone ==
                                                                'Etc/GMT+10' ? 'selected' : ''); ?>>
                                                                (GMT-10:00) Hawaii</option>
                                                            <option value="Pacific/Marquesas" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Marquesas' ? 'selected' : ''); ?>>
                                                                (GMT-09:30) Marquesas Islands</option>
                                                            <option value="Pacific/Gambier" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Gambier' ? 'selected' : ''); ?>>
                                                                (GMT-09:00) Gambier Islands</option>
                                                            <option value="America/Anchorage" <?php echo e(@$getsettings->timezone ==
                                                                'America/Anchorage' ? 'selected' : ''); ?>>
                                                                (GMT-09:00) Alaska</option>
                                                            <option value="America/Ensenada" <?php echo e(@$getsettings->timezone ==
                                                                'America/Ensenada' ? 'selected' : ''); ?>>
                                                                (GMT-08:00) Tijuana, Baja California</option>
                                                            <option value="Etc/GMT+8" <?php echo e(@$getsettings->timezone == 'Etc/GMT+8'
                                                                ? 'selected' : ''); ?>>
                                                                (GMT-08:00) Pitcairn Islands</option>
                                                            <option value="America/Los_Angeles" <?php echo e(@$getsettings->timezone ==
                                                                'America/Los_Angeles' ? 'selected' : ''); ?>>
                                                                (GMT-08:00) Pacific Time (US & Canada)</option>
                                                            <option value="America/Denver" <?php echo e(@$getsettings->timezone ==
                                                                'America/Denver' ? 'selected' : ''); ?>>
                                                                (GMT-07:00) Mountain Time (US & Canada)</option>
                                                            <option value="America/Chihuahua" <?php echo e(@$getsettings->timezone ==
                                                                'America/Chihuahua' ? 'selected' : ''); ?>>
                                                                (GMT-07:00) Chihuahua, La Paz, Mazatlan</option>
                                                            <option value="America/Dawson_Creek" <?php echo e(@$getsettings->timezone ==
                                                                'America/Dawson_Creek' ? 'selected' : ''); ?>>
                                                                (GMT-07:00) Arizona</option>
                                                            <option value="America/Belize" <?php echo e(@$getsettings->timezone ==
                                                                'America/Belize' ? 'selected' : ''); ?>>
                                                                (GMT-06:00) Saskatchewan, Central America</option>
                                                            <option value="America/Cancun" <?php echo e(@$getsettings->timezone ==
                                                                'America/Cancun' ? 'selected' : ''); ?>>
                                                                (GMT-06:00) Guadalajara, Mexico City, Monterrey</option>
                                                            <option value="Chile/EasterIsland" <?php echo e(@$getsettings->timezone ==
                                                                'Chile/EasterIsland' ? 'selected' : ''); ?>>
                                                                (GMT-06:00) Easter Island</option>
                                                            <option value="America/Chicago" <?php echo e(@$getsettings->timezone ==
                                                                'America/Chicago' ? 'selected' : ''); ?>>
                                                                (GMT-06:00) Central Time (US & Canada)</option>
                                                            <option value="America/New_York" <?php echo e(@$getsettings->timezone ==
                                                                'America/New_York' ? 'selected' : ''); ?>>
                                                                (GMT-05:00) Eastern Time (US & Canada)</option>
                                                            <option value="America/Havana" <?php echo e(@$getsettings->timezone ==
                                                                'America/Havana' ? 'selected' : ''); ?>>
                                                                (GMT-05:00) Cuba</option>
                                                            <option value="America/Bogota" <?php echo e(@$getsettings->timezone ==
                                                                'America/Bogota' ? 'selected' : ''); ?>>
                                                                (GMT-05:00) Bogota, Lima, Quito, Rio Branco</option>
                                                            <option value="America/Caracas" <?php echo e(@$getsettings->timezone ==
                                                                'America/Caracas' ? 'selected' : ''); ?>>
                                                                (GMT-04:30) Caracas</option>
                                                            <option value="America/Santiago" <?php echo e(@$getsettings->timezone ==
                                                                'America/Santiago' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) Santiago</option>
                                                            <option value="America/La_Paz" <?php echo e(@$getsettings->timezone ==
                                                                'America/La_Paz' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) La Paz</option>
                                                            <option value="Atlantic/Stanley" <?php echo e(@$getsettings->timezone ==
                                                                'Atlantic/Stanley' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) Faukland Islands</option>
                                                            <option value="America/Campo_Grande" <?php echo e(@$getsettings->timezone ==
                                                                'America/Campo_Grande' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) Brazil</option>
                                                            <option value="America/Goose_Bay" <?php echo e(@$getsettings->timezone ==
                                                                'America/Goose_Bay' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) Atlantic Time (Goose Bay)</option>
                                                            <option value="America/Glace_Bay" <?php echo e(@$getsettings->timezone ==
                                                                'America/Glace_Bay' ? 'selected' : ''); ?>>
                                                                (GMT-04:00) Atlantic Time (Canada)</option>
                                                            <option value="America/St_Johns" <?php echo e(@$getsettings->timezone ==
                                                                'America/St_Johns' ? 'selected' : ''); ?>>
                                                                (GMT-03:30) Newfoundland</option>
                                                            <option value="America/Araguaina" <?php echo e(@$getsettings->timezone ==
                                                                'America/Araguaina' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) UTC-3</option>
                                                            <option value="America/Montevideo" <?php echo e(@$getsettings->timezone ==
                                                                'America/Montevideo' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) Montevideo</option>
                                                            <option value="America/Miquelon" <?php echo e(@$getsettings->timezone ==
                                                                'America/Miquelon' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) Miquelon, St. Pierre</option>
                                                            <option value="America/Godthab" <?php echo e(@$getsettings->timezone ==
                                                                'America/Godthab' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) Greenland</option>
                                                            <option value="America/Argentina/Buenos_Aires" <?php echo e(@$getsettings->
                                                                timezone == 'America/Argentina/Buenos_Aires' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) Buenos Aires</option>
                                                            <option value="America/Sao_Paulo" <?php echo e(@$getsettings->timezone ==
                                                                'America/Sao_Paulo' ? 'selected' : ''); ?>>
                                                                (GMT-03:00) Brasilia</option>
                                                            <option value="America/Noronha" <?php echo e(@$getsettings->timezone ==
                                                                'America/Noronha' ? 'selected' : ''); ?>>
                                                                (GMT-02:00) Mid-Atlantic</option>
                                                            <option value="Atlantic/Cape_Verde" <?php echo e(@$getsettings->timezone ==
                                                                'Atlantic/Cape_Verde' ? 'selected' : ''); ?>>
                                                                (GMT-01:00) Cape Verde Is.</option>
                                                            <option value="Atlantic/Azores" <?php echo e(@$getsettings->timezone ==
                                                                'Atlantic/Azores' ? 'selected' : ''); ?>>
                                                                (GMT-01:00) Azores</option>
                                                            <option value="Europe/Belfast" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Belfast' ? 'selected' : ''); ?>>
                                                                (GMT) Greenwich Mean Time : Belfast</option>
                                                            <option value="Europe/Dublin" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Dublin' ? 'selected' : ''); ?>>
                                                                (GMT) Greenwich Mean Time : Dublin</option>
                                                            <option value="Europe/Lisbon" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Lisbon' ? 'selected' : ''); ?>>
                                                                (GMT) Greenwich Mean Time : Lisbon</option>
                                                            <option value="Europe/London" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/London' ? 'selected' : ''); ?>>
                                                                (GMT) Greenwich Mean Time : London</option>
                                                            <option value="Africa/Abidjan" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Abidjan' ? 'selected' : ''); ?>>
                                                                (GMT) Monrovia, Reykjavik</option>
                                                            <option value="Europe/Amsterdam" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Amsterdam' ? 'selected' : ''); ?>>
                                                                (GMT+01:00) Amsterdam, Berlin, Bern, Rome, Stockholm, Vienna
                                                            </option>
                                                            <option value="Europe/Belgrade" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Belgrade' ? 'selected' : ''); ?>>
                                                                (GMT+01:00) Belgrade, Bratislava, Budapest, Ljubljana, Prague
                                                            </option>
                                                            <option value="Europe/Brussels" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Brussels' ? 'selected' : ''); ?>>
                                                                (GMT+01:00) Brussels, Copenhagen, Madrid, Paris</option>
                                                            <option value="Africa/Algiers" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Algiers' ? 'selected' : ''); ?>>
                                                                (GMT+01:00) West Central Africa</option>
                                                            <option value="Africa/Windhoek" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Windhoek' ? 'selected' : ''); ?>>
                                                                (GMT+01:00) Windhoek</option>
                                                            <option value="Asia/Beirut" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Beirut' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Beirut</option>
                                                            <option value="Africa/Cairo" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Cairo' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Cairo</option>
                                                            <option value="Asia/Gaza" <?php echo e(@$getsettings->timezone == 'Asia/Gaza'
                                                                ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Gaza</option>
                                                            <option value="Africa/Blantyre" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Blantyre' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Harare, Pretoria</option>
                                                            <option value="Asia/Jerusalem" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Jerusalem' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Jerusalem</option>
                                                            <option value="Europe/Minsk" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Minsk' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Minsk</option>
                                                            <option value="Asia/Damascus" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Damascus' ? 'selected' : ''); ?>>
                                                                (GMT+02:00) Syria</option>
                                                            <option value="Europe/Moscow" <?php echo e(@$getsettings->timezone ==
                                                                'Europe/Moscow' ? 'selected' : ''); ?>>
                                                                (GMT+03:00) Moscow, St. Petersburg, Volgograd</option>
                                                            <option value="Africa/Addis_Ababa" <?php echo e(@$getsettings->timezone ==
                                                                'Africa/Addis_Ababa' ? 'selected' : ''); ?>>
                                                                (GMT+03:00) Nairobi</option>
                                                            <option value="Asia/Tehran" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Tehran' ? 'selected' : ''); ?>>
                                                                (GMT+03:30) Tehran</option>
                                                            <option value="Asia/Dubai" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Dubai' ? 'selected' : ''); ?>>
                                                                (GMT+04:00) Abu Dhabi, Muscat</option>
                                                            <option value="Asia/Yerevan" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Yerevan' ? 'selected' : ''); ?>>
                                                                (GMT+04:00) Yerevan</option>
                                                            <option value="Asia/Kabul" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Kabul' ? 'selected' : ''); ?>>
                                                                (GMT+04:30) Kabul</option>
                                                            <option value="Asia/Yekaterinburg" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Yekaterinburg' ? 'selected' : ''); ?>>
                                                                (GMT+05:00) Ekaterinburg</option>
                                                            <option value="Asia/Tashkent" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Tashkent' ? 'selected' : ''); ?>>
                                                                (GMT+05:00) Tashkent</option>
                                                            <option value="Asia/Kolkata" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Kolkata' ? 'selected' : ''); ?>>
                                                                (GMT+05:30) Chennai, Kolkata, Mumbai, New Delhi</option>
                                                            <option value="Asia/Katmandu" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Katmandu' ? 'selected' : ''); ?>>
                                                                (GMT+05:45) Kathmandu</option>
                                                            <option value="Asia/Dhaka" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Dhaka' ? 'selected' : ''); ?>>
                                                                (GMT+06:00) Astana, Dhaka</option>
                                                            <option value="Asia/Novosibirsk" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Novosibirsk' ? 'selected' : ''); ?>>
                                                                (GMT+06:00) Novosibirsk</option>
                                                            <option value="Asia/Rangoon" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Rangoon' ? 'selected' : ''); ?>>
                                                                (GMT+06:30) Yangon (Rangoon)</option>
                                                            <option value="Asia/Bangkok" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Bangkok' ? 'selected' : ''); ?>>
                                                                (GMT+07:00) Bangkok, Hanoi, Jakarta</option>
                                                            <option value="Asia/Krasnoyarsk" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Krasnoyarsk' ? 'selected' : ''); ?>>
                                                                (GMT+07:00) Krasnoyarsk</option>
                                                            <option value="Asia/Hong_Kong" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Hong_Kong' ? 'selected' : ''); ?>>
                                                                (GMT+08:00) Beijing, Chongqing, Hong Kong, Urumqi</option>
                                                            <option value="Asia/Irkutsk" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Irkutsk' ? 'selected' : ''); ?>>
                                                                (GMT+08:00) Irkutsk, Ulaan Bataar</option>
                                                            <option value="Australia/Perth" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Perth' ? 'selected' : ''); ?>>
                                                                (GMT+08:00) Perth</option>
                                                            <option value="Australia/Eucla" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Eucla' ? 'selected' : ''); ?>>
                                                                (GMT+08:45) Eucla</option>
                                                            <option value="Asia/Tokyo" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Tokyo' ? 'selected' : ''); ?>>
                                                                (GMT+09:00) Osaka, Sapporo, Tokyo</option>
                                                            <option value="Asia/Seoul" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Seoul' ? 'selected' : ''); ?>>
                                                                (GMT+09:00) Seoul</option>
                                                            <option value="Asia/Yakutsk" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Yakutsk' ? 'selected' : ''); ?>>
                                                                (GMT+09:00) Yakutsk</option>
                                                            <option value="Australia/Adelaide" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Adelaide' ? 'selected' : ''); ?>>
                                                                (GMT+09:30) Adelaide</option>
                                                            <option value="Australia/Darwin" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Darwin' ? 'selected' : ''); ?>>
                                                                (GMT+09:30) Darwin</option>
                                                            <option value="Australia/Brisbane" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Brisbane' ? 'selected' : ''); ?>>
                                                                (GMT+10:00) Brisbane</option>
                                                            <option value="Australia/Hobart" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Hobart' ? 'selected' : ''); ?>>
                                                                (GMT+10:00) Hobart</option>
                                                            <option value="Asia/Vladivostok" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Vladivostok' ? 'selected' : ''); ?>>
                                                                (GMT+10:00) Vladivostok</option>
                                                            <option value="Australia/Lord_Howe" <?php echo e(@$getsettings->timezone ==
                                                                'Australia/Lord_Howe' ? 'selected' : ''); ?>>
                                                                (GMT+10:30) Lord Howe Island</option>
                                                            <option value="Etc/GMT-11" <?php echo e(@$getsettings->timezone ==
                                                                'Etc/GMT-11' ? 'selected' : ''); ?>>
                                                                (GMT+11:00) Solomon Is., New Caledonia</option>
                                                            <option value="Asia/Magadan" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Magadan' ? 'selected' : ''); ?>>
                                                                (GMT+11:00) Magadan</option>
                                                            <option value="Pacific/Norfolk" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Norfolk' ? 'selected' : ''); ?>>
                                                                (GMT+11:30) Norfolk Island</option>
                                                            <option value="Asia/Anadyr" <?php echo e(@$getsettings->timezone ==
                                                                'Asia/Anadyr' ? 'selected' : ''); ?>>
                                                                (GMT+12:00) Anadyr, Kamchatka</option>
                                                            <option value="Pacific/Auckland" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Auckland' ? 'selected' : ''); ?>>
                                                                (GMT+12:00) Auckland, Wellington</option>
                                                            <option value="Etc/GMT-12" <?php echo e(@$getsettings->timezone ==
                                                                'Etc/GMT-12' ? 'selected' : ''); ?>>
                                                                (GMT+12:00) Fiji, Kamchatka, Marshall Is.</option>
                                                            <option value="Pacific/Chatham" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Chatham' ? 'selected' : ''); ?>>
                                                                (GMT+12:45) Chatham Islands</option>
                                                            <option value="Pacific/Tongatapu" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Tongatapu' ? 'selected' : ''); ?>>
                                                                (GMT+13:00) Nuku'alofa</option>
                                                            <option value="Pacific/Kiritimati" <?php echo e(@$getsettings->timezone ==
                                                                'Pacific/Kiritimati' ? 'selected' : ''); ?>>
                                                                (GMT+14:00) Kiritimati</option>
                                                        </select>
                                                        <?php $__errorArgs = ['timezone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                        <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <?php if(@helper::checkaddons('customer_login')): ?>
                                                    <div class="col-md-3">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for=""><?php echo e(trans('labels.customer_login_required')); ?>

                                                            </label>
                                                            <input id="login_required-switch" type="checkbox"
                                                                class="checkbox-switch" name="login_required"
                                                                value="1"
                                                                <?php echo e($getsettings->login_required == 1 ? 'checked' : ''); ?>>
                                                            <label for="login_required-switch" class="switch">
                                                                <span
                                                                    class="switch__circle <?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                                <span
                                                                    class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3 <?php echo e($getsettings->login_required == 1 ? '' : 'd-none'); ?>"
                                                        id="is_checkout_login_required">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for=""><?php echo e(trans('labels.is_checkout_login_required')); ?>

                                                            </label>
                                                            <?php if(env('Environment') == 'sendbox'): ?>
                                                                <span
                                                                    class="badge bg-danger"><?php echo e(trans('labels.addon')); ?></span>
                                                            <?php endif; ?>
                                                            <input id="is_checkout_login_required-switch" type="checkbox"
                                                                class="checkbox-switch" name="is_checkout_login_required"
                                                                value="1"
                                                                <?php echo e($getsettings->is_checkout_login_required == 1 ? 'checked' : ''); ?>>
                                                            <label for="is_checkout_login_required-switch" class="switch">
                                                                <span
                                                                    class="switch__circle <?php echo e(session()->get('direction') == 2 ? 'switch__circle-rtl' : 'switch__circle'); ?>"><span
                                                                        class="switch__circle-inner"></span></span>
                                                                <span
                                                                    class="switch__left <?php echo e(session()->get('direction') == 2 ? 'pe-2' : 'ps-2'); ?>"><?php echo e(trans('labels.off')); ?></span>
                                                                <span
                                                                    class="switch__right <?php echo e(session()->get('direction') == 2 ? 'ps-2' : 'pe-2'); ?>"><?php echo e(trans('labels.on')); ?></span>
                                                            </label>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.pickup_delivery')); ?>

                                                        </label>
                                                        <select class="form-control selectpicker" name="pickup_delivery"
                                                            id="pickup_delivery" data-live-search="true">
                                                            <option value="1"
                                                                <?php echo e($getsettings->pickup_delivery == 1 ? 'selected' : ''); ?>>
                                                                <?php echo e(trans('labels.both')); ?></option>
                                                            <option value="2"
                                                                <?php echo e($getsettings->pickup_delivery == 2 ? 'selected' : ''); ?>>
                                                                <?php echo e(trans('labels.delivery')); ?></option>
                                                            <option value="3"
                                                                <?php echo e($getsettings->pickup_delivery == 3 ? 'selected' : ''); ?>>
                                                                <?php echo e(trans('labels.pickup')); ?></option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.order_prefix_number')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text"
                                                            placeholder="<?php echo e(trans('labels.order_prefix_number')); ?>"
                                                            value="<?php echo e(@$getsettings->order_prefix == '' ? old('order_prefix') : @$getsettings->order_prefix); ?>"
                                                            class="form-control" name="order_prefix" id="order_prefix"
                                                            required>
                                                    </div>
                                                </div>
                                                <?php if(count($order) == 0): ?>
                                                    <div class="col-md-4">
                                                        <div class="form-group">
                                                            <label class="col-form-label"
                                                                for=""><?php echo e(trans('labels.order_number_start')); ?>

                                                                <span class="text-danger">*</span></label>
                                                            <input type="text"
                                                                placeholder="<?php echo e(trans('labels.order_number_start')); ?>"
                                                                value="<?php echo e(@$getsettings->order_number_start == '' ? old('order_number_start') : @$getsettings->order_number_start); ?>"
                                                                class="form-control numbers_only"
                                                                name="order_number_start" id="order_number_start"
                                                                required>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="business_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="website_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">

                                            <?php echo e(trans('labels.website_settings')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.title_for_title_bar')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="title"
                                                            id="title"
                                                            value="<?php echo e(@$getsettings->title == '' ? old('title') : @$getsettings->title); ?>"
                                                            placeholder="<?php echo e(trans('labels.title_for_title_bar')); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.short_title')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="short_title"
                                                            id="short_title"
                                                            value="<?php echo e(@$getsettings->short_title == '' ? old('short_title') : @$getsettings->short_title); ?>"
                                                            placeholder="<?php echo e(trans('labels.short_title')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.logo')); ?> (250
                                                            x 250) </label>
                                                        <input type="file" class="form-control" name="logo"
                                                            id="logo">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->logo)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.Favicon')); ?>

                                                            (16 x 16) </label>
                                                        <input type="file" class="form-control" name="favicon"
                                                            id="favicon">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->favicon)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Primary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label"><?php echo e(trans('labels.primary_color')); ?></label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="web_primary_color"
                                                            value="<?php echo e(@$getsettings->web_primary_color); ?>">
                                                    </div>
                                                </div>
                                                <!-- Secondary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label"><?php echo e(trans('labels.secondary_color')); ?></label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="web_secondary_color"
                                                            value="<?php echo e(@$getsettings->web_secondary_color); ?>">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.copyright')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="copyright"
                                                            id="copyright"
                                                            value="<?php echo e(@$getsettings->copyright == '' ? old('copyright') : @$getsettings->copyright); ?>"
                                                            placeholder="<?php echo e(trans('labels.copyright')); ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="web_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="social_links">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.social_links')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label">
                                                            <?php echo e(trans('labels.social_links')); ?>

                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </span>
                                                        </label>
                                                        <?php $__empty_1 = true; $__currentLoopData = $getsociallink; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $sociallink): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <div class="row">
                                                                <input type="hidden" name="edit_icon_key[]"
                                                                    value="<?php echo e($sociallink->id); ?>">
                                                                <div class="col-md-6 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control <?php echo e(session()->get('direction') == '2' ? 'rounded-end rounded-0' : 'rounded-start'); ?>"
                                                                            name="edit_sociallink_icon[<?php echo e($sociallink->id); ?>]"
                                                                            placeholder="<?php echo e(trans('labels.icon')); ?>"
                                                                            value="<?php echo e($sociallink->icon); ?>" required>
                                                                        <p class="input-group-text <?php echo e(session()->get('direction') == '2' ? 'rounded-start rounded-0' : 'rounded-end'); ?>">
                                                                            <?php echo $sociallink->icon; ?>

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div
                                                                    class="col-md-6 form-group d-flex gap-2 align-items-center">
                                                                    <input type="text" class="form-control"
                                                                        name="edit_sociallink_link[<?php echo e($sociallink->id); ?>]"
                                                                        placeholder="<?php echo e(trans('labels.link')); ?>"
                                                                        value="<?php echo e($sociallink->link); ?>" required>
                                                                    <button class="btn btn-danger px-3" type="button"
                                                                        onclick="delete_social_links('<?php echo e(URL::to('admin/settings/delete-social-link-' . $sociallink->id)); ?>')">
                                                                        <i class="fa fa-trash"></i> </button>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <div class="row">
                                                                <div class="col-md-6 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control feature_required"
                                                                            onkeyup="show_feature_icon(this)"
                                                                            name="social_icon[]"
                                                                            placeholder="<?php echo e(trans('labels.icon')); ?>">
                                                                        <p class="input-group-text"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 form-group d-flex align-items-center">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="social_link[]"
                                                                        placeholder="<?php echo e(trans('labels.link')); ?>">
                                                                    <button class="btn btn-secondary mx-2" type="button"
                                                                        onclick="add_social_link('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.link')); ?>')">
                                                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <span class="extra_social_links"></span>
                                                        <?php if(count($getsociallink) > 0): ?>
                                                            <button class="btn btn-secondary" type="button"
                                                                onclick="add_social_link('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.link')); ?>')">
                                                                <i class="fa-sharp fa-solid fa-plus"></i>
                                                                <?php echo e(trans('labels.add_new')); ?> </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="social_link_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="footer_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.footer_settings')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.footer_title')); ?>

                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="<?php echo e(trans('labels.footer_title')); ?>"
                                                        name="footer_title" id="footer_title"
                                                        value="<?php echo e(@$getsettings->footer_title == '' ? old('footer_title') : @$getsettings->footer_title); ?>"
                                                        required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.footer_logo')); ?>

                                                        (250 x 250) </label>
                                                    <input type="file" class="form-control" name="footer_logo"
                                                        id="footer_logo">
                                                    <img src="<?php echo e(helper::image_path(@$getsettings->footer_logo)); ?>"
                                                        class="img-fluid rounded h-50px mt-1">
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.footer_description')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="footer_description" placeholder="<?php echo e(trans('labels.footer_description')); ?>"
                                                            id="footer_description" rows="5" required><?php echo e(@$getsettings->footer_description == '' ? old('footer_description') : @$getsettings->footer_description); ?></textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.footer_features')); ?>

                                                            <span class="" data-bs-toggle="tooltip"
                                                                data-bs-placement="top"
                                                                title="Ex. <i class='fa-solid fa-truck-fast'></i> Visit https://fontawesome.com/ for more info">
                                                                <i class="fa-solid fa-circle-info"></i>
                                                            </span>
                                                        </label>
                                                        <?php $__empty_1 = true; $__currentLoopData = $getfooterfeatures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $features): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                            <div class="row">
                                                                <input type="hidden" name="edit_icon_key[]"
                                                                    value="<?php echo e($features->id); ?>">
                                                                <div class="col-md-4 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text" class="form-control <?php echo e(session()->get('direction') == '2' ? 'rounded-end rounded-0' : 'rounded-start'); ?>"
                                                                            name="edi_feature_icon[<?php echo e($features->id); ?>]"
                                                                            placeholder="<?php echo e(trans('labels.icon')); ?>"
                                                                            value="<?php echo e($features->icon); ?>" required>
                                                                        <p class="input-group-text <?php echo e(session()->get('direction') == '2' ? 'rounded-start rounded-0' : 'rounded-end'); ?>">
                                                                            <?php echo $features->icon; ?>

                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <input type="text" class="form-control"
                                                                        name="edi_feature_title[<?php echo e($features->id); ?>]"
                                                                        placeholder="<?php echo e(trans('labels.title')); ?>"
                                                                        value="<?php echo e($features->title); ?>" required>
                                                                </div>
                                                                <div class="col-md-4 form-group">
                                                                    <div class="d-flex gap-2">
                                                                        <input type="text" class="form-control"
                                                                            name="edi_feature_description[<?php echo e($features->id); ?>]"
                                                                            placeholder="<?php echo e(trans('labels.description')); ?>"
                                                                            value="<?php echo e($features->description); ?>"
                                                                            required>
                                                                        <div>
                                                                            <button class="btn btn-danger px-3"
                                                                                type="button"
                                                                                onclick="delete_features('<?php echo e(URL::to('admin/settings/delete-feature-' . $features->id)); ?>')">
                                                                                <i class="fa fa-trash"></i> </button>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                            <div class="row">
                                                                <div class="col-md-3 form-group">
                                                                    <div class="input-group">
                                                                        <input type="text"
                                                                            class="form-control feature_required"
                                                                            onkeyup="show_feature_icon(this)"
                                                                            name="feature_icon[]"
                                                                            placeholder="<?php echo e(trans('labels.icon')); ?>">
                                                                        <p class="input-group-text"></p>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-3 form-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="feature_title[]"
                                                                        placeholder="<?php echo e(trans('labels.title')); ?>">
                                                                </div>
                                                                <div class="col-md-5 form-group">
                                                                    <input type="text"
                                                                        class="form-control feature_required"
                                                                        name="feature_description[]"
                                                                        placeholder="<?php echo e(trans('labels.description')); ?>">
                                                                </div>
                                                                <div class="col-md-1 form-group">
                                                                    <button class="btn btn-secondary" type="button"
                                                                        onclick="add_features('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.title')); ?>','<?php echo e(trans('labels.description')); ?>')">
                                                                        <i class="fa-sharp fa-solid fa-plus"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        <?php endif; ?>
                                                        <span class="extra_footer_features"></span>
                                                        <?php if(count($getfooterfeatures) > 0): ?>
                                                            <button class="btn btn-secondary" type="button"
                                                                onclick="add_features('<?php echo e(trans('labels.icon')); ?>','<?php echo e(trans('labels.title')); ?>','<?php echo e(trans('labels.description')); ?>')">
                                                                <i class="fa-sharp fa-solid fa-plus"></i>
                                                                <?php echo e(trans('labels.add_new')); ?> </button>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="footer_settings_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="mobile_settings">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.mobile_app_settings')); ?>

                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.ios_app_link')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="ios"
                                                            id="ios"
                                                            value="<?php echo e(@$getsettings->ios == '' ? old('ios') : @$getsettings->ios); ?>"
                                                            placeholder="<?php echo e(trans('labels.ios_app_link')); ?>" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.android_app_link')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" name="android"
                                                            id="android"
                                                            value="<?php echo e(@$getsettings->android == '' ? old('android') : @$getsettings->android); ?>"
                                                            placeholder="<?php echo e(trans('labels.android_app_link')); ?>"
                                                            required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.app_bottom_image')); ?>

                                                        </label>
                                                        <input type="file" class="form-control"
                                                            name="app_bottom_image" id="app_bottom_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->app_bottom_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.mobile_app_title')); ?>

                                                        <span class="text-danger">*</span></label>
                                                    <input type="text" class="form-control"
                                                        placeholder="<?php echo e(trans('labels.mobile_app_title')); ?>"
                                                        name="mobile_app_title" id="mobile_app_title" required
                                                        value="<?php echo e(@$getsettings->mobile_app_title == '' ? old('mobile_app_title') : @$getsettings->mobile_app_title); ?>">
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="col-form-label"
                                                        for=""><?php echo e(trans('labels.mobile_app_image')); ?>

                                                    </label>
                                                    <input type="file" class="form-control" name="mobile_app_image"
                                                        id="mobile_app_image">
                                                    <img src="<?php echo e(helper::image_path(@$getsettings->mobile_app_image)); ?>"
                                                        class="img-fluid rounded h-50px mt-1">
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.mobile_app_description')); ?>

                                                            <span class="text-danger">*</span></label>
                                                        <textarea class="form-control" name="mobile_app_description"
                                                            placeholder="<?php echo e(trans('labels.mobile_app_description')); ?>" required id="mobile_app_description"
                                                            rows="5"><?php echo e(@$getsettings->mobile_app_description == '' ? old('mobile_app_description') : @$getsettings->mobile_app_description); ?></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="mobileapp_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(@helper::checkaddons('pwa')): ?>
                        <?php echo $__env->make('admin.pwa.pwa_settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('email_settings')): ?>
                        <?php echo $__env->make('admin.email_settings.email_settings', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('recaptcha')): ?>
                        <?php echo $__env->make('admin.google_recaptcha.recaptcha', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <?php if(@helper::checkaddons('google_login')): ?>
                        <?php echo $__env->make('admin.sociallogin.google_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('facebook_login')): ?>
                        <?php echo $__env->make('admin.sociallogin.facebook_login', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('pixel')): ?>
                        <?php echo $__env->make('admin.pixel.pixel_setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <?php if(@helper::checkaddons('product_review')): ?>
                        <?php echo $__env->make('admin.reviews.review_setting', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <div id="admin_setting">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white"><?php echo e(trans('labels.admin_setting')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <!-- Primary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label"><?php echo e(trans('labels.primary_color')); ?></label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="admin_primary_color"
                                                            value="<?php echo e(@$getsettings->admin_primary_color); ?>">
                                                        <?php $__errorArgs = ['admin_primary_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                                <!-- Secondary Color -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label"><?php echo e(trans('labels.secondary_color')); ?></label>
                                                        <input type="color"
                                                            class="form-control form-control-color w-100 border-0"
                                                            name="admin_secondary_color"
                                                            value="<?php echo e(@$getsettings->admin_secondary_color); ?>">
                                                        <?php $__errorArgs = ['admin_secondary_color'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                                            <span class="text-danger"><?php echo e($message); ?></span>
                                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="admin_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <?php if(@helper::checkaddons('tawk_addons')): ?>
                    <?php echo $__env->make('admin.tawk_settings.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('wizz_chat')): ?>
                    <?php echo $__env->make('admin.wizz_chat_settings.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('age_verification')): ?>
                    <?php echo $__env->make('admin.age_verification.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('quick_call')): ?>
                    <?php echo $__env->make('admin.quick_call.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('sales_notification')): ?>
                    <?php echo $__env->make('admin.fake_sales_notification.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>
                    <?php if(@helper::checkaddons('fake_view')): ?>
                    <?php echo $__env->make('admin.product_fake_view.index', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php endif; ?>

                    <div id="other">
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card border-0 box-shadow">
                                    <div class="card-header p-3 bg-secondary">
                                        <h5 class="text-white">
                                            <?php echo e(trans('labels.other')); ?></h5>
                                    </div>
                                    <div class="card-body">
                                        <form action="<?php echo e(URL::to('admin/settings/update')); ?>" method="post"
                                            enctype="multipart/form-data">
                                            <?php echo csrf_field(); ?>
                                            <div class="row">
                                                <!-- Google Review URL -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label
                                                            class="col-form-label"><?php echo e(trans('labels.google_review_url')); ?></label>
                                                        <input type="text" class="form-control"
                                                            name="google_review_url"
                                                            placeholder="<?php echo e(trans('labels.google_review_url')); ?>"
                                                            value="<?php echo e(@$getsettings->google_review_url); ?>">
                                                    </div>
                                                </div>
                                                <!-- FAQs Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.faqs_image')); ?>

                                                        </label>
                                                        <input type="file" class="form-control" name="faqs_image"
                                                            id="faqs_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->faqs_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Auth Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.auth_bg_image')); ?></label>
                                                        <input type="file" class="form-control"
                                                            name="auth_bg_image" id="auth_bg_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->auth_bg_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Table Booking Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.booknow_bg_image')); ?></label>
                                                        <input type="file" class="form-control"
                                                            name="booknow_bg_image" id="booknow_bg_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->booknow_bg_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Refer & Earn Bg Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.refer_earn_bg_image')); ?></label>
                                                        <input type="file" class="form-control"
                                                            name="refer_earn_bg_image" id="refer_earn_bg_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->refer_earn_bg_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- Subscribe Newsletter Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.subscribe_newsletter_image')); ?></label>
                                                        <input type="file" class="form-control"
                                                            name="subscribe_newsletter_image"
                                                            id="subscribe_newsletter_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->subscribe_newsletter_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                                <!-- No Data Image -->
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="col-form-label"
                                                            for=""><?php echo e(trans('labels.no_data_image')); ?></label>
                                                        <input type="file" class="form-control"
                                                            name="no_data_image" id="no_data_image">
                                                        <img src="<?php echo e(helper::image_path(@$getsettings->no_data_image)); ?>"
                                                            class="img-fluid rounded h-50px mt-1">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div
                                                    class="form-group <?php echo e(session()->get('direction') == '2' ? 'text-start' : 'text-end'); ?>">
                                                    <button class="btn btn-primary"
                                                        <?php if(env('Environment') == 'sendbox'): ?> type="button" onclick="myFunction()" <?php else: ?> type="submit" name="other_update" value="1" <?php endif; ?>><?php echo e(trans('labels.save')); ?></button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>
    <script src="<?php echo e(url(env('ASSETSPATHURL') . 'admin-assets/assets/js/custom/settings.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.theme.default', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\Usama yasin\PhpstormProjects\foodefy-93nulled\codecanyon-28563040-single-restaurant-food-ordering-website-and-delivery-boy-app-with-admin-panel\foodefy\resources\views/admin/cms/settings.blade.php ENDPATH**/ ?>