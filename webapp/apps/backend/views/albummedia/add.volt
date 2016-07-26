<div class="row">
    <div class="col-md-12">
        <a href="{{ backurl }}" class="btn btn-sm btn-success addon-btn m-b-10"><i class="zmdi zmdi-arrow-left"></i> {{ labelkey['general.lbl_back'] }}</a>
        <section class="panel">
            <header class="panel-heading">{{ object.type == 'photo'? labelkey['album.lbl_addphoto'] : labelkey['album.lbl_addvideo'] }} <strong>{{ object.name }}</strong></header>
            <div class="panel-body">
                <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                    <div class="panel-body">
                        <div class="col-md-12">
                            {% if object.type == 'photo' %}
                            <div class="form-group"><div class="alert alert-info text-center">{{ labelkey['album.lbl_uploadnotice'] }}</div></div>
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['album.lbl_selectphoto'] }}</label>
                                <div class="col-md-8">
                                    <input id="photos" type="file" name="photos[]" accept="image/*" multiple>
                                </div>
                            </div>
                            {% else %}
                            <div class="form-group">
                                <label class="col-md-2 control-label">{{ labelkey['album.lbl_entervidnum'] }}</label>
                                <div class="col-md-8">
                                    <input id="vidNumber" type="number" min="1" class="form-control no-label" />
                                </div>
                                <div class="col-md-2">
                                    <a href="javascript:void(0);" class="btn btn-info" onclick="addNewVid();">{{ labelkey['general.btn_addnew'] }}</a>
                                </div>
                            </div>
                             <div id="add-vid-list">
                                 <div class="form-group" id="save-btn" style="display: none">
                                     <div class="col-md-5 col-md-offset-5"><button onclick="return confirm('{{ labelkey['general.lbl_sure'] }}');" type="submit" class="btn btn-info">{{ labelkey['general.btn_save'] }}</button></div>
                                 </div>
                             </div>
                            {% endif %}
                        </div>
                    </div>
                </form>
            </div>
        </section>

        <section class="panel">
            <header class="panel-heading">{{ object.type == 'photo' ? labelkey['album.lbl_listphoto'] : labelkey['album.lbl_listvideo'] }}</header>
            <div class="panel-body">
                <div class="panel-body">
                    <div class="col-md-12">
                        {% if object.type == 'photo' %}
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ labelkey['album.lbl_thumb'] }}</th>
                                    <th>{{ labelkey['album.lbl_status'] }}</th>
                                    <th>{{ labelkey['general.lbl_action'] }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for item in listdata %}
                                    <tr id="media{{ item.id }}">
                                        <td>{{ item.id }}</td>
                                        <td><a target="_blank" href="{{ host~item.content }}"><img width="200" src="{{ host~item.avatar }}" alt="Thumb" /></a></td>
                                        <td><strong class="mediaStatus">{{ item.status==1?'<span class="label label-success">Show</span>':'<span class="label label-inverse">Hide</span>' }}</strong></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-default" onclick="editMedia({{ item.id }},'{{ object.type }}');" title="{{ labelkey['general.btn_edit'] }}" href="javascript:void(0);"><i class="zmdi zmdi-edit"></i></a>
                                                <a class="btn btn-default" onclick="deleteMedia({{ item.id }},'{{ object.type }}');" title="{{ labelkey['general.btn_delete'] }}" href="javascript:void(0);"><i class="zmdi zmdi-delete"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                {% endfor %}

                                </tbody>
                            </table>
                            {% include "layouts/paging.volt" %}
                        {% else %}
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>#</th>
                                    <th>{{ labelkey['album.lbl_name'] }}</th>
                                    <th>{{ labelkey['album.lbl_link'] }}</th>
                                    <th>{{ labelkey['album.lbl_status'] }}</th>
                                    <th>{{ labelkey['general.lbl_action'] }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                {% for item in listdata %}
                                    <tr id="media{{ item.id }}">
                                        <td>{{ item.id }}</td>
                                        <td class="mediaName">{{ item.name }}</td>
                                        <td class="mediaContent"><a target="_blank" href="{{ item.content }}">{{ item.content }}</a></td>
                                        <td><strong class="mediaStatus">{{ item.status==1?'<span class="label label-success">Show</span>':'<span class="label label-inverse">Hide</span>' }}</strong></td>
                                        <td>
                                            <div class="btn-group" role="group">
                                                <a class="btn btn-default" onclick="editMedia({{ item.id }},'{{ object.type }}');" title="{{ labelkey['general.btn_edit'] }}" href="javascript:void(0);"><i class="zmdi zmdi-edit"></i></a>
                                                <a class="btn btn-default" onclick="deleteMedia({{ item.id }},'{{ object.type }}');" title="{{ labelkey['general.btn_delete'] }}" href="javascript:void(0);"><i class="zmdi zmdi-delete"></i></a>
                                            </div>
                                        </td>
                                    </tr>
                                {% endfor %}

                                </tbody>
                            </table>
                            {% include "layouts/paging.volt" %}
                        {% endif %}
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">{{ object.type == 'photo' ? labelkey['album.lbl_editphoto'] : labelkey['album.lbl_editvideo'] }}</h4>
            </div>
            <div class="modal-body"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
    {% if object.type == 'photo' %}
    $(document).on("ready", function() {
        $("#photos").fileinput({
            uploadAsync: false,
            maxFileSize: 5120,
            uploadUrl: "{{ url('/albummedia/uploadphoto') }}",
            uploadExtraData: function() {
                return { albumid: {{ object.id }} };
            }
        });
    });
    {% endif %}

    function addNewVid(){
        var vidNumber = $('#vidNumber').val();
        if(vidNumber < 1 || vidNumber > 50) { alert('{{ labelkey['album.lbl_inputnumfail'] }}'); return false; }
        for(i = 1; i<=vidNumber; i++) $('#add-vid-list').append('<div class="form-group"><div class="col-md-5"><input type="text" class="form-control no-label" name="name[]" placeholder="{{ labelkey['album.lbl_name'] }}" required /></div><div class="col-md-5"><input type="url" class="form-control no-label" name="link[]" placeholder="{{ labelkey['album.lbl_link'] }} (Youtube, Vimeo)" required /></div><div class="col-md-2"><a class="btn btn-danger" href="javascript:void();" onclick="$(this).parent().parent().remove();"><i class="zmdi zmdi-close"></i></a></div></div>');
        $('#save-btn').show();
    }

    function saveMedia(id,type){
        $('#loading').show();
        $.ajax({
            type: "POST",
            url: '{{ url('/albummedia/savemediainfo') }}',
            data: {id: id, type: type, name: $('#ajaxName').val(), content: $('#ajaxContent').val(), status: $('#ajaxStatus').val()},
            dataType: "json",
            success: function (result) {
                if(result.error==0){
                    $('#media'+id+' .mediaName').html(result.data.name);
                    if(type=='video') $('#media'+id+' .mediaContent').html('<a target="_blank" href="'+result.data.content+'">'+result.data.content+'</a>');
                    var mediaStt = result.data.status == 1 ? '<span class="label label-success">Show</span>':'<span class="label label-inverse">Hide</span>';
                    $('#media'+id+' .mediaStatus').html(mediaStt);
                }
                else alert(result.msg);
                $('#myModal').modal('hide');
                $('#loading').hide();
            }
        });
    }

    function editMedia(id,type){
        $('#loading').show();
        $.ajax({
            type: "POST",
            url: '{{ url('/albummedia/getmediainfo') }}',
            data: {id: id},
            dataType: "json",
            success: function (result) {
                var selectedStt = result.data.status == 1 ? 'selected' : '';
                var htmlx = '';
                var mediaTitle = result.data.name ? result.data.name : '';
                htmlx += '<div class="form-group"><input type="text" class="form-control" id="ajaxName" value="'+mediaTitle+'" placeholder="{{ labelkey['album.lbl_name'] }}" /></div>';
                if(type=='video') htmlx += '<div class="form-group"><input type="text" class="form-control" id="ajaxContent" value="'+result.data.content+'" placeholder="{{ labelkey['album.lbl_link'] }}" /></div>';
                if(type=='photo') htmlx += '<div class="form-group text-center"><a href="{{ host }}'+result.data.content+'" target="_blank"><img src="{{ host }}'+result.data.avatar+'" width="200" alt="Thumb" /></a></div>';
                htmlx += '<div class="form-group"><select id="ajaxStatus" class="form-control"><option value="0">{{ labelkey['general.lbl_hide'] }}</option><option '+selectedStt+' value="1">{{ labelkey['general.lbl_show'] }}</option></select></div>';
                htmlx += '<div class="text-center"><button class="btn btn-info" onclick="saveMedia('+id+',\''+type+'\')">{{ labelkey['general.btn_save'] }}</button></div>';
                $('#myModal .modal-body').html(htmlx);
                $('#myModal').modal('show');
                $('#loading').hide();
            }
        });
    }

    function deleteMedia(id,type){
        if (confirm("{{ labelkey['general.lbl_sure'] }}")) {
            $.ajax({
                type: "POST",
                url: '{{ url('/albummedia/ajaxdelete') }}',
                data: {id: id, type: type},
                dataType: "json",
                success: function (result) {
                    if (result.error == 0) {
                        $('#media' + id).fadeOut('300');
                    } else {
                        alert(result.msg);
                    }
                }
            });
        }
    }
</script>