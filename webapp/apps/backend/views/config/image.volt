<div class="row">
    <div class="col-md-12">
        <section class="panel">
            <header class="panel-heading">{{ labelkey['config.lbl_defaultimageconfig'] }}</header>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="panel-body">
                        <div class="col-md-12">
                            <div class="form-group text-center text-danger">{{ labelkey['config.lbl_imagenotice'] }}</div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_fbthumb'] }} (500x262)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/fb-thumb.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/fb-thumb.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_fbthumb'] }}"></a></p>
                                    <input id="fbthumb" class="file" type="file" name="fbthumb" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_articlecover'] }} (1600x333)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/article-cover.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/article-cover.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_articlecover'] }}"></a></p>
                                    <input id="articlecover" class="file" type="file" name="articlecover" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_categorycover'] }} (1600x333)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/category-cover.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/category-cover.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_categorycover'] }}"></a></p>
                                    <input id="categorycover" class="file" type="file" name="categorycover" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_dashboardcover'] }} (1600x333)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/dashboard-cover.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/dashboard-cover.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_dashboardcover'] }}"></a></p>
                                    <input id="dashboardcover" class="file" type="file" name="dashboardcover" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_eventcover'] }} (1600x333)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/event-cover.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/event-cover.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_eventcover'] }}"></a></p>
                                    <input id="eventcover" class="file" type="file" name="eventcover" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['config.lbl_searchcover'] }} (1600x333)</label>
                                <div class="col-md-8">
                                    <p class="clearfix"><a href="{{ media.host }}uploads/default-image/search-cover.jpg?{{ time() }}" target="_blank"><img width="250" src="{{ media.host }}uploads/default-image/search-cover.jpg?{{ time() }}" alt="{{ labelkey['config.lbl_searchcover'] }}"></a></p>
                                    <input id="searchcover" class="file" type="file" name="searchcover" accept="image/*">
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-2 control-label"></label>
                                <div class="col-md-8">
                                    <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </div>
</div>