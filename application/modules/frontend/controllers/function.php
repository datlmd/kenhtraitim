<?php

class MyFunctions {

    public static function get_content_by_url($url) {
        $content = file_get_contents($url);
        do {
            $content = str_replace("  ", " ", $content);
        } while (strpos($content, "  ", 0) !== false);
        return $content;
    }

    public static function get_content_by_tag($content, $tag_and_more, $include_tag = true) {
        $p = stripos($content, $tag_and_more, 0);

        if ($p === false)
            return "";
        $content = substr($content, $p);
        $p = stripos($content, " ", 0);
        if (abs($p) == 0)
            return "";
        $open_tag = substr($content, 0, $p);
        $close_tag = substr($open_tag, 0, 1) . "/" . substr($open_tag, 1) . ">";

        $count_inner_tag = 0;
        $p_open_inner_tag = 1;
        $p_close_inner_tag = 0;
        $count = 1;
        do {
            $p_open_inner_tag = stripos($content, $open_tag, $p_open_inner_tag);
            $p_close_inner_tag = stripos($content, $close_tag, $p_close_inner_tag);
            $count++;
            if ($p_close_inner_tag !== false)
                $p = $p_close_inner_tag;
            if ($p_open_inner_tag !== false) {
                if (abs($p_open_inner_tag) < abs($p_close_inner_tag)) {
                    $count_inner_tag++;
                    $p_open_inner_tag++;
                } else {
                    $count_inner_tag--;
                    $p_close_inner_tag++;
                }
            } else {
                $count_inner_tag--;
                if ($p_close_inner_tag > 0)
                    $p_close_inner_tag++;
            }
        }while ($count_inner_tag > 0);
        if ($include_tag)
            return substr($content, 0, $p + strlen($close_tag));
        else {
            $content = substr($content, 0, $p);
            $p = stripos($content, ">", 0);
            return substr($content, $p + 1);
        }
    }

    public static function fix_src_img_tag($content, $url) {
        $p_start = 0;
        $start_tag = "<img";
        $loop = true;
        $double_ = true;
        if (substr($url, strlen($url) - 1, 1) == "/")
            $url = substr($url, 0, strlen($url) - 1);
        $src = "src=";
        $content = str_ireplace("src =", $src, $content);
        $content = str_ireplace("src= ", $src, $content);
        $len = 0;
        do {
            $p_start = stripos($content, $start_tag, $p_start);
            $len = 0;
            if ($p_start !== false) {
                $p_start = stripos($content, $src, $p_start + 1);
                if ($p_start > 0) {
                    $t = substr($content, strlen($src) + $p_start, 1);
                    if ($t == "\"" || $t == "'") {
                        $p_start += strlen($src) + 1;
                    } else {
                        $p_start += strlen($src);
                    }
                    $content = substr($content, 0, $p_start) . $url . substr($content, $p_start);
                }
                $p_start+=$len + 1;
            } else {
                $loop = false;
            }
        } while ($loop);
        return $content;
    }

    public static function list_all_link($content, $url, $attribute = "class", $remove_image_link = true) {
        $list = array();
        $bool = true;
        $i = 0;
        $href = "";
        $title = "";
        $attr = "";
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);
        do {
            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "<a", $p_start);
            if ($p_start !== false) {
                $p_end = strpos($content, "</a>", $p_start);
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);
                    $content = substr($content, $p_end + strlen("</a>"));
                    $p_start = strpos($temp, "href=", 0);
                    if ($p_start > 0) {
                        $attr = $temp;
                        $temp = trim(substr($temp, $p_start + strlen("href=")));
                        $t = substr($temp, 0, 1);
                        if (($t == "\"") || ($t == "'")) {
                            $p_end = strpos($temp, $t, 1);
                            $href = substr($temp, 1, $p_end - 1);
                        } else {
                            $p_start = strpos($temp, " ", 0);
                            $p_end = strpos($temp, ">", 0);

                            if ($p_start > 0 && ($p_start < $p_end)) {
                                $href = substr($temp, 0, $p_start);
                            } else {
                                $href = substr($temp, 0, $p_end);
                            }
                        }
                        $j = $i - 1;
                        $p_end = strpos($temp, ">", 0);
                        $title = substr($temp, $p_end + 1);
                        if ($remove_image_link) {
                            if (strpos($title, "<img", 0) === false) {
                                $j++;
                            }
                        } else {
                            $j++;
                        }
                        if ($j == $i) {
                            if (substr($href, 0, 1) == "/") {
                                $href = $url . $href;
                            }
                            $p_start = stripos($attr, $attribute . "=", 0);
                            if ($p_start !== false) {
                                $attr = substr($attr, $p_start + strlen($attribute . "="));
                                $t = substr($attr, 0, 1);
                                if (($t == "\"") || ($t == "'")) {
                                    $p_end = strpos($attr, $t, 1);
                                    $attr = substr($attr, 1, $p_end - 1);
                                } else {
                                    $p_start = strpos($attr, " ", 0);
                                    $p_end = strpos($attr, ">", 0);
                                    if ($p_star !== false) {
                                        if ($p_end === false || $p_end > $p_start)
                                            $attr = substr($attr, 0, $p_start);
                                        else
                                            $attr = substr($attr, 0, $p_end);
                                    }else if ($p_end !== false) {
                                        $attr = substr($attr, 0, $p_end);
                                    } else {
                                        $attr = "";
                                    }
                                }
                            } else {
                                $attr = "";
                            }
                            $title = trim(str_replace("&nbsp;", " ", $title));
                            $list[$j]['href'] = $href;
                            $list[$j]['title'] = trim($title);
                            $list[$j][$attribute] = $attr;
                            $i++;
                        }
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        return $list;
    }

    public static function list_all_link_vnex($content, $url, $attribute = "class", $remove_image_link = true) {
        $list = array();
        $bool = true;
        $i = 0;
        $href = "";
        $title = "";
        $attr = "";
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);

        do {
            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "<li", $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content, "</li>", $p_start);
                //var_dump($p_end);die;
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);
                    $temp = str_ireplace("src=\"http://st.f1.vnecdn.net/responsive/i/v15/graphics/img_blank.gif\"", " ", $temp);
                    $content = substr($content, $p_end, strlen($content) - 1);
                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $matches [1];

                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];
                    //var_dump($img);die;
                    preg_match('/<a(.*?)>(.*?)</', $temp, $matches);
                    if ($matches)
                        $title = $matches [2];

                    preg_match('/news_lead(.*?)>(.*?)</', $temp, $matches);
                    if ($matches)
                        $note = $matches [2];

                    preg_match('/divnav2(.*?)<p>(.*?)</', $temp, $matches);
                    if ($matches)
                        $date = $matches [2];
                    var_dump($date);
                    die;
                    if ($title != '' && $href != '' && $img != '' && $note != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim($note);
                        $list[$i]['date'] = trim($date);
                        $i++;
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        return $list;
    }
    
    public function GetBetween($var1,$var2,$pool){
        $temp1 = strpos($pool,$var1)+strlen($var1);
        $result = substr($pool,$temp1,strlen($pool));
        $dd=strpos($result,$var2);
        if($dd == 0){
            $dd = strlen($result);
        }

        return substr($result,0,$dd);
    }
    
    function find_between($string, $start, $end, $trim = true, $greedy = false) {
        $pattern = '/' . preg_quote($start) . '(.*';
        if (!$greedy) $pattern .= '?';
        $pattern .= ')' . preg_quote($end) . '/';
        preg_match($pattern, $string, $matches);
        $string = $matches[0];
        if ($trim) {
            $string = substr($string, strlen($start));
            $string = substr($string, 0, -strlen($start) + 1);
        }
        return $string;
    }

    public static function list_all_link_kenh14_($content, $url, $attribute = "class", $remove_image_link = true) {
        $list = array();
        $bool = true;
        $i = 0;
        $href = "";
        $title = "";
        $attr = "";
        $note ="";
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);

            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "<li class=\"item small clearfix\">", $p_start);
        do {
            if ($p_start !== false) {
                $p_end = strpos($content, "</li>", $p_start);
                //var_dump($p_end);die;
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);

                    $content = substr($content, $p_end, strlen($content) - 1);

                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $url . $matches [1];
 
                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];
                    
                    preg_match('/alt=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $title = $matches [1];

                    $temp1 = strpos($temp,'sapo">')+strlen('sapo">');
                    $result = substr($temp,$temp1,strlen($temp));
                    $dd=strpos($result,'</div>');
                    if($dd == 0){
                        $dd = strlen($result);
                    }

                    $note = substr($result,0,$dd);
        
                    //var_dump($note);die;
                    
                    if ($title != '' && $href != '' && $img != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim($note);

                        $i++;
                    }
                    //var_dump($list);die;
                    if($i == 2){
                        var_dump($list);die;
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        
        return $list;
    }
    
    public static function list_all_link_kenh14($content, $url, $cate, $url_cate, $limit = 0, $attribute = "class", $remove_image_link = true) {
        include_once ("crawl.php");
        $H_Crawl = new H_Crawl ( );
        
        $list = array();
        $bool = true;
        $i = 0;
        $href = "";
        $title = "";
        $attr = "";
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);
        
        $content_focus = '';
     
        
        $temp1 = strpos($content,'nextfocus')+strlen('nextfocus');
        $result = substr($content,$temp1,strlen($content));
         $dd=strpos($result,'newslistpannel');
        if($dd == 0){
            $dd = strlen($result);
        }

        $content_focus = substr($result,0,$dd);
        
        //list focus
        do {
            if ($limit > 0 && $i == $limit)
                break;

            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content_focus, "<li>", $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content_focus, "</li>", $p_start);
                //var_dump($p_end);die;
                if ($p_end > 0) {
                    $temp = substr($content_focus, $p_start, $p_end - $p_start);

                    $content_focus = substr($content_focus, $p_end, strlen($content_focus) - 1);

                    $href = $img = $title = $note = $date = '';

                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $url . $matches [1];
                    //var_dump($temp);die;
                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];

                    preg_match('/title=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $title = $matches [1];

                    $temp1 = strpos($temp,'sapo">')+strlen('sapo">');
                    $result = substr($temp,$temp1,strlen($temp));
                    $dd=strpos($result,'</p>');
                    if($dd == 0){
                        $dd = strlen($result);
                    }
                    $note = substr($result,0,$dd);

                    $temp1 = strpos($temp,'date">')+strlen('date">');
                    $result = substr($temp,$temp1,strlen($temp));
                    $dd=strpos($result,'</span>');
                    if($dd == 0){
                        $dd = strlen($result);
                    }
                    $date = substr($result,0,$dd);

                    if ($title != '' && $href != '' && $img != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim($note);
                        $list[$i]['date'] = trim($date);
                        $list[$i]['domain'] = 'Kênh 14';
                        $list[$i]['cate'] = $cate;
                        $list[$i]['url_cate'] = $url_cate;
                        $i++;
                    }
                    //var_dump($list);die;
                }
            } else {
                $bool = false;
            }
        } while ($bool);
//var_dump($content);die;
        $bool = true;
        //list all
        do {
            if ($limit > 0 && $i == $limit)
                break; 
            //var_dump($matches[1]);die;
            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "item small clearfix", $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content, "</li", $p_start);
                
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);

                    $content = substr($content, $p_end, strlen($content) - 1);

                    $href = $img = $title = $note = $date = '';

                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $url . $matches [1];

                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];

                    preg_match('/title=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $title = $matches [1];

                    $temp1 = strpos($temp,'sapo">')+strlen('sapo">');
                    $result = substr($temp,$temp1,strlen($temp));
                    $dd=strpos($result,'</div>');
                    if($dd == 0){
                        $dd = strlen($result);
                    }

                    $note = substr($result,0,$dd);

                    $temp1 = strpos($temp,'meta">')+strlen('meta">');
                    $result = substr($temp,$temp1,strlen($temp));
                    $dd=strpos($result,'</div>');
                    if($dd == 0){
                        $dd = strlen($result);
                    }

                    $date = substr($result,0,$dd);
                    
                    
                    //
                    if ($title != '' && $href != '' && $img != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim($note);
                        $list[$i]['date'] = trim($date);
                        $list[$i]['domain'] = 'Kênh 14';
                        $list[$i]['cate'] = $cate;
                        $list[$i]['url_cate'] = $url_cate;
                        $i++;
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        
        return $list;
    }
    
    public static function kenh14_categorise(){
        $k = 0;
        $list_url = array();
        $list_url[$k]['name'] = 'Sao';
        $list_url[$k++]['url'] = "http://kenh14.vn/star.chn";
        $list_url[$k]['name'] = 'Âm nhạc';
        $list_url[$k++]['url'] = "http://kenh14.vn/musik.chn";
        $list_url[$k]['name'] = 'Phim ảnh';
        $list_url[$k++]['url'] = "http://kenh14.vn/cine.chn";
        $list_url[$k]['name'] = 'TV Show';
        $list_url[$k++]['url'] = "http://kenh14.vn/tv-show.chn";
        $list_url[$k]['name'] = 'Thời trang';
        $list_url[$k++]['url'] = "http://kenh14.vn/fashion.chn";
        $list_url[$k]['name'] = 'Đời sống';
        $list_url[$k++]['url'] = "http://kenh14.vn/doi-song.chn";
        $list_url[$k]['name'] = 'Xã hội';
        $list_url[$k++]['url'] = "http://kenh14.vn/xa-hoi.chn";
        $list_url[$k]['name'] = 'Thế giới';
        $list_url[$k++]['url'] = "http://kenh14.vn/the-gioi.chn";
        $list_url[$k]['name'] = 'Sức khoẻ - Giới tính';
        $list_url[$k++]['url'] = "http://kenh14.vn/suc-khoe-gioi-tinh.chn";
        $list_url[$k]['name'] = 'Made by me';
        $list_url[$k++]['url'] = "http://kenh14.vn/made-by-me.chn";
        $list_url[$k]['name'] = 'Thể thao';
        $list_url[$k++]['url'] = "http://kenh14.vn/sport.chn";
        $list_url[$k]['name'] = 'Khám phá';
        $list_url[$k++]['url'] = "http://kenh14.vn/kham-pha.chn";
        $list_url[$k]['name'] = 'Công nghệ';
        $list_url[$k++]['url'] = "http://kenh14.vn/2-tek.chn";
        $list_url[$k]['name'] = 'Lạ';
        $list_url[$k++]['url'] = "http://kenh14.vn/la-cool.chn";
        $list_url[$k]['name'] = 'Học đường';
        $list_url[$k++]['url'] = "http://kenh14.vn/hoc-duong.chn";
//        $list_url[$k]['name'] = 'Video';
//        $list_url[$k++]['url'] = "http://kenh14.vn/video.chn";
        
        return $list_url;
    }
    
    public static function _2sao_categorise(){
        $k = 0;
        $list_url = array();
        $list_url[$k]['name'] = 'Sao';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1000/sao.vnn";
        $list_url[$k]['name'] = 'Xã hội';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1048/su-kien-xa-hoi.vnn";
        $list_url[$k]['name'] = 'Thời trang';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1004/thoi-trang.vnn";
        $list_url[$k]['name'] = 'Âm nhạc';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1001/am-nhac.vnn";
        $list_url[$k]['name'] = 'Điện ảnh';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1002/phim.vnn";
        $list_url[$k]['name'] = 'Fun';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1005/hoi-dap.vnn";
        $list_url[$k]['name'] = 'Giới trẻ';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1049/doi-song-gioi-tre.vnn";
        $list_url[$k]['name'] = 'Thể thao';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1051/the-thao.vnn";
        $list_url[$k]['name'] = 'Lạ';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1052/chuyen-la.vnn";
        $list_url[$k]['name'] = 'Giới tính';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1064/suc-khoe-gioi-tinh.vnn";
        $list_url[$k]['name'] = 'Tâm sự';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1065/tam-su.vnn";
        $list_url[$k]['name'] = 'Clip';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1066/clip.vnn";
        $list_url[$k]['name'] = 'Ảnh';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1067/anh.vnn";
        $list_url[$k]['name'] = 'Truyện';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1068/truyen.vnn";
        $list_url[$k]['name'] = 'Chơi';
        $list_url[$k++]['url'] = "http://2sao.vn/p0c1070/choi.vnn";
        
        return $list_url;
    }

    public static function list_all_link_2sao($content, $url, $cate, $url_cate, $limit = 0, $attribute = "class", $remove_image_link = true) {
        include_once ("crawl.php");
        $H_Crawl = new H_Crawl ( );
        
        $list = array();
        $bool = true;
        $i = 0;
        $href = "";
        $title = "";
        $attr = "";
        $content = str_ireplace("href =", "href=", $content);
        $content = str_ireplace("href= ", "href=", $content);

        do {
            if ($limit > 0 && $i == $limit)
                break;
            
            preg_match('/span5(.*?)div>/', $content, $matches);
            
            //var_dump($matches[1]);die;
            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "lilist", $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content, "</li", $p_start);
                //var_dump($p_end);die;
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);

                    $content = substr($content, $p_end, strlen($content) - 1);

                    $href = $img = $title = $note = $date = '';

                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $url . $matches [1];

                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];

                    preg_match('/title=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $title = $matches [1];

                    preg_match('/class=\"psapo\">(.*?)</', $temp, $matches);
                    if ($matches)
                        $note = $matches [1];

                    preg_match('/divnav2(.*?)<p>(.*?)</', $temp, $matches);
                    if ($matches)
                        $date = $matches [2];

                    if ($title != '' && $href != '' && $img != '' && $note != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim(str_ireplace('(2Sao) - ', '', $note));
                        $list[$i]['date'] = trim($date);
                        $list[$i]['domain'] = '2 Sao';
                        $list[$i]['cate'] = $cate;
                        $list[$i]['url_cate'] = $url_cate;
                        $i++;
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        
        do {
            if ($limit > 0 && $i == $limit)
                break;

            $p_start = 0;
            $p_end = 0;
            $p_start = strpos($content, "lilist", $p_start);

            if ($p_start !== false) {
                $p_end = strpos($content, "</li", $p_start);
                //var_dump($p_end);die;
                if ($p_end > 0) {
                    $temp = substr($content, $p_start, $p_end - $p_start);

                    $content = substr($content, $p_end, strlen($content) - 1);

                    $href = $img = $title = $note = $date = '';

                    preg_match('/href=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $href = $url . $matches [1];

                    preg_match('/src=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $img = $matches [1];

                    preg_match('/title=\"(.*?)\"/', $temp, $matches);
                    if ($matches)
                        $title = $matches [1];

                    preg_match('/class=\"psapo\">(.*?)</', $temp, $matches);
                    if ($matches)
                        $note = $matches [1];

                    preg_match('/divnav2(.*?)<p>(.*?)</', $temp, $matches);
                    if ($matches)
                        $date = $matches [2];

                    if ($title != '' && $href != '' && $img != '' && $note != '') {
                        $title = trim(str_replace("&nbsp;", " ", $title));
                        $list[$i]['href'] = $href;
                        $list[$i]['title'] = trim($title);
                        $list[$i]['img'] = trim($img);
                        $list[$i]['note'] = trim(str_ireplace('(2Sao) - ', '', $note));
                        $list[$i]['date'] = trim($date);
                        $list[$i]['domain'] = '2 Sao';
                        $list[$i]['cate'] = $cate;
                        $list[$i]['url_cate'] = $url_cate;
                        $i++;
                    }
                }
            } else {
                $bool = false;
            }
        } while ($bool);
        return $list;
    }

}

?> 