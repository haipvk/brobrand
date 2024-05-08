<?php 
function getCurrentCurrency($number){
    return number_format($number,0,',','.').'đ';
}
function getPricePro($dataitem, $type  = 0){
    $price=$dataitem['price'];
    $price_sale= $dataitem['price_sale'];
    $do = $type ==0? ' đ':'';
    if($price > 0 && $price_sale > 0){
        if($price_sale < $price){
            $tag1 = $type ==0?'strong':'del';
            $tag2 = $type ==0?'del':'strong';
            echo "<".$tag1.">".number_format((double)$price_sale,0,',','.').$do."</".$tag1."> <".$tag2.">".number_format((double)$price,0,',','.').$do."</".$tag2.">";
        }else{
            echo "<strong>".number_format((double)$price,0,',','.').$do."</strong>";
        }
    }
    else{
        if($price_sale > 0){
            echo "<strong>".number_format((double)$price_sale,0,',','.').$do."</strong>";
        }
        elseif($price > 0){
            echo "<strong>".number_format((double)$price,0,',','.').$do."</strong>";
        }
        else{
            echo "<strong>Giá liên hệ</strong>";
        }
    }
}
function getNumberProOfCarsAndProcategories($id_cate = 0) {
    $CI = &get_instance();
    $sql ="select count(id) c,cars,(select name from cars where cars.id = pro.cars) name from pro where cars in( select id from cars)";
    if($id_cate > 0){
        $sql .=" and FIND_IN_SET($id_cate,parent) > 0 ";
    }
    $sql .=" group by cars";
    $q  = $CI->db->query($sql);
    return $q->result_array();
}
function getProParts($id,$pp){
    $CI = &get_instance();
    $config['total_rows']=$CI->Dindex->getNumDataDetail('pro',array(array('key'=>'FIND_IN_SET('.$id.',part)','compare'=>'>','value'=>0)));
    if(!@$pp) $pp=0;
    $pp= @$pp?$pp:0;
    $config['per_page']=5;
    $limit = $pp.",".$config['per_page'];
    $data['list_data'] = $CI->Dindex->getDataDetail(array(
        'table'=>'pro',
        'limit'=>$limit,
        'where'=>array(array('key'=>'FIND_IN_SET('.$id.',part)','compare'=>'>','value'=>0)),
        'order'=>'ord asc, id desc'
    ));
    $config['uri_segment']=2;
    $CI->pagination->initialize($config);
    if($pp>0){
        $data['_meta_noindex']='<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">';
    }
    return $data;
}
function checkFileExists($f){
    $f = $f['path'].$f['name'];
    if(file_exists($f)){
        return 1;
    }
    else{
        return 0;
    }
}
function senMailSp($email,$tieude,$noidung,$email_cc=false,$email_bcc=false){
    tryCatchset();
    $CI = &get_instance();
    $mail = new \PHPMailer\PHPMailer\PHPMailer;
    $mail->CharSet = 'UTF-8';
    $mail->SMTPDebug = 0;     
    $mail->isSMTP();    
    $mail->Host = 'smtp.gmail.com'; 
    $mail->SMTPAuth = true;                              
    $mail->Username = $CI->Dindex->getSettings("MAIL_USER");                 
    $mail->Password = $CI->Dindex->getSettings("MAIL_PASS");                        
    $mail->SMTPSecure = 'tls';                           
    $mail->Port = 587;                                   
    $mail->setFrom($CI->Dindex->getSettings("MAIL_USER"), $CI->Dindex->getSettings("MAIL_NAME"));
    $mail->addAddress($email, $email);    
    $mail->isHTML(true);                                 
    $mail->Subject = $tieude;
    $mail->Body    = $noidung;
    $mail->AltBody = strip_tags($noidung);
    if($email_cc){
        $mail->AddCC($email_cc);
    }
    if($email_bcc){
        $mail->AddBCC($email_bcc);
    }
    if(!$mail->send()) {
        return false;
    } else {
        return true;
    }
}

function isMobile(){
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"]);
}