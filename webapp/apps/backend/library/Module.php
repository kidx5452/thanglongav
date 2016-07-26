<?php
namespace Webapp\Backend\Utility;
class Module
{
    public static function Permission()
    {
        $permission["loginsystem"] = array("name" => "Đăng nhập hệ thống");
        $permission["news"] = array("name" => "Tin tức", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Cập nhật trạng thái bài viết", "key" => "updatestatus"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["albummedia"] = array("name" => "Album", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["category"] = array("name" => "Chuyên mục", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));

        $permission["rolegroup"] = array("name" => "Nhóm quyền", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));

        $permission["user"] = array("name" => "User", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete"),
            array("name" => "Thay đổi nhóm quyền", "key" => "role")
        ));
        $permission["categoryview"] = array("name" => "Hiển thị chuyên mục", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["articleview"] = array("name" => "Hiển thị bài viết", "child" => array(
                array("name" => "Xem danh sách", "key" => "view"),
                array("name" => "Thêm mới", "key" => "add"),
                array("name" => "Sửa", "key" => "update"),
                array("name" => "Xóa", "key" => "delete")
        ));
        $permission["config"] = array("name" => "Cấu hình hệ thống", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["classobj"] = array("name" => "Quản lý lớp học", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["pupil"] = array("name" => "Quản lý học sinh", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete"),
            array("name" => "Quản lý báo cáo", "key" => "report"),
            array("name" => "Cập nhật trạng thái báo cáo", "key" => "reportupdatestatus"),
            array("name" => "Quản lý thông báo", "key" => "notify"),
        ));
        $permission["teacher"] = array("name" => "Quản lý giáo viên", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["rprequestlog"] = array("name" => "Xem lịch sử truy cập", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["timetable"] = array("name" => "Thời khóa biểu", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["tuition"] = array("name" => "Học phí", "child" => array(
            array("name" => "Xem danh sách", "key" => "view"),
            array("name" => "Thêm mới", "key" => "add"),
            array("name" => "Sửa", "key" => "update"),
            array("name" => "Xóa", "key" => "delete")
        ));
        $permission["event"] = array("name" => "Sự kiện", "child" => array(
                array("name" => "Xem danh sách", "key" => "view"),
                array("name" => "Thêm mới", "key" => "add"),
                array("name" => "Sửa", "key" => "update"),
                array("name" => "Xóa", "key" => "delete")
        ));
        $permission["userpostition"] = array("name" => "Quá trình học tập", "child" => array(
                array("name" => "Xem danh sách", "key" => "view"),
                array("name" => "Thêm mới", "key" => "add"),
                array("name" => "Sửa", "key" => "update"),
                array("name" => "Xóa", "key" => "delete")
        ));
        return $permission;
    }

    public static function Sidebar($langarr)
    {
        $sidebar[] = array("name" => $langarr['sidebar.home'], "icon" => "zmdi zmdi-home", "key" => "loginsystem", "controller" => "/backend/index/index");
        $sidebar[] = array("name" => $langarr['sidebar.article'], "icon" => "zmdi zmdi-file-text", "key" => "news", "controller" => "/backend/article/index");
        $sidebar[] = array("name" => $langarr['sidebar.album'], "icon" => "zmdi zmdi-collection-image", "key" => "albummedia", "controller" => "/backend/albummedia/index");
        $sidebar[] = array("name" => $langarr['sidebar.category'], "icon" => "zmdi zmdi-folder", "key" => "category", "controller" => "/backend/category/index");
        $sidebar[] = array("name" => $langarr['sidebar.event'], "icon" => "zmdi zmdi-flag", "key" => "event", "controller" => "/backend/event/index");
        $sidebar[] = array("name" => $langarr['sidebar.study'], "icon" => "zmdi zmdi-library", "key" => "classobj,pupil,teacher", "controller" => "javascript:void(0)", "child" => array(
                array("name" => $langarr['sidebar.classobj'], "key" => "classobj", "controller" => "/backend/classobj/index"),
                array("name" => $langarr['sidebar.pupil'], "key" => "pupil", "controller" => "/backend/pupil/index"),
                array("name" => $langarr['sidebar.teacher'], "key" => "teacher", "controller" => "/backend/teacher/index"),
                array("name" => $langarr['sidebar.userpostition'], "key" => "userpostition", "controller" => "/backend/userpostition/index")
        ));
        $sidebar[] = array("name" => $langarr['sidebar.account'], "icon" => "zmdi zmdi-account", "key" => "user,rolegroup", "controller" => "javascript:void(0)", "child" => array(
            array("name" => $langarr['sidebar.user'], "key" => "loginsystem", "controller" => "/backend/user/index"),
            array("name" => $langarr['sidebar.rolegroup'], "key" => "loginsystem", "controller" => "/backend/rolegroup/index")
        ));
        $sidebar[] = array("name" => $langarr['sidebar.report'], "icon" => "zmdi zmdi-assignment", "key" => "rprequestlog", "controller" => "javascript:void(0)", "child" => array(
            array("name" => $langarr['sidebar.rprequestlog'], "key" => "rprequestlog", "controller" => "/backend/rprequestlog/index")
        ));
        $sidebar[] = array("name" => $langarr['sidebar.displayconfig'], "icon" => "zmdi zmdi-settings-square", "key" => "categoryview,articleview,config", "controller" => "javascript:void(0)", "child" => array(
            array("name" => $langarr['sidebar.category'], "key" => "categoryview", "controller" => "/backend/categoryview/index"),
            array("name" => $langarr['sidebar.article'], "key" => "articleview", "controller" => "/backend/articleview/index"),
            array("name" => $langarr['sidebar.imageconfig'], "key" => "config", "controller" => "/backend/config/image"),
            array("name" => $langarr['sidebar.confignote'], "key" => "config", "controller" => "/backend/config/note"),
        ));
        return $sidebar;
    }

    public static function is_accept_permission($key)
    {
        $uinfo = $_SESSION['uinfo'];
        $permissionlist = $uinfo['listpermission'];
        if (count($permissionlist) <= 0) $permissionlist = array();
        $tmp = explode(",", $key);
        if (count($tmp) > 0) {
            $rs = array_intersect($tmp, $permissionlist);
            if (count($rs) > 0) return 1;
            else return 0;
        } else {
            if (in_array($key, $permissionlist)) return 1;
            else return 0;
        }
    }
}

?>