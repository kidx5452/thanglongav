<div class="row">
    <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
    <header class="panel-heading">
        {{ labelkey['reportpupil.lbl_skilltest'] }} <a href="/reportpupil/index?id={{ _GET['userid'] }}"><strong class="text-danger">{{ userinfo.username }}</strong></a>
    </header>
    <form action="" method="post" class="form-horizontal">
        <div class="form_content">
            {{ form_html }}
        </div>
        <div class="col-md-6"><a href="javascript:void(0)" class="btn btn-small btn-success addmoretemplate">{{ labelkey['general.btn_addnew'] }}</a></div>

        <div class="form-group col-md-12 text-center">
            <button type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button>
        </div>


    </form>
</div>
<script>
    $('.addmoretemplate').click(function () {
        $.get('{{ url('/reportpupil/gettemplate') }}', {type: 'skilltest'}, function (re) {
            $('.form_content').append(re);
        })
    })
</script>