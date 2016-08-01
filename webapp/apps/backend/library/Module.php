<?php
namespace Webapp\Backend\Utility;
use Phalcon\Mvc\Url;

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
        $permission["menuview"] = array("name" => "Menu", "child" => array(
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
        global $config;
        $baseuri = rtrim($config->application->baseUri,"/");
        $sidebar[] = array("name" => $langarr['sidebar.home'], "icon" => "zmdi zmdi-home", "key" => "loginsystem", "controller" => "$baseuri/index/index");
        $sidebar[] = array("name" => $langarr['sidebar.article'], "icon" => "zmdi zmdi-file-text", "key" => "news", "controller" => "$baseuri/article/index");
        $sidebar[] = array("name" => $langarr['sidebar.album'], "icon" => "zmdi zmdi-collection-image", "key" => "albummedia", "controller" => "$baseuri/albummedia/index");
        $sidebar[] = array("name" => $langarr['sidebar.category'], "icon" => "zmdi zmdi-folder", "key" => "category", "controller" => "$baseuri/category/index");

        $sidebar[] = array("name" => $langarr['sidebar.account'], "icon" => "zmdi zmdi-account", "key" => "user,rolegroup", "controller" => "javascript:void(0)", "child" => array(
            array("name" => $langarr['sidebar.user'], "key" => "loginsystem", "controller" => "$baseuri/user/index"),
            array("name" => $langarr['sidebar.rolegroup'], "key" => "loginsystem", "controller" => "$baseuri/rolegroup/index")
        ));

        $sidebar[] = array("name" => $langarr['sidebar.displayconfig'], "icon" => "zmdi zmdi-settings-square", "key" => "categoryview,articleview,config", "controller" => "javascript:void(0)", "child" => array(
            array("name" => "Menu", "key" => "menuview", "controller" => "$baseuri/menu/index"),
            array("name" => $langarr['sidebar.category'], "key" => "categoryview", "controller" => "$baseuri/categoryview/index"),
            array("name" => $langarr['sidebar.article'], "key" => "articleview", "controller" => "$baseuri/articleview/index"),
            array("name" => $langarr['sidebar.imageconfig'], "key" => "config", "controller" => "$baseuri/config/image"),
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

    public static function category_type(){
        $cat[] = array("key"=>"news","name"=>"Tin tức");
        $cat[] = array("key"=>"about","name"=>"Giới thiệu");
        $cat[] = array("key"=>"copyright","name"=>"Bản quyền");
        $cat[] = array("key"=>"learning","name"=>"Đào tạo");
        $cat[] = array("key"=>"creator","name"=>"Sản xuất - phát hành");
        $cat[] = array("key"=>"product","name"=>"Sản phẩm");
        $cat[] = array("key"=>"network","name"=>"Network");
        return $cat;
    }
    public static function menu_type(){
        $menu[] = array("key"=>"category","name"=>"Category");
        $menu[] = array("key"=>"url","name"=>"URL");
        return $menu;
    }
}

?>