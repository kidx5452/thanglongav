<link href="/backend_res/js/summernote/dist/summernote.css" rel="stylesheet">
<section>
    <div class="section-header">
        <ol class="breadcrumb">
            <li class="active">Cấu hình thông tin mặc định</li>
        </ol>

    </div>
    <div class="section-body contain-lg">
        <!-- BEGIN INTRO -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="text-primary">Thông tin</h1>
            </div><!--end .col -->
            <div class="col-lg-8">
                <article class="margin-bottom-xxl">
                    <p class="lead">
                        Dữ liệu này sẽ được hiển thị lên phía client. Hãy chắc chắn những dữ liệu này là chính xác
                    </p>
                </article>
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END INTRO -->

        <!-- BEGIN BASIC ELEMENTS -->
        <div class="row">
            <div class="col-lg-offset-1 col-md-8 col-sm-6">
                <div class="card">
                    <div class="card-body">
                        <form class="form" action="" method="post">
                            <div class="form-group">
                                <label for="">Link Facebook</label>
                                <input type="text" class="form-control" name="facebook" placeholder="Facebook" value="{{ configs['facebook']['contents'] }}">
                            </div>
                            <div class="form-group">
                                <label for="">Link Youtube</label>
                                <input type="text" class="form-control" name="youtube" placeholder="Youtube Channel" value="{{ configs['youtube']['contents'] }}">
                            </div>
                            <div class="form-group">
                                <label for="">Link Google</label>
                                <input type="text" class="form-control" name="google" placeholder="Google" value="{{ configs['google']['contents'] }}">
                            </div>
                            <div class="form-group">
                                <label for="">Hotline</label>
                                <input type="text" class="form-control" name="hotline" placeholder="hotline" value="{{ configs['hotline']['contents'] }}">
                            </div>
                            <div class="form-group">
                                <label for="">Email</label>
                                <input type="text" class="form-control" name="email" placeholder="email" value="{{ configs['email']['contents'] }}">
                            </div>
                            <div class="form-group">
                                <label for="">Làm việc với TLAV</label>
                                <textarea class="form_editor" id="summernote" name="work">{{ configs['work']['contents'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="">Footer</label>
                                <textarea class="form-control" name="footer">{{ configs['footer']['contents'] }}</textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </form>
                    </div><!--end .card-body -->
                </div><!--end .card -->
            </div><!--end .col -->
        </div><!--end .row -->
        <!-- END BASIC ELEMENTS -->


    </div><!--end .section-body -->
</section>
<script src="/backend_res/js/summernote/dist/summernote.min.js"></script>
<script>
    jQuery(document).ready(function () {
        loadTinyMce('form_editor');
    });

</script>