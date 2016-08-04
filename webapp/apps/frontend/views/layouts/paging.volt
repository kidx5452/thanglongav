{% if painginfo['rowcount'] > 0 %}
<ul class="page pageA pageA06">
    <li><a href="{{ painginfo['currentlink'] }}&p={{ painginfo['page']-1<=1?1:painginfo['page']-1 }}">« Trang trước</a></li>
    {% for index,item in painginfo['rangepage'] %}
        <li><a  class="{{ item==painginfo['page']?"current":"" }}" href="{{ painginfo['currentlink'] }}&p={{ item }}">{{ item }}</a></li>
    {% endfor %}
    <li><a href="{{ painginfo['currentlink'] }}&p={{ painginfo['page']+1>=painginfo['totalpage']?painginfo['totalpage']:painginfo['page']+1 }}">Trang sau »</a></li>
</ul>
{% endif %}
