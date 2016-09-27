<?php
    namespace Webapp\Backend\Controllers;

    use Phalcon\Mvc\Controller;
    use Phalcon\Mvc\Url;
    use Webapp\Backend\Locale\Culture;
    use Webapp\Backend\Utility\Helper;
    use Webapp\Backend\Utility\Module;
    use Webapp\Frontend\Models\Configs;

    class ControllerBase extends Controller {
        public $userinfo;
        public $langkey;
        public $modulename; // For language
        public $culture;

        public function initialize() {
            $controller = strtolower($this->router->getControllerName());
            $action = $this->router->getActionName();
            $fullcontroleraction = strtolower($controller . "/" . $action);
            $this->controllername = $controller;
            $this->actionname = $action;
            if (!$this->session->has("uinfo")) {
                if ($fullcontroleraction != "security/login") $this->response->redirect("security/login");
            }
            $this->userinfo = $this->view->uinfo = $this->session->get("uinfo");
            /*Init Lang*/
            $this->view->langlist = Culture::lang();
            if (!$this->session->has("lang")) {
                if ($this->cookies->has('wsi_lang')) $this->session->set("lang", (string)$this->cookies->get('wsi_lang')); // Init by cookies
                else $this->session->set("lang", "vi_VN"); // Default
            }
            $this->langkey = $langkey = $this->session->get("lang");
            foreach ($this->view->langlist as $item) if ($item['key'] == $langkey) $this->view->language_active = $item;
            $culture = new Culture($this->langkey, $this->modulename);
            $this->view->labelkey = $this->culture = $culture->langarr;
            //Check Sidebar
            $sidebar = Module::Sidebar($culture->langarr);
            foreach ($sidebar as $key => $item) {
                if ($this->checksidebar($item) == 0) unset($sidebar[$key]);
                if (count($sidebar[$key]['child'])) {
                    foreach ($sidebar[$key]['child'] as $ckey => $citem) {
                        if ($this->checksidebar($citem) == 0) unset($sidebar[$key]['child'][$ckey]);
                    }
                    $sidebar[$key]['child'] = array_values($sidebar[$key]['child']);
                }
            }
            $sidebar = array_values($sidebar);
            $this->view->sidebar = $sidebar;
            $this->view->currenturl = Helper::cpagerparm("lang");
            $this->view->media = $this->config->media;
            $this->config->application->baseUrl = rtrim($this->config->application->baseUrl,"/");
            $this->view->config = $this->config;
            $this->view->application = $this->config->application;
        }

        public function checksidebar($sidebaritem) {
            $permission = $this->userinfo['listpermission'];
            $lp = explode(",", $sidebaritem['key']);
            foreach ($lp as $item) {
                if (in_array($item, $permission)) return 1;
                else return 0;
            }

            return 0;
        }

        public function checkpermission($key, $redirect = true) {
            if (Module::is_accept_permission($key) == 0) {
                if ($redirect == true) {
                    $this->flash->error("You are not authenticate to use this action! Contact to admin for this problem!");
                    $this->response->redirect("security/message");
                }

                return 0;
            }
            else return 1;
        }

        public function render_template($controller, $action, $data = null) {
            $view = $this->view;
            $content = $view->getRender($controller, $action, ["object" => $data], function ($view) {
                $view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_LAYOUT);
            });

            return $content;
        }

        public function debug($var) {
            echo "<pre>";
            print_r($var);
            echo "</pre>";
            die;
        }

        public function post_file_key($key, $fullpath = false) {
            if (!isset($_FILES["$key"])) return null;
            //$target_dir = getcwd() . "/";
            //$target_dir = "/home/wsi.vn/public_html/public/";
            $target_dir = $this->config->media->dir;
            $folder = "uploads/" . date("Y/m/d");
            $listallow = [
                "jpg",
                "jpeg",
                "png",
                "gif",
                "mp3",
                "mp4",
                "xlsx",
                "xls"
            ];
            $fileParts = strtolower(pathinfo($_FILES[$key]['name'], PATHINFO_EXTENSION));
            $folder_name = '/';
            $folder_name = '/general/';
            if (in_array($fileParts, [
                'jpg',
                'jpeg',
                'gif',
                'png'
            ])) {
                $folder_name = '/picture/';
            }
            if (in_array($fileParts, [
                'mp3',
                'mp4',
                'avi',
                'mkv'
            ])) {
                $folder_name = '/video/';
            }
            if (in_array($fileParts, ['srt'])) {
                $folder_name = '/sub/';
            }
            if (!file_exists($target_dir . $folder . $folder_name)) var_dump(mkdir($target_dir . $folder . $folder_name, 0777, true));
            $target_file = $folder . $folder_name . basename(md5(strtotime("now") . uniqid() . rand(0, 9999)) . "_" . $this->removeTitle($_FILES["$key"]["name"]));
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (file_exists($target_file)) return null;
            if ($_FILES["$key"]["size"] <= 0) return null;
            if (!in_array($imageFileType, $listallow)) return null;
            move_uploaded_file($_FILES["$key"]["tmp_name"], $target_dir . $target_file);
            if ($fullpath == true) return $target_dir . $target_file;
            else return $target_file;
        }

        public function create_album_folder($name, $size) {
            //$target_dir = getcwd().'/';
            //$target_dir = "/home/wsi.vn/public_html/public/"; // Neu doi duong dan chua file upload thi phai doi ca trong library/SimpleImage.php
            $target_dir = $this->config->media->dir;
            $folder = "uploads/" . date("Y/m/d");
            $folder_name = '/album/';
            if (!file_exists($target_dir . $folder . $folder_name . 'large/')) if (!mkdir($target_dir . $folder . $folder_name . 'large/', 0777, true)) die('Ko the tao thu muc Large');
            if (!file_exists($target_dir . $folder . $folder_name . 'thumb/')) if (!mkdir($target_dir . $folder . $folder_name . 'thumb/', 0777, true)) die('Ko the tao thu muc Thumb');
            $listallow = [
                "jpg",
                "jpeg",
                "png",
                "gif"
            ];
            $fileParts = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            $target_file = $folder . $folder_name . 'large/' . basename(md5(strtotime("now") . uniqid() . rand(0, 9999)) . "_" . $this->removeTitle($name));
            $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
            if (file_exists($target_file)) return null;
            if ($size <= 0) return null;
            if (!in_array($imageFileType, $listallow)) return null;

            return $target_file;
        }

        public function RemoveSign($str) {
            $coDau = [
                "à",
                "á",
                "ạ",
                "ả",
                "ã",
                "â",
                "ầ",
                "ấ",
                "ậ",
                "ẩ",
                "ẫ",
                "ă",
                "ằ",
                "ắ",
                "ặ",
                "ẳ",
                "ẵ",
                "è",
                "é",
                "ẹ",
                "ẻ",
                "ẽ",
                "ê",
                "ề",
                "ế",
                "ệ",
                "ể",
                "ễ",
                "ì",
                "í",
                "ị",
                "ỉ",
                "ĩ",
                "ò",
                "ó",
                "ọ",
                "ỏ",
                "õ",
                "ô",
                "ồ",
                "ố",
                "ộ",
                "ổ",
                "ỗ",
                "ơ",
                "ờ",
                "ớ",
                "ợ",
                "ở",
                "ỡ",
                "ù",
                "ú",
                "ụ",
                "ủ",
                "ũ",
                "ư",
                "ừ",
                "ứ",
                "ự",
                "ử",
                "ữ",
                "ỳ",
                "ý",
                "ỵ",
                "ỷ",
                "ỹ",
                "đ",
                "À",
                "Á",
                "Ạ",
                "Ả",
                "Ã",
                "Â",
                "Ầ",
                "Ấ",
                "Ậ",
                "Ẩ",
                "Ẫ",
                "Ă",
                "Ằ",
                "Ắ",
                "Ặ",
                "Ẳ",
                "Ẵ",
                "È",
                "É",
                "Ẹ",
                "Ẻ",
                "Ẽ",
                "Ê",
                "Ề",
                "Ế",
                "Ệ",
                "Ể",
                "Ễ",
                "Ì",
                "Í",
                "Ị",
                "Ỉ",
                "Ĩ",
                "Ò",
                "Ó",
                "Ọ",
                "Ỏ",
                "Õ",
                "Ô",
                "Ồ",
                "Ố",
                "Ộ",
                "Ổ",
                "Ỗ",
                "Ơ",
                "Ờ",
                "Ớ",
                "Ợ",
                "Ở",
                "Ỡ",
                "Ù",
                "Ú",
                "Ụ",
                "Ủ",
                "Ũ",
                "Ư",
                "Ừ",
                "Ứ",
                "Ự",
                "Ử",
                "Ữ",
                "Ỳ",
                "Ý",
                "Ỵ",
                "Ỷ",
                "Ỹ",
                "Đ",
                "ê",
                "ù",
                "à"
            ];
            $khongDau = [
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "a",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "e",
                "i",
                "i",
                "i",
                "i",
                "i",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "o",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "u",
                "y",
                "y",
                "y",
                "y",
                "y",
                "d",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "A",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "E",
                "I",
                "I",
                "I",
                "I",
                "I",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "O",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "U",
                "Y",
                "Y",
                "Y",
                "Y",
                "Y",
                "D",
                "e",
                "u",
                "a"
            ];

            return str_replace($coDau, $khongDau, $str);
        }

        public function removeTitle($string, $keyReplace = '-') {
            $string = $this->RemoveSign($string);
            //neu muon de co dau
            $string = trim(preg_replace("/[^A-Za-z0-9.]/i", " ", $string)); // khong dau
            $string = str_replace(" ", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace("--", "-", $string);
            $string = str_replace($keyReplace, "-", $string);
            $string = strtolower($string);

            return $string;
        }
    }
