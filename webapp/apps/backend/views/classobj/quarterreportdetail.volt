<style>
    .table td, .table th{border: 0 !important;}
</style>
<div class="row">
    <div class="col-sm-12">
        <a href="editquarterreport?id={{ _GET['id'] }}&classid={{ _GET['classid'] }}" class="btn btn-sm btn-success addon-btn m-b-10"><i
                    class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading head-border">
                {{ labelkey['classobj.lbl_editquarterreport'] }} <b>{{ object.firstname~' '~object.lastname }}</b>
            </header>
            <div class="panel-body">
                <form action="" method="post" class="form-horizontal">
                    <div class="col-md-12">{{ htmlx }}</div>
                </form>
            </div>
        </section>
    </div>
</div>