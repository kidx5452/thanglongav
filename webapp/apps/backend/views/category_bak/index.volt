<!--jsTree-->
<link rel="stylesheet" type="text/css" href="/backend_res/js/jstree/themes/default/style.min.css"/>
<style>
    #jstree .label{vertical-align: 1px;}
</style>

<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading head-border">{{ labelkey['category.lbl_list'] }}</div>
            <div class="panel-body">
                <form method="get" action="" class="form-horizontal">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_lang'] }}</label>
                        <div class="col-md-8">
                            <select id="langSelect" name="lang" class="form-control" onchange="this.form.submit();">
                                {% for item in langlist %}
                                    <option {{ _GET['lang']==item['key']?'selected':'' }} value="{{ item['key'] }}">{{ item['name'] }}</option>
                                {% endfor %}
                            </select>
                        </div>
                    </div>
                </form>

                <form method="get" action="" class="form-horizontal tasi-form">
                    <div class="form-group">
                        <label class="col-md-2 control-label">{{ labelkey['category.lbl_category'] }}</label>
                        <div class="col-md-8">
                            <div>
                                <a href="form" id="add-btn" class="btn btn-success m-b-10">{{ labelkey['general.btn_addnew'] }}</a>
                                <a href="javascript:void(0);" onclick="nodeAction('edit');" class="btn btn-info m-b-10 action-btn" disabled="">{{ labelkey['general.btn_edit'] }}</a>
                                <a href="javascript:void(0);" onclick="nodeAction('delete');" class="btn btn-danger m-b-10 action-btn" disabled="">{{ labelkey['general.btn_delete'] }}</a>
                            </div>
                            <div>
                                <div id="jstree">{{ cattree }}</div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="/backend_res/js/jstree/jstree.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        $('#jstree').jstree();

        $('#jstree').on('select_node.jstree', function (e, data) {
            $('.action-btn').removeAttr('disabled');
            var selectedNode = $('#jstree').jstree(true).get_selected('full', true);
            $('#add-btn').attr('href','{{ url('/category/form?parentid=') }}'+selectedNode[0].id);
        }).jstree();

    });

    function nodeAction(type) {
        var selectedNode = $('#jstree').jstree(true).get_selected('full', true);
        var id = selectedNode[0].id;
        if (id) {
            switch (type) {
                case 'edit':
                    window.location = '{{ url('/category/form?id=') }}' + id + '&back=1';
                    break;
                case 'delete':
                    if (confirm('{{ labelkey['general.lbl_sure'] }}')) window.location = '{{ url('/category/delete?id=') }}' + id;
                    break;
            }
        }

    }
</script>