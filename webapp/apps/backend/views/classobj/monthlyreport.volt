<div class="row">
    <div class="col-lg-12">
        <a href="index" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <!--tab nav start-->
        <section class="isolate-tabs">
            <ul class="nav nav-tabs">
                <li{{ activetab=='skilltest' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#skilltest">Skill Test</a>
                </li>
                <li{{ activetab=='oraltest' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#oraltest">Oral Test</a>
                </li>
                <li{{ activetab=='presentation' ? ' class="active"' : '' }}>
                    <a data-toggle="tab" href="#presentation">Presentation</a>
                </li>
            </ul>
            <div class="panel-body">
                <div class="tab-content">
                    <div id="skilltest" class="tab-pane{{ activetab=='skilltest' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewmonthlyreport?classid={{ _GET['classid'] }}&type=skilltest">{{ labelkey['reportpupil.lbl_viewenteredmonth']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label>1. <a href="genexcelmonthly?obj=skilltest&classid={{ classobj.id }}">Download Skill Test file excel</a></label>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-2 control-label">2. Upload File</label>
                                    <div class="col-md-10">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <button type="submit" name="action" value="skilltest" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="oraltest" class="tab-pane{{ activetab=='oraltest' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewmonthlyreport?classid={{ _GET['classid'] }}&type=oraltest">{{ labelkey['reportpupil.lbl_viewenteredmonth']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label>1. <a href="genexcelmonthly?obj=oraltest&classid={{ classobj.id }}">Download Oral Test file excel</a></label>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-2 control-label">2. Upload File</label>
                                    <div class="col-md-10">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="action_area">
                                        <button type="submit" name="action" value="oraltest" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="presentation" class="tab-pane{{ activetab=='presentation' ? ' active' : '' }}">
                        <p class="text-center"><a class="btn btn-primary" href="viewmonthlyreport?classid={{ _GET['classid'] }}&type=presentation">{{ labelkey['reportpupil.lbl_viewenteredmonth']~' ('~labelkey['classobj.lbl_form']~' '~classobj.name~')' }}</a></p>
                        <form action="" method="post" enctype="multipart/form-data">
                            <div class="col-md-12">
                                <div class="form-group col-md-12">
                                    <label>1. <a href="genexcelmonthly?obj=presentation&classid={{ classobj.id }}">Download Presentation file excel</a></label>
                                </div>
                                <div class="form-group col-md-12 row">
                                    <label class="col-md-2 control-label">2. Upload File</label>
                                    <div class="col-md-10">
                                        <input type="file" name="file">
                                    </div>
                                </div>
                                <div class="form-group col-md-12">
                                    <div class="action_area">
                                        <button type="submit" name="action" value="presentation" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </section>
        <!--tab nav start-->

    </div>
</div>
