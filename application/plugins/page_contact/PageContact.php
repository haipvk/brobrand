<?php

use VthSupport\Classes\ResponseHelper as Response;
use VthSupport\Classes\RequestHelper as Request;

class PageContact extends IPlugin
{
  protected $CI;
  protected $linkSendContact = "send-contact";
  protected $linkSendLettalk = 'send-lettalk';
  public function __construct()
  {
    parent::__construct();
    $this->CI = &get_instance();
  }
  public function install()
  {
    $this->addRoutes("Vindex/sendContact", $this->linkSendContact, []);
    $this->addRoutes("Vindex/sendLettalk", $this->linkSendLettalk, []);
  }
  public function uninstall()
  {
    $this->removeRoutes($this->linkSendContact);
    $this->removeRoutes($this->linkSendLettalk);
  }
  public function initVindex()
  {
    $vindex = &get_instance();
    $page = $this;
    $vindex::macro("sendContact", function ($itemRoutes) use ($page) {
      $page->sendContact($itemRoutes);
    });
    $vindex::macro("sendLettalk", function ($itemRoutes) use ($page) {
      $page->sendLettalk($itemRoutes);
    });
  }
  private function _validateform($post)
  {
    if (Request::postString('email') == '') {
      echoJson(100, lang("ERROR_MAIL"));
      die();
    }
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
      echoJSON(100, lang("MAIL_INVAIL"));
      die;
    }
  }
  private function _validateformLettalk($post)
  {
    if (Request::postString('name') == '') {
      echoJSON(110, "Vui lòng nhập tên !!!");
      die();
    }
    // if (Request::postString('position') == '') {
    //   echoJSON(110, "Vui lòng nhập chức vụ !!!");
    //   die();
    // }
    if (Request::postString('email') == '') {
      echoJson(100, "Vui lòng nhập Email !!!");
      die();
    }
    if (!filter_var($post['email'], FILTER_VALIDATE_EMAIL)) {
      echoJSON(100, lang("MAIL_INVAIL"));
      die;
    }
    // preg_match("/((09|016|012|9|16|12|03)\d{8}|(08|8)\d{7})/i", $post['phone'], $output_array);
    // if (count($output_array) == 0) {
    //   echoJSON(150, "Số điện thoại không chính xác!");
    //   exit;
    // }
    // if (Request::postString('company') == '') {
    //   echoJSON(110, "Vui lòng nhập Công ty !!!");
    //   die();
    // }
    // if (Request::postString('city') == '') {
    //   echoJSON(110, "Vui lòng nhập Thành phố !!!");
    //   die();
    // }
    // if (Request::postString('scale') == '') {
    //   echoJSON(110, "Vui lòng chọn quy mô !!!");
    //   die();
    // }
    // if (Request::postString('revenue') == '') {
    //   echoJSON(110, "Vui lòng nhập Doanh thu !!!");
    //   die();
    // }
    if (Request::postString('project') == '') {
      echoJSON(110, "Vui lòng chọn Dự án !!!");
      die();
    }
  }
  private function checkCaptcha($response)
  {
    $secret = $this->CI->Dindex->getSettings('6LfLDd8fAAAAAAui2TSQUQbHsTpH8tAxIj9CM-SF');
    $recaptcha = new \ReCaptcha\ReCaptcha($secret);
    $verify = $recaptcha->verify($response, $_SERVER['REMOTE_ADDR']);
    var_dump($verify);
    die;
    return $verify->isSuccess();
  }
  public function sendContact($itemRoutes)
  {
    $post = $this->CI->input->post();
    if (Request::isPost()) {
      $this->_validateform($post);
      $data["email"] = $post['email'];
      $data["title"] = "Khách hàng gửi thông tin liên hệ!";
      $data["create_time"] = time();
      $result = $this->CI->Dindex->insertData("reviews", $data);
    }
    if ($result) {
      $noidung = '<b>' . $data["title"] . '</b><br>';
      $noidung .= 'Địa chỉ email: <b>' . $data["email"] . '</b><br>';
      $noidung .= 'Ngày gửi: <b>' . date('d/m/Y', time()) . '</b><br>';
      $email = $this->CI->Dindex->getSettings('MAIL_NHAN');
      $emails = [$email => $email];
      VthSupport\Classes\MailHelper::sendMail($emails, $data["title"], $noidung);
      echoJSON(200, 'Gửi thông tin thành công');
    } else {
      echoJSON(110, 'Gửi thông tin không thành công vui lòng thử lại!');
    }
    if (!$this->checkCaptcha(Request::postString('g-recaptcha-response'))) {
      Response::jsonOrRedirect(100, 'Bạn chưa xác thực capcha!');
    }
  }
  public function sendLettalk($itemRoutes)
  {
    $post = $this->CI->input->post();
    if (Request::isPost()) {
      $this->_validateformLettalk($post);
      $data["email"] = $post['email'];
      $data['company'] = $post['company'];
      $data["city"] = $post['city'];
      $data["name"] = $post['name'];
      $data["position"] = $post['position'];
      $data["scale"] = $post['scale'];
      $data["project"] = $post['project'];
      $data["confirm_terms"] = $post['confirm_terms'];
      $data["title"] = "Khách hàng gửi thông tin liên hệ!";
      $data["create_time"] = time();
      $result = $this->CI->Dindex->insertData("contact_lettalk", $data);
    }
    if ($result) {
      $noidung = '<b>' . $data["title"] . '</b><br>';
      $noidung .= 'Tên: <b>' . $data["name"] . '</b><br>';
      $noidung .= 'Địa chỉ email: <b>' . $data["email"] . '</b><br>';
      $noidung .= 'Công ty: <b>' . $data["company"] . '</b><br>';
      $noidung .= 'Thành phố: <b>' . $data["city"] . '</b><br>';
      $noidung .= 'Chức vụ: <b>' . $data["position"] . '</b><br>';
      $noidung .= 'Quy mô: <b>' . $data["scale"] . '</b><br>';
      $noidung .= 'Dự án: <b>' . $data["project"] . '</b><br>';
      $noidung .= 'Chấp nhận điều khoản: <b>' . $data["confirm_terms"] . '</b><br>';
      $noidung .= 'Ngày gửi: <b>' . date('d/m/Y', time()) . '</b><br>';
      $email = $this->CI->Dindex->getSettings('MAIL_NHAN');
      $emails = [$email => $email];
      VthSupport\Classes\MailHelper::sendMail($emails, $data["title"], $noidung);
      echoJSON(200, 'Gửi thông tin thành công');
    } else {
      echoJSON(110, 'Gửi thông tin không thành công vui lòng thử lại!');
    }
    if (!$this->checkCaptcha(Request::postString('g-recaptcha-response'))) {
      Response::jsonOrRedirect(100, 'Bạn chưa xác thực capcha!');
    }
  }
}
