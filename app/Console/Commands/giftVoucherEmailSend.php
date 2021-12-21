<?php

namespace App\Console\Commands;

use App\Cron;
use Illuminate\Console\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Mail;
use \stdClass;

class GiftVoucherEmailSend extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'GiftVoucherEmailSend:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Gift Voucher Email To Recipient Email Address';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    protected $objCron;
    public function __construct()
    {
        parent::__construct();
        $this->objCron = new Cron();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(Request $request)
    {
        $host = $request->getHttpHost();
        $updatedRecords = array();
        $today = getCurrentDate();
        $voucherOrders  = $this->objCron->getTodayGiftVoucherList($today );
        if(!$voucherOrders->isEmpty())
        {
            foreach($voucherOrders as $key => $row)
            {
                $tempObj = new stdClass;
                $tempObj = $row;
                $tempObj->errorMessage = _sendGiftVoucherEmail($row);
                $tempObj->isEmailSend = 'Failed';
                if($tempObj->errorMessage === true){
                    DB::table('voucher_orders')->where('id', $row->id)->limit(1)->update(array('email_sent' => 'yes'));
                    $tempObj->isEmailSend = 'YES';
                }


                array_push($updatedRecords, $tempObj);

            }
        }

        $sendMailData= array(
            'mailType'=>'Cron: giftVoucherEmailSend',
            'mailKey' => 'constants.mails.dev_error.giftVoucherEmailSend',
            'requestData' => $updatedRecords,
        );
        $emailData['data'] =$sendMailData;
        $sendMailFrom = _get_setting_data('site_mail_email');
        $siteMailName  = config('constants.mails.site_name');
        $toEmail = config('constants.mails.dev_emails');
        $title = $host. ' ' .config($sendMailData['mailKey']) . ' - '.getCurrentDateTime();
        @Mail::send('emails.developer_email', $emailData, function ($message) use ($toEmail, $sendMailFrom, $siteMailName, $title) {
            $message->to($toEmail);
            $message->from($sendMailFrom, $siteMailName);
            $message->subject($title);
        });

    }
}