<?php


define('DOT', '.');
require_once(DOT . "/bootstrap.php");

$Route = new Apps\Route;

$Route->add('/', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Home | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.dashboard"));
}, 'GET');


/***
 * Auth Routes
 * for basic internet banking
 */
$Route->add('/transactions', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$accid = $Template->storage('accid');
	$RecentTransactions = $Banco->RecentUserTransactions($accid);
	$Template->assign("RecentTransactions", $RecentTransactions);
	$Template->assign("title", "Transactions | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.transactions"));
}, 'GET');


$Route->add('/profile', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Edit Profile | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.profile"));
}, 'GET');

$Route->add('/kyc', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Upload Documents | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.kyc"));
}, 'GET');

$Route->add('/settings', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Settings | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.settings"));
}, 'GET');


$Route->add('/statement/{accid}/print', function ($accid) {
	$Template = new Apps\Template;
	$PDF = new \Mpdf\Mpdf(['mode' => 'utf-8']);
	$Banco = new Apps\Banco;
	$UserInfo = $Banco->UserInfo($accid);
	$Transactions = $Banco->AllTransactions();
	$reqnum = time();
	$header = '<!--mpdf
	<htmlpageheader name="letterheader">
		<table width="100%" style=" font-family: sans-serif;">
			<tr>
			<td width="50%" style="color:#0000BB; ">
			<div><img src="https://citizensbcanada.com/templates/assets/site/images/pwau_logo.png" ></div>
			<p>&nbsp;</p>			
			<br />82 Maude St, Sandown,<br /> Sandton 2031, Johannesburg<br />South Africa.<br/><span style="font-size: 100%;">Tel:</span> +2711 568 0910<br/><span style="font-size: 100%;">Email:</span> info@citizensbcanada.com</td>
			<td width="50%" style="text-align: right; vertical-align: top;">Document Request No.<br /><span style="font-weight: bold; font-size: 12pt;">' . $reqnum  . '</span></td>
			</tr>
		</table>
		<div style="margin-top: 1cm; text-align: right; font-family: sans-serif;">
			{DATE jS F Y}
		</div>
	</htmlpageheader>

	<style>
		@page {
			margin-top: 2.5cm;
			margin-bottom: 2.5cm;
			margin-left: 2cm;
			margin-right: 2cm;
			footer: html_letterfooter2;
			background-color: #FFFFFF;
		}
	
		@page :first {
			margin-top: 8cm;
			margin-bottom: 4cm;
			header: html_letterheader;
			footer: _blank;
			resetpagenum: 1;
			background-color: #FFFFFF;
		}
	
		@page letterhead :first {
			margin-top: 8cm;
			margin-bottom: 4cm;
			header: html_letterheader;
			footer: _blank;
			resetpagenum: 1;
			background-color: #FFFFFF;
		}
		.letter {
			page-break-before: always;
			page: letterhead;
		}
	</style>';

	$body = '<h3 class="subtitle" style="margin-bottom: 0px;">All Transactions<hr/></h3>';
	$body .= '<table style="width:100%;">';
	$body .= '
	<thead>
		<tr align="left">
			<th style="text-align: left;">VALUE DATE</th>
			<th style="text-align: left;">AMOUNT</th>
			<th style="text-align: left;">NOTE/REF.</th>
		</tr>
	</thead>
	<tbody>
	';
	while ($transaction = mysqli_fetch_object($Transactions)) {
		$color = $transaction->type == 'CREDIT' ? 'green' : 'red';
		$sign = $transaction->type == 'CREDIT' ? '+' : '-';
		$body .= '
		<tr  style="margin-top: 2px;">
			<td style="text-align: left; width:33%;">' .  $transaction->created . '</td>
			<td style="text-align: left; width:33%; color:' . $color . '">' . $sign . ' ' .   $Banco->UserBalance($accid, $transaction->amount) . '</td>
			<td style="text-align: left; width:33%;">' .  $transaction->notes . '</td>
	  	</tr>
	  	';
	}
	$body .= '</tbody></table>';
	$body .= '<h2 class="subtitle" style="margin-top: 20px;"><hr/>Balance: <span style="color: #000000;">' . $Banco->UserBalance($accid, $UserInfo->balance) .  '</span></h2>';

	$footer = '
	<htmlpagefooter name="letterfooter2">
		<div style="border-top: 1px solid #000000; font-size: 9pt; text-align: center; padding-top: 3mm; font-family: sans-serif; ">
			Page {PAGENO} of {nbpg}
		</div>
	</htmlpagefooter>
	mpdf-->';

	$PDF->WriteHTML(utf8_encode($header));
	$PDF->WriteHTML(utf8_encode($body));
	$PDF->WriteHTML(utf8_encode($footer));
	$PDF->SetProtection(array(), "{$accid}", "{$accid}");

	$FileDir = "{$Template->store}pdf/{$accid}/";
	if (!is_dir($FileDir)) {
		mkdir($FileDir, 0777, true);
	}

	$PDF->Output("{$FileDir}{$reqnum}-Account-Statement.pdf", 'F');
	$attachment = "{$FileDir}{$reqnum}-Account-Statement.pdf";
	$attachment = domain . ltrim($attachment, "./");

	$fullname = "{$UserInfo->firstname} {$UserInfo->lastname}";
	$subject = "@Financial Statement Request-{$reqnum}";
	$mailbody = "<p>Hello <strong>{$fullname}</strong>!</p>
	<p>Your requested account statement has been processed. Find attached copy of the statement.</p>
	<p>The document is password-protected, use your account number as password key to open the document.</p>
	<p><a href='{$attachment}'>{$attachment}</a></p>
	<p>Thank you.</p>";

	//Email Notix//
	$Mailer = new Apps\Emailer();
	$EmailTemplate = new Apps\EmailTemplate('mails.default');
	$EmailTemplate->subject = $subject;
	$EmailTemplate->fullname = $fullname;
	$EmailTemplate->mailbody = $mailbody;
	$Mailer->subject = $subject;
	$Mailer->SetTemplate($EmailTemplate);
	$Mailer->toEmail = $UserInfo->email;
	$Mailer->toName = $fullname;
	$Mailer->send();
	//Email Notix//
    $Template->setError("Your Financial statement has been emailed to you.", "success", "/ibanking");
	$Template->redirect('/ibanking');

}, 'POST');

$Route->add('/statement', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Settings | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.statement"));
}, 'GET');


$Route->add('/changepassword', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Change Password | Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.changepassword"));
}, 'GET');


$Route->add('/activities', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Activities | Citizens Bank Canada");
	$accid = $Template->storage('accid');
	$LogonActivities	= $Banco->LogonActivities($accid);
	$Template->assign("LogonActivities",$LogonActivities);
	$Template->render($Banco->CheckKYC("ibanking.activities"));
}, 'GET');

$Route->add('/transfer', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Continue Transfer| Citizens Bank Canada");
	$Template->render($Banco->CheckKYC("ibanking.transfer"));
}, 'GET');



$Route->add('/transit', function () {

	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");

	if (!isset($Template->data['PayData'])) {
		$Template->redirect("/ibanking");
	}

	$PayData = isset($Template->data['PayData']) ? $Template->data['PayData'] : array();

	$transferid = $PayData['transferid'];
	$accid = $Template->storage('accid');
	$UserInfo = $Banco->UserInfo($accid);

	if (!$UserInfo->denytransfer) {

		$transfer_error_cleared = (int)isset($PayData['transfer_error_cleared']) ? $PayData['transfer_error_cleared'] : 0;
		if ($UserInfo->enable_error) {

			if ($transfer_error_cleared) {
				$Banco->AddTransferTransaction($accid, $transferid);
				$Template->store("paystep", 0);
				$Template->store("PayData", array());
				$Template->assign("title", "Transfer Completed | Citizens Bank Canada");
				$Template->render($Banco->CheckKYC("ibanking.transit_completed"));
			} else {
				$Template->assign("title", "One More Step | Citizens Bank Canada");
				$Template->store("paystep", 6);
				$Template->render($Banco->CheckKYC("ibanking.transfer"));
			}
		} else {
			$Banco->AddTransferTransaction($accid, $transferid);
			$Template->store("paystep", 0);
			$Template->store("PayData", array());
			$Template->assign("title", "Transfer Completed | Citizens Bank Canada");
			$Template->render($Banco->CheckKYC("ibanking.transit_completed"));
		}
	} else {
		$Template->store("paystep", 0);
		$Template->store("PayData", array());
		$Template->assign("title", "Transfer Failed | Citizens Bank Canada");
		$Template->render($Banco->CheckKYC("ibanking.transit_failed"));
	}
}, 'GET');


$Route->add('/auth/register', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Register | Citizens Bank Canada");
	$Template->render("ibanking.register");
}, 'GET');


$Route->add('/auth/login', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Login | Citizens Bank Canada");
	$Template->render("ibanking.login");
}, 'GET');

$Route->add('/auth/reset', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Reset password | Citizens Bank Canada");
	$Template->render("ibanking.reset");
}, 'GET');

$Route->add('/auth/otp', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "One Time Password | Citizens Bank Canada");
	$Template->render("ibanking.otp");
}, 'GET');

$Route->add('/auth/lock', function () {

	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	if (!isset($Template->data['newaccid'])) {
		$Template->redirect("/ibanking/auth/register");
	}
	$Banco = new Apps\Banco;
	$UserInfo = $Banco->UserInfo($Template->data['newaccid']);
	$Template->assign("title", "{$UserInfo->firstname} {$UserInfo->lastname} | Citizens Bank Canada");
	$Template->assign("UserInfo", $UserInfo);
	$Template->expire();
	$Template->render("ibanking.lock");
}, 'GET');

$Route->add('/auth/lock/reset', function () {
	$Template = new Apps\Template;
	$Template->expire();
	$Template->redirect("/");
}, 'GET');



/***
 * Banco Routes
 * 
 */
$Route->add('/auth/register/previous', function () {
    $Template = new Apps\Template;
    $regstep = (int)$Template->storage("regstep");
    if ($regstep <= 1) {
        $Template->expire();
    } elseif ($regstep > 1) {
        $regstep = $regstep - 1;
    }
    $Template->store("regstep", $regstep);
    $Template->redirect("/auth/register");
}, 'GET');


$Route->add('/banco/auth/register', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;
    $MysqliDb = new Apps\MysqliDb;

    $Data = $Model->post($_POST);
    $regstep = (int)$Template->storage("regstep");
    $RegData = isset($Template->data['RegData']) ? $Template->data['RegData'] : array();

    switch ($regstep) {
        case 0:
            if ($Template->auth) {
                $Template->expire();
            }
            $RegData["sex"] = $Data->sex;
            $RegData["email"] = $Data->email;
            $RegData["mobile"] = $Data->mobile;
            $RegData["firstname"] = $Data->firstname;
            $RegData["lastname"] = $Data->lastname;
            $Template->store("RegData", $RegData);
            $Template->store("regstep", 1);
            $Template->redirect("/auth/register");
            break;
        case 1:
            $RegData["address"] = $Data->address;
            $RegData["address2"] = $Data->address2;
            $RegData["country"] = $Data->country;
            $RegData["state"] = $Data->state;
            $RegData["city"] = $Data->city;
            $RegData["zipcode"] = $Data->zipcode;
            $Template->store("RegData", $RegData);
            $Template->store("regstep", 2);
            $Template->redirect("/auth/register");
            break;
        case 2:
            $regmail =  md5($RegData["email"]);
            if ($_FILES["avatar"]['size'] > 0) {
                $handle = new \Verot\Upload\Upload($_FILES["avatar"]);
                $handle->image_resize    = true;
                $handle->image_y    = 500;
                $handle->image_x    = 500;
                $FileDir = "{$Template->store}accounts/profiles/{$regmail}/";
                $handle->process($FileDir);
                if ($handle->processed) {
                    $RegData["avatar"] = $handle->file_dst_pathname;
                    $handle->clean();
                }
            }
            $Template->store("regstep", 3);
            $Template->store("RegData", $RegData);
            $Template->redirect("/auth/register");
            break;
        case 3:
            $RegData["currency"] = $Data->currency;
            $RegData["account_type"] = $Data->account_type;
            $Template->store("regstep", 4);
            $Template->store("RegData", $RegData);
            $Template->redirect("/auth/register");
            break;
        case 4:
            $regmail =  md5($RegData["email"]);
            if ($_FILES["identification"]['size'] > 0) {
                $handle = new \Verot\Upload\Upload($_FILES["identification"]);
                $handle->image_resize    = true;
                $handle->image_y    = 500;
                $handle->image_x    = 500;
                $FileDir = "{$Template->store}accounts/profiles/{$regmail}/";
                $handle->process($FileDir);
                if ($handle->processed) {
                    $RegData["identification"] = $handle->file_dst_pathname;
                    $handle->clean();
                }
            }
            $Template->store("RegData", $RegData);
            $Template->store("regstep", 5);
            $Template->redirect("/auth/register");
            break;
        case 5:
            $regmail =  md5($RegData["email"]);
            if ($_FILES["utility"]['size'] > 0) {
                $handle = new \Verot\Upload\Upload($_FILES["utility"]);
                $handle->image_resize    = true;
                $handle->image_y    = 500;
                $handle->image_x    = 500;
                $FileDir = "{$Template->store}accounts/profiles/{$regmail}/";
                $handle->process($FileDir);
                if ($handle->processed) {
                    $RegData["utility"] = $handle->file_dst_pathname;
                    $handle->clean();
                }
            }
            $Template->store("RegData", $RegData);
            $Template->store("regstep", 6);
            $Template->redirect("/auth/register");
            break;

        case 6:


            $Temp_Password = $Banco->GenPassword(7);
            $newaccid = (int)$MysqliDb->insert("accounts", array(
                "sex" => $RegData['sex'],
                "title" => ($RegData['sex'] == "Male") ? "Mr" : "Mrs",
                "email" => $RegData['email'],
                "mobile" => $RegData['mobile'],
                "firstname" => $RegData['firstname'],
                "lastname" => $RegData['lastname'],
                "address" => $RegData['address'],
                "address2" => $RegData['address2'],
                "country" => $RegData['country'],
                "state" => $RegData['state'],
                "city" => $RegData['city'],
                "zipcode" => $RegData['zipcode'],
                "avatar" => $RegData['avatar'],
                "currency" => $RegData['currency'],
                "account_type" => $RegData['account_type'],
                "identification" => $RegData['identification'],
                "utility" => $RegData['utility'],
                "kyc" => 1,
                "password" => $Temp_Password,
                "new_account" => 1,
                "reset_password" => 1
            ));

            if ($newaccid) {

                $fullname = "{$RegData['firstname']} {$RegData['lastname']}";
                $Template->store("newaccid", $newaccid);

                //SMS HERE//
                // $sent = $SMSLive->send($Login->mobile, "");
                //SMS HERE//

                $subject = "Welcome to Citizens Bank";
                $mailbody = "<p>Congratulations <strong>{$fullname}</strong>!</p>
                <p>Your application has been submitted. However, our team will begin review of the details and documents you submitted.</p>
                <p>You will recieve your account details as soon as we have completed the verification and profiling.</p>
                ";

                if (PHPMAILER_IS_HTML) {
                    //Email Notix//
                    $Mailer = new Apps\Emailer();
                    $EmailTemplate = new Apps\EmailTemplate('mails.default');
                    $EmailTemplate->subject = $subject;
                    $EmailTemplate->fullname = $fullname;
                    $EmailTemplate->mailbody = $mailbody;
                    $Mailer->subject = $subject;
                    $Mailer->SetTemplate($EmailTemplate);
                    $Mailer->toEmail = $RegData['email'];
                    $Mailer->toName = $fullname;
                    $Mailer->send();
                    //Email Notix//
                } else {
                    //Email Notix//
                    try {
                        $PHPmailer = new Apps\PHPMailer(true);
                        $PHPmailer->CharSet = "UTF-8";
                        $PHPmailer->AddAddress($RegData['email'],  $fullname);
                        $PHPmailer->setFrom(fromEmail, fromName);
                        $PHPmailer->AddReplyTo(replyEmail, replyName);
                        $PHPmailer->Subject = $subject;
                        $PHPmailer->Body = $mailbody;
                        $sent = $PHPmailer->Send();
                    } catch (\Exception $e) {
                        $PHPmailer->ClearAllRecipients();
                        $sent = 0;
                    }
                    //Email Notix//
                }

                $Template->redirect("/auth/lock");
            } else {
                $Template->store("regstep", 0);
                $Template->setError("Registration of your account failed, kindly try again or contact support.", "danger", "/ibanking/auth/register");
                $Template->redirect("/auth/register");
            }

            break;

        default:
            $Template->expire();
            $Template->redirect("/auth/register");
            break;
    }

    $Template->setError("Registration of your account failed, kindly try again or contact support.", "danger", "/ibanking/auth/register");
    $Template->redirect("/auth/register");
}, 'POST');


$Route->add('/banco/auth/login', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;
    $MysqliDb = new Apps\MysqliDb;

    $Data = $Model->post($_POST);

    $username = $Data->username;
    $password = $Data->password;

    $MysqliDb->where("accid", $username)->where("password", $password);
    $UserInfo = $MysqliDb->getOne("accounts");


    if (isset($UserInfo['accid'])) {

    	$accid = $UserInfo['accid'];
    	$otp_enabled = $UserInfo['otp_enabled'];

        if ($UserInfo['otp_enabled']) {
           
			$otp = $Banco->GenOTP(6);

            $Banco->SetUserInfo($UserInfo['accid'], "otp_pending", 1);
            $Banco->SetUserInfo($UserInfo['accid'], "otp", strtoupper($otp));
            $Banco->SetUserInfo($UserInfo['accid'], "otp_time", date("Y-m-d g:i:S"));

            $fullname = "{$UserInfo['firstname']} {$UserInfo['lastname']}";

            $Template->store("accid", $UserInfo['accid']);

            $message = "NEVER DISCLOSE YOUR OTP TO ANYONE. Your OTP to login is {$otp}. Enquiry? Call Online Banking Support.";
            // $sent = $SMSLive->send($Login->mobile, $message);
            $subject = "Your OTP to login is {$otp}";


            if (PHPMAILER_IS_HTML) {
                //Email Notix//
                $Mailer = new Apps\Emailer();
                $EmailTemplate = new Apps\EmailTemplate('mails.otp');
                $EmailTemplate->subject = $subject;
                $EmailTemplate->otp = $otp;
                $EmailTemplate->fullname = $fullname;
                $EmailTemplate->mailbody = $message;
                $Mailer->subject = $subject;

                $Mailer->fromName = fromName;
                $Mailer->fromEmail = fromEmail;
                $Mailer->replyName = replyName;
                $Mailer->replyEmail = replyEmail;

                $Mailer->SetTemplate($EmailTemplate);
                $Mailer->toEmail = $UserInfo['email'];
                $Mailer->toName = $fullname;
                $sent = $Mailer->send();
                //Email Notix//
            } else {
                //Email Notix//
                try {
                    $PHPmailer = new Apps\PHPMailer(true);
                    $PHPmailer->CharSet = "UTF-8";
                    $PHPmailer->AddAddress($UserInfo['email'],  $fullname);
                    $PHPmailer->setFrom(fromEmail, fromName);
                    $PHPmailer->AddReplyTo(replyEmail, replyName);
                    $PHPmailer->Subject = $subject;
                    $PHPmailer->Body = $message;
                    $sent = $PHPmailer->Send();
                } catch (\Exception $e) {
                    $PHPmailer->ClearAllRecipients();
                    $sent = 0;
                }
                //Email Notix//
            }

            $Template->setError("We sent you a One Time Pin for login", "success", "/ibanking/auth/otp");
            $Template->redirect("/auth/otp");
        } else {

            $Template->authorize($accid);
            $Device = new Apps\Device;
            $Banco->LogActivity($accid, $Device->get_ip(), $Device->get_os(), $Device->get_browser(), $Device->get_device());

            $fullname = "{$UserInfo['firstname']} {$UserInfo['lastname']}";
            $message = "<p>Hello {$fullname}</p>
            <p>Your account has just been accessed from a {$Device->get_device()} with the information below.</p>
            <p>
            IP Address: <strong>{$Device->get_ip()}</strong><br/>
            Operating System: <strong>{$Device->get_os()}</strong><br/>
            System Browser: <strong>{$Device->get_browser()}</strong><br/>
            </p>
            <p>If this is not you, contact your account officer for urgent action.</p>
            ";

            // $sent = $SMSLive->send($Login->mobile, $message);
            $subject = "New Login from: {$Device->get_ip()}";


            if (PHPMAILER_IS_HTML) {
                //Email Notix//
                $Mailer = new Apps\Emailer();
                $EmailTemplate = new Apps\EmailTemplate('mails.default');
                $EmailTemplate->subject = $subject;
                $EmailTemplate->fullname = $fullname;
                $EmailTemplate->mailbody = $message;
                $Mailer->subject = $subject;
                $Mailer->SetTemplate($EmailTemplate);
                $Mailer->toEmail = $UserInfo['email'];
                $Mailer->toName = $fullname;
                $Mailer->send();
                //Email Notix//
            } else {
                //Email Notix//
                try {
                    $PHPmailer = new Apps\PHPMailer(true);
                    $PHPmailer->CharSet = "UTF-8";
                    $PHPmailer->AddAddress($UserInfo['email'],  $fullname);
                    $PHPmailer->setFrom(fromEmail, fromName);
                    $PHPmailer->AddReplyTo(replyEmail, replyName);
                    $PHPmailer->Subject = $subject;
                    $PHPmailer->Body = $message;
                    $sent = $PHPmailer->Send();
                } catch (\Exception $e) {
                    $PHPmailer->ClearAllRecipients();
                    $sent = 0;
                }
                //Email Notix//
            }



            $Template->redirect("/");
        }
    }

    $Template->setError("Login details incoorect, recheck and try again", "danger", "/ibanking/auth/login");
    $Template->redirect("/auth/login");
}, 'POST');


$Route->add('/banco/auth/otp', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;
    $MysqliDb = new Apps\MysqliDb;

    $accid = $Template->storage("accid");

    $Data = $Model->post($_POST);
    $otp = $Data->otp;

    $MysqliDb->where("accid", $accid)->where("otp", $otp);
    $UserInfo = $MysqliDb->getOne("accounts");

    if (isset($UserInfo['accid'])) {

        $Banco->SetUserInfo($UserInfo['accid'], "otp_pending", 0);
        $Banco->SetUserInfo($UserInfo['accid'], "otp", null);
        $Banco->SetUserInfo($UserInfo['accid'], "otp_time", date("Y-m-d g:i:S"));

        $Template->authorize($accid);
        $Device = new Apps\Device;
        $Banco->LogActivity($accid, $Device->get_ip(), $Device->get_os(), $Device->get_browser(), $Device->get_device());

        $fullname = "{$UserInfo['firstname']} {$UserInfo['lastname']}";
        $message = "<p>Hello {$fullname}</p>
        <p>Your account has just been accessed from a {$Device->get_device()} with the information below.</p>
        <p>
        IP Address: <strong>{$Device->get_ip()}</strong><br/>
        Operating System: <strong>{$Device->get_os()}</strong><br/>
        System Browser: <strong>{$Device->get_browser()}</strong><br/>
        </p>
        <p>If this is not you, contact your account officer for urgent action.</p>
        ";
        // $sent = $SMSLive->send($Login->mobile, $message);
        $subject = "New Login from: {$Device->get_ip()}";


        if (PHPMAILER_IS_HTML) {
            //Email Notix//
            $Mailer = new Apps\Emailer();
            $EmailTemplate = new Apps\EmailTemplate('mails.default');
            $EmailTemplate->subject = $subject;
            $EmailTemplate->fullname = $fullname;
            $EmailTemplate->mailbody = $message;
            $Mailer->subject = $subject;
            $Mailer->SetTemplate($EmailTemplate);
            $Mailer->toEmail = $UserInfo['email'];
            $Mailer->toName = $fullname;
            $Mailer->send();
            //Email Notix//
        } else {
            //Email Notix//
            try {
                $PHPmailer = new Apps\PHPMailer(true);
                $PHPmailer->CharSet = "UTF-8";
                $PHPmailer->AddAddress($UserInfo['email'],  $fullname);
                $PHPmailer->setFrom(fromEmail, fromName);
                $PHPmailer->AddReplyTo(replyEmail, replyName);
                $PHPmailer->Subject = $subject;
                $PHPmailer->Body = $message;
                $sent = $PHPmailer->Send();
            } catch (\Exception $e) {
                $PHPmailer->ClearAllRecipients();
                $sent = 0;
            }
            //Email Notix//
        }

        $Template->redirect("/");
    }

    $Template->setError("One Time Password is incorrect, recheck and try again", "danger", "/ibanking/auth/otp");
    $Template->redirect("/auth/otp");
}, 'POST');




$Route->add('/banco/dashboard/profile', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;

    $accid = $Template->storage("accid");

    $Data = $Model->post($_POST);

    $Banco->SetUserInfo($accid, "firstname", $Data->firstname);
    $Banco->SetUserInfo($accid, "lastname", $Data->lastname);
    $Banco->SetUserInfo($accid, "email", $Data->email);
    $Banco->SetUserInfo($accid, "mobile", $Data->mobile);
    $Banco->SetUserInfo($accid, "address", $Data->address);
    $Banco->SetUserInfo($accid, "address2", $Data->address2);

    $Banco->SetUserInfo($accid, "city", $Data->city);
    $Banco->SetUserInfo($accid, "zipcode", $Data->zipcode);

    $Banco->SetUserInfo($accid, "state", $Data->state);
    $Banco->SetUserInfo($accid, "country", $Data->country);

    if ($_FILES["avatar"]['size'] > 0) {
        $handle = new \Verot\Upload\Upload($_FILES["avatar"]);
        $handle->image_resize    = true;
        $handle->image_y    = 500;
        $handle->image_x    = 500;
        $FileDir = "{$Template->store}accounts/profiles/{$accid}/";
        $handle->process($FileDir);
        if ($handle->processed) {
            $photos = $handle->file_dst_pathname;
            $Banco->SetUserInfo($accid, "avatar", $photos);
            $handle->clean();
        }
    }

    $Template->setError("Profile updated successfully", "success", "/ibanking/profile");
    $Template->redirect("/profile");
}, 'POST');



$Route->add('/banco/dashboard/settings', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;

    $accid = $Template->storage("accid");

    $Data = $Model->post($_POST);

    $otp_enabled = 0;
    if (isset($Data->otp_enabled)) {
        $otp_enabled = 1;
    }
    $email_notix = 0;
    if (isset($Data->email_notix)) {
        $email_notix = 1;
    }
    $sms_notix = 0;
    if (isset($Data->sms_notix)) {
        $sms_notix = 1;
    }
    $profile_notix = 0;
    if (isset($Data->profile_notix)) {
        $profile_notix = 1;
    }

    $Banco->SetUserInfo($accid, "otp_enabled", $otp_enabled);
    $Banco->SetUserInfo($accid, "email_notix", $email_notix);
    $Banco->SetUserInfo($accid, "sms_notix", $sms_notix);
    $Banco->SetUserInfo($accid, "profile_notix", $profile_notix);

    $Template->setError("Settings updated successfully", "success", "/ibanking/settings");
    $Template->redirect("/settings");
}, 'POST');


$Route->add('/banco/auth/reset', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;
    $Template = new Apps\Template;
    $Data = $Model->post($_POST);
    $username = $Data->username;
    $UserInfo = $Banco->UserInfo($username);
    if (isset($UserInfo->accid)) {

        $GenPassword = $Banco->GenPassword(6);
        $Banco->SetUserInfo($UserInfo->accid, "password", $GenPassword);
        $Banco->SetUserInfo($UserInfo->accid, "reset_password", 1);

        $fullname = "{$UserInfo->firstname} {$UserInfo->lastname}";

        // $sent = $SMSLive->send($Login->mobile, $message);
        $subject = "Reset password, one more step";
        $mailbody = "<p>Hello {$fullname}</p>
        <p>A new temporary password has been generated for your account. You are expected to change this password on your next login.</p>";


        if (PHPMAILER_IS_HTML) {
            //Email Notix//
            $Mailer = new Apps\Emailer();
            $EmailTemplate = new Apps\EmailTemplate('mails.reset');
            $EmailTemplate->subject = $subject;
            $EmailTemplate->password = $GenPassword;
            $EmailTemplate->fullname = $fullname;
            $EmailTemplate->mailbody = $mailbody;
            $Mailer->subject = $subject;
            $Mailer->SetTemplate($EmailTemplate);
            $Mailer->toEmail = $UserInfo->email;
            $Mailer->toName = $fullname;
            $Mailer->send();
            //Email Notix//
        } else {
            //Email Notix//
            try {
                $PHPmailer = new Apps\PHPMailer(true);

                $mailbody = "<p>Hello {$fullname}</p>
                <p>A new temporary password has been generated for your account.</p> 
                <p>Your password is: <strong>{$GenPassword}</strong></p> 
                <p>You are expected to change this password on your next login.</p>";

                $PHPmailer->CharSet = "UTF-8";
                $PHPmailer->AddAddress($UserInfo->email,  $fullname);
                $PHPmailer->setFrom(fromEmail, fromName);
                $PHPmailer->AddReplyTo(replyEmail, replyName);
                $PHPmailer->Subject = $subject;
                $PHPmailer->Body = $mailbody;
                $sent = $PHPmailer->Send();
            } catch (\Exception $e) {
                $PHPmailer->ClearAllRecipients();
                $sent = 0;
            }
            //Email Notix//
        }

        $Template->setError("We sent you a temporary password.", "success", "/ibanking/auth/reset");
        $Template->redirect("/auth/reset");
    }

    $Template->setError("Login details incorrect, recheck and try again", "danger", "/ibanking/auth/reset");
    $Template->redirect("/auth/reset");
}, 'POST');



$Route->add('/banco/auth/changepassword', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;

    $accid = $Template->storage("accid");
    $User = $Banco->UserInfo($accid);
    $curr_password = $User->password;

    $Data = $Model->post($_POST);

    if ($Data->oldpass != $curr_password) {
        $Template->setError("Current password is not correct", "danger", "/ibanking");
        $Template->redirect("");
    }


    if ($Data->newpass != $Data->newpass1) {
        $Template->setError("Password did not match", "danger", "/ibanking");
        $Template->redirect("");
    }

    $Banco->SetUserInfo($accid, "password", $Data->newpass);
    $Banco->SetUserInfo($accid, "reset_password", 0);
    $Banco->SetUserInfo($accid, "new_account", 0);

    $Device = new Apps\Device;

    $fullname = "{$User->firstname} {$User->lastname}";
    $message = "<p>Hello {$fullname}</p>
    <p>Your account password has just been changed from a {$Device->get_device()} with the information below.</p>
    <p>
    IP Address: <strong>{$Device->get_ip()}</strong><br/>
    Operating System: <strong>{$Device->get_os()}</strong><br/>
    System Browser: <strong>{$Device->get_browser()}</strong><br/>
    </p>
    <p>If this is not you, contact your account officer for urgent action.</p>
    ";
    // $sent = $SMSLive->send($Login->mobile, $message);
    $subject = "Password Changed";


    if (PHPMAILER_IS_HTML) {
        //Email Notix//
        $Mailer = new Apps\Emailer();
        $EmailTemplate = new Apps\EmailTemplate('mails.default');
        $EmailTemplate->subject = $subject;
        $EmailTemplate->fullname = $fullname;
        $EmailTemplate->mailbody = $message;
        $Mailer->subject = $subject;
        $Mailer->SetTemplate($EmailTemplate);
        $Mailer->toEmail = $User->email;
        $Mailer->toName = $fullname;
        $Mailer->send();
        //Email Notix//
    } else {
        //Email Notix//
        try {
            $PHPmailer = new Apps\PHPMailer(true);
            $PHPmailer->CharSet = "UTF-8";
            $PHPmailer->AddAddress($User->email,  $fullname);
            $PHPmailer->setFrom(fromEmail, fromName);
            $PHPmailer->AddReplyTo(replyEmail, replyName);
            $PHPmailer->Subject = $subject;
            $PHPmailer->Body = $message;
            $sent = $PHPmailer->Send();
        } catch (\Exception $e) {
            $PHPmailer->ClearAllRecipients();
            $sent = 0;
        }
        //Email Notix//
    }


    $Template->setError("Password updated successfully", "success", "/");
    $Template->redirect("/");
}, 'POST');





$Route->add('/banco/dashboard/sendmoney', function () {

    $Model = new Apps\Model;
    $Banco = new Apps\Banco;

    $Template = new Apps\Template;

    $accid = $Template->storage("accid");
    $ThisUser = $Banco->UserInfo($accid);


    $Data = $Model->post($_POST);
    $paystep = (int)$Template->storage("paystep");
    $PayData = isset($Template->data['PayData']) ? $Template->data['PayData'] : array();
    if (isset($Data->startpay)) {
        $paystep = 0;
        $PayData = array();
    }

    if (isset($Data->newpin)) {

        $pin = $Data->pin;
        $Banco->SetUserInfo($accid, "pin", $pin);

        $Device = new Apps\Device;
        $fullname = "{$ThisUser->firstname} {$ThisUser->lastname}";
        $message = "<p>Hello {$fullname}</p>
        <p>Your account Transaction PIN has just been changed from a {$Device->get_device()} with the information below.</p>
        <p>
        IP Address: <strong>{$Device->get_ip()}</strong><br/>
        Operating System: <strong>{$Device->get_os()}</strong><br/>
        System Browser: <strong>{$Device->get_browser()}</strong><br/>
        </p>
        <p>If this is not you, contact your account officer for immediate action.</p>
        ";

        // $sent = $SMSLive->send($Login->mobile, $message);
        $subject = "PIN Changed Successfully";

        if (PHPMAILER_IS_HTML) {
            //Email Notix//
            $Mailer = new Apps\Emailer();
            $EmailTemplate = new Apps\EmailTemplate('mails.default');
            $EmailTemplate->subject = $subject;
            $EmailTemplate->fullname = $fullname;
            $EmailTemplate->mailbody = $message;
            $Mailer->subject = $subject;
            $Mailer->SetTemplate($EmailTemplate);
            $Mailer->toEmail = $ThisUser->email;
            $Mailer->toName = $fullname;
            $Mailer->send();
            //Email Notix//
        } else {
            //Email Notix//
            try {
                $PHPmailer = new Apps\PHPMailer(true);
                $PHPmailer->CharSet = "UTF-8";
                $PHPmailer->AddAddress($ThisUser->email,  $fullname);
                $PHPmailer->setFrom(fromEmail, fromName);
                $PHPmailer->AddReplyTo(replyEmail, replyName);
                $PHPmailer->Subject = $subject;
                $PHPmailer->Body = $message;
                $sent = $PHPmailer->Send();
            } catch (\Exception $e) {
                $PHPmailer->ClearAllRecipients();
                $sent = 0;
            }
            //Email Notix//
        }



        $Template->setError("Transaction PIN set successfully", "success", "/ibanking/transfer");
        $Template->redirect("/transfer");
    }

    switch ($paystep) {
        case 0:
            $PayData['amount'] = $Data->amount;
            $Template->store("PayData", $PayData);
            $Template->store("paystep", 1);
            $Template->setError("Transfer transaction started", "success", "/ibanking/transfer");
            $Template->redirect("/transfer");
            break;
        case 1:
            $PayData['name'] = $Data->name;
            $PayData['bankname'] = $Data->bankname;
            $PayData['bankaddress'] = $Data->bankaddress;
            $PayData['swiftcode'] = $Data->swiftcode;
            $PayData['iban'] = $Data->iban;
            $PayData['abaroutine'] = $Data->abaroutine;
            $PayData['accno'] = $Data->accno;
            $PayData['accname'] = $Data->accname;

            $Template->store("PayData", $PayData);
            $Template->store("paystep", 2);

            $Template->setError("Transfer information saved", "success", "/ibanking/transfer");
            $Template->redirect("/transfer");

            break;
        case 2:

            $securepin = $Data->securepin;
            if ($ThisUser->pin != $securepin) {
                $Template->setError("Incorrect Transaction PIN", "danger", "/ibanking/transfer");
                $Template->redirect("/transfer");
            }
            $PayData['pin'] = $securepin;

            if ($ThisUser->otp_enabled) {

                $otp = $Banco->GenOTP(6);
                $Banco->SetUserInfo($accid, "otp_pending", 1);
                $Banco->SetUserInfo($accid, "otp", strtoupper($otp));
                $Banco->SetUserInfo($accid, "otp_time", date("Y-m-d g:i:S"));
                $fullname = "{$ThisUser->firstname} {$ThisUser->lastname}";
                $message = "NEVER DISCLOSE YOUR OTP TO ANYONE. Your Transfer OTP is {$otp}. Enquiry? Call Online Banking Support.";
                // $sent = $SMSLive->send($Login->mobile, $message);
                $subject = "Your OTP for Transfer is {$otp}";



                if (PHPMAILER_IS_HTML) {
                    //Email Notix//
                    $Mailer = new Apps\Emailer();
                    $EmailTemplate = new Apps\EmailTemplate('mails.otp');
                    $EmailTemplate->subject = $subject;
                    $EmailTemplate->otp = $otp;
                    $EmailTemplate->fullname = $fullname;
                    $EmailTemplate->mailbody = $message;
                    $Mailer->subject = $subject;
                    $Mailer->SetTemplate($EmailTemplate);
                    $Mailer->toEmail = $ThisUser->email;
                    $Mailer->toName = $fullname;
                    $Mailer->send();
                    //Email Notix//
                } else {
                    //Email Notix//
                    try {
                        $PHPmailer = new Apps\PHPMailer(true);
                        $PHPmailer->CharSet = "UTF-8";
                        $PHPmailer->AddAddress($ThisUser->email,  $fullname);
                        $PHPmailer->setFrom(fromEmail, fromName);
                        $PHPmailer->AddReplyTo(replyEmail, replyName);
                        $PHPmailer->Subject = $subject;
                        $PHPmailer->Body = $message;
                        $sent = $PHPmailer->Send();
                    } catch (\Exception $e) {
                        $PHPmailer->ClearAllRecipients();
                        $sent = 0;
                    }
                    //Email Notix//
                }



                $Template->store("PayData", $PayData);
                $Template->store("paystep", 3);
                $Template->setError("Transaction PIN verified successfully", "success", "/ibanking/transfer");
                $Template->redirect("/transfer");
            }

            $Template->store("PayData", $PayData);
            $Template->store("paystep", 4);
            $Template->setError("Transaction PIN verified successfully", "success", "/ibanking/transfer");
            $Template->redirect("/transfer");
            break;

        case 3:

            if (isset($Data->setotp)) {
                $otp = $Data->otp;
                if ($otp != $ThisUser->otp) {
                    $Template->setError("Incorrect One Time Password", "danger", "/ibanking/transfer");
                    $Template->redirect("/transfer");
                }
                $Banco->SetUserInfo($accid, "otp_pending", 0);
                $Banco->SetUserInfo($accid, "otp", null);
                $Banco->SetUserInfo($accid, "otp_time", date("Y-m-d g:i:S"));

                $Template->store("paystep", 4);
                $Template->setError("One Time Password Verified", "success", "/ibanking/transfer");
                $Template->redirect("/transfer");
            }

            $Template->store("paystep", 4);
            $Template->redirect("/transfer");

            break;

        case 4:

            $MysqliDb = new Apps\MysqliDb;
            $transferid = $MysqliDb->insert("transfers", [
                "amount" => $PayData['amount'],
                "accid" => $accid,
                "name" => $PayData['name'],
                "bankname" => $PayData['name'],
                "bankaddress" => $PayData['name'],
                "swiftcode" => $PayData['swiftcode'],
                "iban" => $PayData['iban'],
                "abaroutine" => $PayData['abaroutine'],
                "accno" => $PayData['accno'],
                "accname" => $PayData['accname']
            ]);

            $PayData['transferid'] = $transferid;

            $Template->store("PayData", $PayData);
            $Template->store("paystep", 5);
            $Template->redirect("/transfer");

            break;

        case 6:

            $transfer_error = $Data->transfer_error;
            $error_code = $Data->error_code;
            $user_error_code = $ThisUser->error_code;
            if ($user_error_code != $error_code) {
                if ($transfer_error == "taxcode") {
                    $Template->setError("Incorrect Tax Verification Code", "danger", "/ibanking/transfer");
                } elseif ($transfer_error == "aml") {
                    $Template->setError("Incorrect Anti-Money Laundering Clearance Code", "danger", "/ibanking/transfer");
                } elseif ($transfer_error == "uvc") {
                    $Template->setError("Incorrect AUniversal Verification Code", "danger", "/ibanking/transfer");
                }
                $Template->redirect("/transfer");
            }
            $PayData['transfer_error_cleared'] = 1;
            $Template->store("PayData", $PayData);
            $Template->store("paystep", 7);
            $Template->redirect("/transfer");
            break;

        default:
            # code...
            break;
    }

    $Template->setError("Funds Transfer Failed", "danger", "/ibanking");
    $Template->redirect("");
}, 'POST');



/***
 * 	Admin Routes
 * 	@Admin
 */


 $Route->add('/admin', function () {
	$Core = new Apps\Core;
	$Template = new Apps\Template('/admin/login');
	$Template->addheader("admin.layouts.header");
	$Template->addfooter("admin.layouts.footer");
	$Template->assign("title", "Antthill.Admin");
	$Template->assign("Activities", $Core->AdminListVisitors());
	$Template->assign("expanded", false);
	$Template->render("admin.admin");
}, 'GET');


$Route->add('/admin/login', function () {
	$Template = new Apps\Template;
	$MysqliDb = new Apps\MysqliDb;
	$uninstalled = [];
	$sql_list = ['accounts', 'activities', 'pages', 'settings', 'cms', 'webparts','transfers','currencies','transactions'];
	foreach ($sql_list as $sql) {
		if (!(int)$MysqliDb->tableExists($sql)) {
			$uninstalled[] = $sql;
		}
	}
	if (count($uninstalled)) {
		$Template->assign("title", "Setup Database");
		$Template->assign("uninstalled", $uninstalled);
		$Template->render("admin.setup");
	} else {
		$Template->assign("title", "Admin: Login");
		$Template->render("admin.login");
	}
}, 'GET');


$Route->add("/admin/approve-account/{accid}", function ($accid) {

	$Template = new Apps\Template('/admin/login');
	$Banco = new Apps\Banco;
	$ThisUser = $Banco->UserInfo($accid);

	$fullname = "{$ThisUser->firstname} {$ThisUser->lastname}";

	//SMS HERE//
	// $sent = $SMSLive->send($Login->mobile, "");
	//SMS HERE//

	$subject = "Account Ready : {$accid}";
	$mailbody = "<p>Congratulations <strong>{$fullname}</strong>!</p>
            <p>Your accoutn has now been approved for and ready for use.</p>
			<p>Use the details below to login to your account. You will be mandated to change your login password on first logon.</p>
			<p>
			Account Number: <strong>$ThisUser->accid</strong><br/>
			User Name: <strong>$ThisUser->accid</strong><br/>
			Temporary Password: <strong>{$ThisUser->password}</strong><br/>
			Temporary PIN : <strong>{$ThisUser->pin}</strong>
			</p>
			<p>Thank you for choosing Citizens Bank Canada.</p>
            ";

	//Email Notix//
	$Mailer = new Apps\Emailer();
	$EmailTemplate = new Apps\EmailTemplate('mails.default');
	$EmailTemplate->subject = $subject;
	$EmailTemplate->fullname = $fullname;
	$EmailTemplate->mailbody = $mailbody;
	$Mailer->subject = $subject;
	$Mailer->SetTemplate($EmailTemplate);
	$Mailer->toEmail = $ThisUser->email;
	$Mailer->toName = $fullname;
	$Mailer->send();
	//Email Notix//

	$Template->redirect("/admin/edit-account/account/{$accid}/edit");
	
}, 'GET');




$Route->add('/banco/admin/profile', function () {

	$Model = new Apps\Model;
	$Banco = new Apps\Banco;

	$Template = new Apps\Template;
	$Data = $Model->post($_POST);

	$accid = $Data->accid;

	$enabled = 0;
	if (isset($Data->enabled)) {
		$enabled = 1;
	}
	$Banco->SetUserInfo($accid, "enabled", $enabled);

	$denytransfer = 0;
	if (isset($Data->denytransfer)) {
		$denytransfer = 1;
	}
	$Banco->SetUserInfo($accid, "denytransfer", $denytransfer);

	$enable_error = 0;
	if (isset($Data->enable_error)) {
		$enable_error = 1;
	}
	$Banco->SetUserInfo($accid, "enable_error", $enable_error);
	
	$kyc_approved = 0;
	if (isset($Data->kyc_approved)) {
		$kyc_approved = 1;
	}
	$Banco->SetUserInfo($accid, "kyc_approved", $kyc_approved);

	$Banco->SetUserInfo($accid, "transfer_error", $Data->transfer_error);
	$Banco->SetUserInfo($accid, "error_code", $Data->error_code);


	$Banco->SetUserInfo($accid, "firstname", $Data->firstname);
	$Banco->SetUserInfo($accid, "lastname", $Data->lastname);
	$Banco->SetUserInfo($accid, "email", $Data->email);
	$Banco->SetUserInfo($accid, "mobile", $Data->mobile);
	$Banco->SetUserInfo($accid, "address", $Data->address);
	$Banco->SetUserInfo($accid, "address2", $Data->address2);

	$Banco->SetUserInfo($accid, "city", $Data->city);
	$Banco->SetUserInfo($accid, "zipcode", $Data->zipcode);

	$Banco->SetUserInfo($accid, "state", $Data->state);
	$Banco->SetUserInfo($accid, "country", $Data->country);

	$Template->setError("Profile updated successfully", "success", "/admin/edit-account/account/{$accid}/edit");
	$Template->redirect("/admin/edit-account/account/{$accid}/edit");
}, 'POST');




$Route->add('/admin/account/statement', function () {
	
	$Core = new Apps\Core;
	$Banco = new Apps\Banco;

	$Template = new Apps\Template("/admin/login");

	$Template->assign("title", "Transactions");
	$Template->assign("Transactions", $Banco->AllTransactions());

	$Template->assign("expanded", true);
	$Template->render("admin.routes.statement");
	
}, 'GET');


$Route->add('/admin/{route}', function ($route) {

	$Core = new Apps\Core;
	$Banco = new Apps\Banco;

	$Template = new Apps\Template("/admin/login");
	$Template->addheader("admin.layouts.header");
	$Template->addfooter("admin.layouts.footer");
	$Template->assign("title", "Anthill Pro Admin");

	if ($route == "pages") {
		$Template->assign("title", "Manage Pages");
		$Template->assign("pages", $Core->LoadPages());
	} elseif ($route == "accounts") {
		$Template->assign("title", "Account & Users");
		$Template->assign("accounts", $Banco->adminUsers());
	} elseif ($route == "transactions") {
		$Template->assign("title", "Transactions");
		$Template->assign("Transactions", $Banco->AllTransactions());
	} elseif ($route == "add-page") {
		$Template->assign("title", "Add New Page");
		$Template->assign("parents", $Core->LoadParentMenus());
	} elseif ($route == "visitors") {
		$Template->assign("title", "Website Visitors");
		$Template->assign("Activities", $Core->AdminListVisitors());
	} elseif ($route == "settings") {
		$Template->assign("title", "Website Settings");
		$Template->assign("SiteInfos", $Core->SiteInfos());
	} elseif ($route == "profile") {
		$Template->assign("title", "User Profile");
	} elseif ($route == "webparts") {
		$Template->assign("title", "View Webparts");
		$directory = './templates/webparts/';
		$WebParts = array_diff(scandir($directory), array('..', '.'));
		$Template->assign("WebParts", $WebParts);
	}
	$Template->assign("expanded", true);
	$Template->render("admin.routes.{$route}");
}, 'GET');




$Route->add('/admin/page-webparts/page/{pageid}/add/{webpart}', function ($pageid, $webpart) {
	$Core = new Apps\Core;
	$Template = new Apps\Template("/admin/login");
	$PageInfo = $Core->PageInfo($pageid);
	$CheckWebParts = $Core->CheckWebParts($pageid, $webpart);
	if (!$CheckWebParts) {
		$Db = new Apps\MysqliDb;
		$Db->insert("webparts", [
			"page" => $pageid,
			"webpart" => $webpart,
		]);
		$Template->setError("Web Part Added to the Page successfully", "success", "/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
		$Template->redirect("/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
	} else {
		$Template->setError("Web Part was not added, it probably already existed", "danger", "/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
		$Template->redirect("/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
	}
}, 'GET');


$Route->add('/admin/page-webparts/page/{pageid}/remove/{webpart}/{webpartid}', function ($pageid, $webpart, $webpartid) {
	$Core = new Apps\Core;
	$Template = new Apps\Template("/admin/login");
	$PageInfo = $Core->PageInfo($pageid);
	$CheckWebParts = $Core->CheckWebParts($pageid, $webpart);
	if ($CheckWebParts) {

		$Db = new Apps\MysqliDb;
		$Db->where("page", $pageid)->where("webpart", $webpart)->delete("webparts", 1);

		$Db->where("pageid", $pageid)->where("webpart", $webpartid)->delete("cms");

		$Template->setError("Web Part deleted from the Page successfully", "success", "/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
		$Template->redirect("/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
	} else {
		$Template->setError("Web Part was not deleted, it probably deosn't exist", "danger", "/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
		$Template->redirect("/admin/page-webparts/page/{$pageid}/{$PageInfo->shortname}");
	}
}, 'GET');


$Route->add('/admin/{route}/page/{pid}/{shortname}', function ($route, $pid, $shortname) {

	$Core = new Apps\Core;
	$Template = new Apps\Template("/admin/login");

	$Template->addheader("admin.layouts.header");
	$Template->addfooter("admin.layouts.footer");
	$Template->assign("title", "Anthill Pro Admin");

	$Template->assign("pid", $pid);
	$Template->assign("shortname", $shortname);

	if ($route == "edit-page") {

		$Template->assign("title", "Edit page");

		$parents = $Core->LoadParentMenus();
		$pageinfo = $Core->LoadPageInfo($shortname);
		$Template->assign("pageinfo", $pageinfo);
		$Template->assign("parents", $parents);

		$cat = json_decode($pageinfo->categories);

		$Template->assign("cat", $cat);
	} elseif ($route == "delete-page") {
		$Template->assign("title", "Delete Page");

		$pageinfo = $Core->LoadPageInfo($shortname);
		$Template->assign("pageinfo", $pageinfo);
	} elseif ($route == "webparts") {

		$Template->assign("title", "List Webparts");

		$pageinfo = $Core->LoadPageInfo($shortname);
		$Template->assign("pageinfo", $pageinfo);
	} elseif ($route == "page-webparts") {
		$Template->assign("title", "Add/Remove Webparts");
		$directory = './templates/webparts/';
		$WebParts = array_diff(scandir($directory), array('..', '.'));
		$Template->assign("WebParts", $WebParts);
		$pageinfo = $Core->LoadPageInfo($shortname);
		$Template->assign("pageinfo", $pageinfo);
	}
	$Template->assign("expanded", true);
	$Template->render("admin.routes.{$route}");
}, 'GET');





























$Route->add('/ajax/{cmd}', function ($cmd) {

	$Core = new Apps\Core;
	$Template = new Apps\Template;
	$accid = $Template->storage("accid");
	$UserInfo = $Core->UserInfo($accid);

	if ($cmd == 'profile') {
		$Post = $Core->post($_POST);

		$password = $UserInfo->password;
		if (strlen($Post->password1) > 4 && strlen($Post->password2) > 4) {
			if ($Post->password1 === $Post->password2) {
				$password = $Post->password1;
			}
		}

		$Db = new Apps\MysqliDb;
		$Db->where("accid", $accid);
		$done = $Db->update("accounts", [
			"firstname" => $Post->firstname,
			"lastname" => $Post->lastname,
			"email" => $Post->email,
			"mobile" => $Post->mobile,
			"password" => $password
		]);

		$Template->redirect("/admin/profile");
	} elseif ($cmd == 'add-page') {

		$Post = $Core->post($_POST);

		$category = array();
		if (isset($Post->category)) {
			$category = $Post->category;
		}

		$category = json_encode($category);
		$parent = $Post->parent;
		$title = $Post->title;
		$pagestyle = $Post->type;
		$menutitle = $Post->menutitle;
		$sort = $Post->sort;

		$showheader = 0;
		if (isset($Post->showheader)) {
			$showheader = 1;
		}
		$showfooter = 0;
		if (isset($Post->showfooter)) {
			$showfooter = 1;
		}

		$Slugify = new Cocur\Slugify\Slugify();
		$shortname = $Slugify->slugify($menutitle);
		$photos = "";

		if (isset($_FILES['newsphoto'])) {
			$handle = new Verot\Upload\Upload($_FILES['newsphoto']);
			$path = "{$Template->store}images/pages/{$shortname}/";
			if ($handle->uploaded) {
				$handle->file_new_name_body	= md5(time());
				$handle->image_resize	= true;
				$handle->image_x	= 120;
				$handle->image_ratio_y	= true;
				$handle->process($path);
				if ($handle->processed) {
					$photos = "{$path}{$handle->file_dst_name}";
					$handle->clean();
				} else {
					echo 'error : ' . $handle->error;
				}
			}
		}

		$Db = new Apps\MysqliDb;
		$done = $Db->insert("pages", [
			"shortname" => $shortname,
			"categories" => $category,
			"parent" => $parent,
			"pagestyle" => $pagestyle,
			"title" => $title,
			"menutitle" => $menutitle,
			"sort" => $sort,
			"showheader" => $showheader,
			"showfooter" => $showfooter,
			"photo" => $photos
		]);
		$Template->redirect("/admin/pages");
	} elseif ($cmd == 'edit-page') {

		$Post = $Core->post($_POST);
		$pageid = $Post->pageid;
		$PageInfo = $Core->PageInfo($pageid);

		$category = array();
		if (isset($Post->category)) {
			$category = $Post->category;
		}

		$category = json_encode($category);

		$parent = $Post->parent;
		$rootpage = $Core->getSiteInfo('defaultlandingpage');
		if ($pageid == $rootpage) {
			$parent = 0;
		}
		$title = $Post->title;
		$pagestyle = $Post->type;
		$menutitle = $Post->menutitle;
		$sort = $Post->sort;

		$showheader = 0;
		if (isset($Post->showheader)) {
			$showheader = 1;
		}
		$showfooter = 0;
		if (isset($Post->showfooter)) {
			$showfooter = 1;
		}

		$Slugify = new Cocur\Slugify\Slugify();

		$shortname = $PageInfo->shortname;
		$new_shortname = $Slugify->slugify($menutitle);
		if ($shortname <> $new_shortname) {
			$shortname = $new_shortname;
		}
		$photos = "";

		if (isset($_FILES['newsphoto'])) {
			$handle = new Verot\Upload\Upload($_FILES['newsphoto']);
			$path = "{$Template->store}images/pages/{$shortname}/";
			if ($handle->uploaded) {
				$handle->file_new_name_body	= md5(time());
				$handle->image_resize	= true;
				$handle->image_x	= 120;
				$handle->image_ratio_y	= true;
				$handle->process($path);
				if ($handle->processed) {
					$photos = "{$path}{$handle->file_dst_name}";
					$handle->clean();
				} else {
					echo 'error : ' . $handle->error;
				}
			}
		}

		$Db = new Apps\MysqliDb;
		$Db->where("pageid", $pageid);
		$done = $Db->update("pages", [
			"shortname" => $shortname,
			"categories" => $category,
			"parent" => $parent,
			"pagestyle" => $pagestyle,
			"title" => $title,
			"menutitle" => $menutitle,
			"sort" => $sort,
			"showheader" => $showheader,
			"showfooter" => $showfooter,
			"photo" => $photos
		]);

		if ($PageInfo->pagestyle == "blog") {
			$Db->where("pageid", $pageid);
			$done = $Db->update("pages", [
				"content" => $Post->contents
			]);
		}

		$Template->redirect("/admin/edit-page/page/{$pageid}/{$shortname}");
	} elseif ($cmd == 'delete-page') {

		$Post = $Core->post($_POST);

		$pid = $Post->pageid;
		$Db = new Apps\MysqliDb;

		$defaultlandingpage = $Db->where("name", "defaultlandingpage")->getOne("settings");
		$defaultlandingpage = $defaultlandingpage['value'];

		$Db->where("pageid", $pid)->where("pageid", $defaultlandingpage, "!=")->delete("pages", 1);

		$Template->redirect("/admin/pages");
	} elseif ($cmd == 'delete-account') {

		$Post = $Core->post($_POST);

		$accid = $Post->accid;
		$Db = new Apps\MysqliDb;

		$Db->where("accid", $accid)->delete("accounts", 1);
		$Template->redirect("/admin/accounts");
	} elseif ($cmd == 'fund-account') {

		$Post = $Core->post($_POST);

		$accid = $Post->accid;
		$Banco = new Apps\Banco;

		$trtype = $Post->trtype;
		$amount = $Post->amount;
		$notes = $Post->notes;
		$created = $Post->datetime;

		$_amount = $Banco->UserBalance($accid, $amount);

		if ($trtype == "credit") {

			$x = $Banco->AdminCreditTransaction($accid, $amount, $trtype, $notes, $created);
			$Transaction = $Banco->TransactionInfo($x);
			$ThisUSer = $Banco->UserInfo($accid);
			$fullname = "{$ThisUSer->firstname} {$ThisUSer->lastname}";

			//SMS HERE//
			// $sent = $SMSLive->send($Login->mobile, "");
			//SMS HERE//

			$user_balance = $Banco->UserBalance($ThisUSer->accid, $ThisUSer->balance);

			$subject = "New Transaction";
			$mailbody = "<p>Hello <strong>{$fullname}</strong></p>
			<p>This is to inform you that a transaction has occurred on your account with Citizens Bank Canada with details below:</p>
			<p>
			Account Name:  <strong>{$fullname}</strong><br/>
			Transaction Type:  <strong>{$trtype} ALERT</strong><br/>
			Transaction Amount:  <strong>{$_amount}</strong><br/>
			Transaction Currency:  <strong>{$Transaction->currency}</strong><br/>
			Transaction Narration : <strong>{$Transaction->notes}</strong><br/>
			Date and Time: <strong>{$Transaction->created}</strong><br/>
			Available Balance: <strong>{$user_balance}</strong>
			</p>
            <p>Your account information is private. Please do not disclose your login credentials or card details to anyone. Avoid clicking on suspicious links in emails or text messages.</p>
            ";

			//Email Notix//
			$Mailer = new Apps\Emailer();
			$EmailTemplate = new Apps\EmailTemplate('mails.default');
			$EmailTemplate->subject = $subject;
			$EmailTemplate->fullname = $fullname;
			$EmailTemplate->mailbody = $mailbody;
			$Mailer->subject = $subject;
			$Mailer->SetTemplate($EmailTemplate);
			$Mailer->toEmail = $ThisUSer->email;
			$Mailer->toName = $fullname;
			$sent = $Mailer->send();
			//Email Notix//

		} elseif ($trtype == "debit") {

			$x = $Banco->AdminDebitTransaction($accid, $amount, $trtype, $notes, $created);

			$Transaction = $Banco->TransactionInfo($x);
			$ThisUSer = $Banco->UserInfo($accid);
			$fullname = "{$ThisUSer->firstname} {$ThisUSer->lastname}";

			//SMS HERE//
			// $sent = $SMSLive->send($Login->mobile, "");
			//SMS HERE//

			$user_balance = $Banco->UserBalance($ThisUSer->accid, $ThisUSer->balance);

			$subject = "New Transaction";
			$mailbody = "<p>Hello <strong>{$fullname}</strong></p>
			<p>This is to inform you that a transaction has occurred on your account with Citizens Bank Canada with details below:</p>
			<p>
			Account Name:  <strong>{$fullname}</strong><br/>
			Transaction Type:  <strong>{$trtype} ALERT</strong><br/>
			Transaction Amount:  <strong>{$_amount}</strong><br/>
			Transaction Currency:  <strong>{$ThisUSer->currency}</strong><br/>
			Transaction Narration : <strong>{$ThisUSer->currency}</strong><br/>
			Transaction Remarks :  <strong>{$Transaction->transid}</strong><br/>
			Date and Time: <strong>{$Transaction->transid}</strong><br/>
			Available Balance: <strong>{$user_balance}</strong>
			</p>
		<p>Your account information is private. Please do not disclose your login credentials or card details to anyone. Avoid clicking on suspicious links in emails or text messages.</p>
            ";

			//Email Notix//
			$Mailer = new Apps\Emailer();
			$EmailTemplate = new Apps\EmailTemplate('mails.default');
			$EmailTemplate->subject = $subject;
			$EmailTemplate->fullname = $fullname;
			$EmailTemplate->mailbody = $mailbody;
			$Mailer->subject = $subject;
			$Mailer->SetTemplate($EmailTemplate);
			$Mailer->toEmail = $ThisUSer->email;
			$Mailer->toName = $fullname;
			$sent = $Mailer->send();
			//Email Notix//

		} elseif ($trtype == "reverse") {

			$x = $Banco->AdminDebitTransaction($accid, $amount, $trtype, $notes, $created);
			$Transaction = $Banco->TransactionInfo($x);
			$ThisUSer = $Banco->UserInfo($accid);
			$fullname = "{$ThisUSer->firstname} {$ThisUSer->lastname}";

			//SMS HERE//
			// $sent = $SMSLive->send($Login->mobile, "");
			//SMS HERE//
			$user_balance = $Banco->UserBalance($ThisUSer->accid, $ThisUSer->balance);

			$subject = "New Transaction";
			$mailbody = "<p>Hello <strong>{$fullname}</strong></p>
			<p>This is to inform you that a transaction has occurred on your account with Citizens Bank Canada with details below:</p>
				<p>
				Account Name:  <strong>{$fullname}</strong><br/>
				Transaction Type:  <strong>{$trtype} ALERT</strong><br/>
				Transaction Amount:  <strong>{$_amount}</strong><br/>
				Transaction Currency:  <strong>{$ThisUSer->currency}</strong><br/>
				Transaction Narration : <strong>{$ThisUSer->currency}</strong><br/>
				Transaction Remarks :  <strong>{$Transaction->transid}</strong><br/>
				Date and Time: <strong>{$Transaction->transid}</strong><br/>
				Available Balance: <strong>{$user_balance}</strong>
				</p>
            <p>Your account information is private. Please do not disclose your login credentials or card details to anyone. Avoid clicking on suspicious links in emails or text messages.</p>
            ";

			//Email Notix//
			$Mailer = new Apps\Emailer();
			$EmailTemplate = new Apps\EmailTemplate('mails.default');
			$EmailTemplate->subject = $subject;
			$EmailTemplate->fullname = $fullname;
			$EmailTemplate->mailbody = $mailbody;
			$Mailer->subject = $subject;
			$Mailer->SetTemplate($EmailTemplate);
			$Mailer->toEmail = $ThisUSer->email;
			$Mailer->toName = $fullname;
			$sent = $Mailer->send();
			//Email Notix//


		}

		$Template->redirect("/admin/edit-account/account/{$accid}/edit");
	} elseif ($cmd == 'settings') {

		$Post = $Core->post($_POST);
		$SiteInfos = $Core->SiteInfos();
		while ($site = mysqli_fetch_object($SiteInfos)) {
			$_name = $site->name;
			$Core->setSiteInfo("{$site->name}", $Post->$_name);
		}
		$Template->redirect("/admin/settings");
	}
}, 'POST');




$Route->add('/admin/forms/login', function () {
	$Template = new Apps\Template;
	$Model = new Apps\Model;
	$MysqliDb = new Apps\MysqliDb;
	$data = $Model->post($_POST);
	$Login = $MysqliDb->where("email", $data->email)->where("password", $data->password)->getOne("accounts", "accid");
	if (isset($Login['accid'])) {
		$accid = $Login['accid'];
		$Template->authorize($accid);
		$Template->redirect("/admin");
	}
	$Template->redirect("/admin/login");
}, 'POST');


$Route->add('/admin/forms/setup', function () {
	$Template = new Apps\Template;
	$Model = new Apps\Model;
	$data = $Model->post($_POST);
	$query = file_get_contents("./templates/admin/install/sql/db.sql");
	$query .= "INSERT INTO `accounts` (`email`, `password`, `firstname`, `lastname`, `is_admin`) VALUES ('$data->email','$data->secure','Anthill','Admin',1);";
	$installed = (int)$Model->multi_sql($query);
	if ($installed) {
		$Template->redirect("/admin");
	}
	$Template->redirect("/admin/login");
}, 'POST');



$Route->add('/admin/accounts/create', function () {

	$Core = new Apps\Core;
	$Template = new Apps\Template("/admin/login");

	$Post = $Core->post($_POST);

	$Banco = new Apps\Banco;
	$Temp_Password = $Banco->GenPassword(7);


	$newaccid = $Banco->CreateAccount($Post->currency, $Post->account_type, $Post->email, $Post->mobile, $Temp_Password, $Post->firstname, $Post->lastname, $Post->address, $Post->address2, $Post->zipcode, $Post->city, $Post->state, $Post->country);
	$Template->debug($newaccid);
	$fullname = "$Post->firstname} {$Post->lastname}";

	//SMS HERE//
	// $sent = $SMSLive->send($Login->mobile, "");
	//SMS HERE//

	$subject = "Welcome to FSFBOnline";
	$mailbody = "<p>Congratulations <strong>{$fullname}</strong>!</p>
		<p>Your account profile with Citizens Bank has been created. Kindly log in to you account to change your default password.</p>
		<p>LOGIN INFORMATION:<hr/></p>
		<p>
		
		</p>
		<p>Our team will review the details and documents you will submit before your account can be set live.</p>
		";

	//Email Notix//
	$Mailer = new Apps\Emailer();
	$EmailTemplate = new Apps\EmailTemplate('mails.default');
	$EmailTemplate->subject = $subject;
	$EmailTemplate->fullname = $fullname;
	$EmailTemplate->mailbody = $mailbody;
	$Mailer->subject = $subject;
	$Mailer->SetTemplate($EmailTemplate);
	$Mailer->toEmail = $Post->email;
	$Mailer->toName = $fullname;
	$Mailer->send();
	//Email Notix//

	$Template->redirect("/admin/edit-account/account/{$newaccid}/edit");
}, 'POST');



$Route->add('/admin/{route}/account/{accid}/{action}', function ($route, $accid, $action) {

	$Core = new Apps\Core;
	$Banco = new Apps\Banco;

	$Template = new Apps\Template("/admin/login");
	$Template->addheader("admin.layouts.header");
	$Template->addfooter("admin.layouts.footer");
	$Template->assign("title", "Anthill Pro Admin");

	if ($route == "delete-account") {
		$Template->assign("title", "Account & Users");
		$Template->assign("AccountInfo", $Banco->UserInfo($accid));
	} elseif ($route == "edit-account") {
		$Template->assign("title", "Account & Users");
		$Template->assign("AccountInfo", $Banco->UserInfo($accid));
	} elseif ($route == "fund-account") {
		$Template->assign("title", "Account & Users");
		$Template->assign("AccountInfo", $Banco->UserInfo($accid));
	} elseif ($route == "info-account") {
		$Template->assign("title", "User Transactions");
		$Template->assign("Transactions", $Banco->RecentUserTransactions($accid));
	}
	$Template->assign("expanded", true);
	$Template->render("admin.routes.{$route}");
}, 'GET');


$Route->add('/admin/auth/logout', function () {
	$Template = new Apps\Template;
	$Template->expire();
	$Template->redirect("/admin");
}, 'GET');

$Route->add('/auth/logout', function () {
	$Template = new Apps\Template;
	$Template->expire();
	$Template->redirect("/");
}, 'GET');


$Route->run('/');
