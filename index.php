<?php

use Mpdf\Mpdf;

define('DOT', '.');
require_once(DOT . "/bootstrap.php");

$Route = new Apps\Route;

$Route->add('/', function () {
	$Template = new Apps\Template;
	$Template->assign("title", "Welcome Home | Landmark Finance Bank");
	$Template->addheader("layouts.site.header");
	$Template->addfooter("layouts.site.footer");
	$Template->assign("menukey", "home");
	$Template->render("home");
}, 'GET');

$Route->add('/pages/{page}', function ($page) {
	$Template = new Apps\Template;
	$Core = new Apps\Core;
	$Template->addheader("layouts.site.header");
	$Template->addfooter("layouts.site.footer");
	$PageInfo = $Core->PageInfo($page);
	$Template->assign("PageInfo", $PageInfo);
	$Template->assign("menukey", $page);
	$Template->assign("PageTitle", $PageInfo->menutitle);
	$Template->assign("title", "{$PageInfo->title} | Landmark Finance Bank");
	$Template->render("pages");
}, 'GET');

include_once "./_public/banco.php";
include_once "./_public/admin.php";

$Route->add('/ibanking', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Online Banking Dashboard | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.dashboard"));
}, 'GET');

$Route->add('/ibanking/transactions', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$accid = $Template->storage('accid');
	$RecentTransactions = $Banco->RecentUserTransactions($accid);
	$Template->assign("RecentTransactions", $RecentTransactions);
	$Template->assign("title", "Transactions | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.transactions"));
}, 'GET');


$Route->add('/ibanking/profile', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Edit Profile | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.profile"));
}, 'GET');

$Route->add('/ibanking/kyc', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Upload Documents | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.kyc"));
}, 'GET');

$Route->add('/ibanking/settings', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Settings | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.settings"));
}, 'GET');


$Route->add('/ibanking/statement/{accid}/print', function ($accid) {
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
			<div><img src="https://landmarkfinanceonline.com/templates/assets/site/images/pwau_logo.png" ></div>
			<p>&nbsp;</p>			
			<br />82 Maude St, Sandown,<br /> Sandton 2031, Johannesburg<br />South Africa.<br/><span style="font-size: 100%;">Tel:</span> +2711 568 0910<br/><span style="font-size: 100%;">Email:</span> info@landmarkfinanceonline.com</td>
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

$Route->add('/ibanking/statement', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Settings | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.statement"));
}, 'GET');


$Route->add('/ibanking/changepassword', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Change Password | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.changepassword"));
}, 'GET');

$Route->add('/ibanking/activities', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Account Activities | Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.activities"));
}, 'GET');

$Route->add('/ibanking/transfer', function () {
	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Continue Transfer| Landmark Finance Bank");
	$Template->render($Banco->CheckKYC("ibanking.transfer"));
}, 'GET');



$Route->add('/ibanking/transit', function () {

	$Banco = new Apps\Banco;
	$Template = new Apps\Template("/ibanking/auth/login/");
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
				$Template->assign("title", "Transfer Completed | Landmark Finance Bank");
				$Template->render($Banco->CheckKYC("ibanking.transit_completed"));
			} else {
				$Template->assign("title", "One More Step | Landmark Finance Bank");
				$Template->store("paystep", 6);
				$Template->render($Banco->CheckKYC("ibanking.transfer"));
			}
		} else {
			$Banco->AddTransferTransaction($accid, $transferid);
			$Template->store("paystep", 0);
			$Template->store("PayData", array());
			$Template->assign("title", "Transfer Completed | Landmark Finance Bank");
			$Template->render($Banco->CheckKYC("ibanking.transit_completed"));
		}
	} else {
		$Template->store("paystep", 0);
		$Template->store("PayData", array());
		$Template->assign("title", "Transfer Failed | Landmark Finance Bank");
		$Template->render($Banco->CheckKYC("ibanking.transit_failed"));
	}
}, 'GET');


$Route->add('/ibanking/auth/register', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Register | Landmark Finance Bank");
	$Template->render("ibanking.register");
}, 'GET');


$Route->add('/ibanking/auth/login', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Login | Landmark Finance Bank");
	$Template->render("ibanking.login");
}, 'GET');

$Route->add('/ibanking/auth/reset', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "Reset password | Landmark Finance Bank");
	$Template->render("ibanking.reset");
}, 'GET');

$Route->add('/ibanking/auth/otp', function () {
	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	$Template->assign("title", "One Time Password | Landmark Finance Bank");
	$Template->render("ibanking.otp");
}, 'GET');

$Route->add('/ibanking/auth/lock', function () {

	$Template = new Apps\Template;
	$Template->addheader("layouts.dashboard.header");
	$Template->addfooter("layouts.dashboard.footer");
	if (!isset($Template->data['newaccid'])) {
		$Template->redirect("/ibanking/auth/register");
	}
	$Banco = new Apps\Banco;
	$UserInfo = $Banco->UserInfo($Template->data['newaccid']);
	$Template->assign("title", "{$UserInfo->firstname} {$UserInfo->lastname} | Landmark Finance Bank");
	$Template->assign("UserInfo", $UserInfo);
	$Template->expire();
	$Template->render("ibanking.lock");
}, 'GET');

$Route->add('/ibanking/auth/lock/reset', function () {
	$Template = new Apps\Template;
	$Template->expire();
	$Template->redirect("/");
}, 'GET');



$Route->add('/ibanking/auth/logout', function () {
	$Template = new Apps\Template;
	$Template->expire();
	$Template->redirect("/ibanking/");
}, 'GET');



$Route->run('/');
