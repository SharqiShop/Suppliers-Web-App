<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use DateTime;
use DB;
use Log;
use SoapClient;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        // Commands\Inspire::class,
    ];

    protected $mailedOrders="";

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        $this->mailedOrders =DB::table('orders')->where([
            ['status', '=', "Shipment Created"],
            ['mailed', '=', false]])->get();

        //Send Morning Daily Notification to Fetcher
        $schedule->call(function () {
            if (!(empty($this->mailedOrders))){
                date_default_timezone_set('Asia/Riyadh');

                $monthNum  = date('m');
                $dayNum    = date('d');
                $monthName = DateTime::createFromFormat('!m', $monthNum)->format('F');

                $html = '<table cellspacing="0" cellpadding="0" dir="ltr" border="1" style="border-collapse:collapse;">

                         <colgroup>
                         <col width="170">
                         <col width="169">
                         <col width="125">
                         <col width="134">
                        </colgroup>
                        <tbody>

                          <tr style="height:21px">
                            <td rowspan="1" colspan="4" style="background-color:rgb(159,197,232);font-weight:bold;text-align:center">
                              Collection Request Details</td>
                          </tr>

                          <tr style="height:21px">
                            <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">  Client Name
                            </td>
                            <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                              Sharqi - Admin<br>
                              Account user :hello@sharqi.shop
                            </td>

                          </tr>

                          <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Date
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">'. $dayNum ." ".$monthName.' - <span class="aBn" data-term="goog_409149626" tabindex="0"></span>
                              </td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Time</td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">Available between <span class="aBn" data-term="goog_409149627" tabindex="0"></span><span class="aBn" data-term="goog_409149628" tabindex="0"><span class="aQJ">4:30 - 10:30 pm</span></span>
                              </td>
                            </tr>

                            <tr style="height:21px"><td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Address</td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">Saudi Arabia - المملكة السعودية<br>Dammam - الدمام<br>Badr Area - Panda&nbsp; (حي بدر - بنده)<br>Behind Mouwasat Hospital - خلف مستشفى المواساة</td>
                            </tr>


                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Contact Person
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                Mohammad Ahmad Kasem
                              </td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Contact Number
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                  <a href="tel:+966%2050%20253%203381" value="+966502533381" target="_blank">+966 50 253 3381</a>
                              </td>
                            </tr>


                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Shipment Size<br>Requires (Car/Van)</td><td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">Car</td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Special Instructions
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                Fragile, be careful please
                              </td>
                            </tr>
                          </tbody>
                        </table>';

                $to = 'support@fetchr.us';
                $subject = "Pick up request";
                $txt = $html;
                $headers = "From: hello@sharqi.shop". "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                mail($to,$subject,$txt,$headers);

                DB::table('orders')->where([
                    ['status', '=', "Shipment Created"],
                    ['mailed', '=', false]])->update(['mailed' => true]);

            }
        })->dailyAt('11:55')->timezone('Asia/Riyadh');

        //Send Evening daily Notification to Fetcher
        $schedule->call(function () {
            if (!(empty($this->mailedOrders))){
                date_default_timezone_set('Asia/Riyadh');


                $monthNum  = date('m', time()+86400);
                $dayNum    = date('d', time()+86400);
                $monthName = DateTime::createFromFormat('!m', $monthNum)->format('F');

                $html = '<table cellspacing="0" cellpadding="0" dir="ltr" border="1" style="border-collapse:collapse;">

                         <colgroup>
                         <col width="170">
                         <col width="169">
                         <col width="125">
                         <col width="134">
                        </colgroup>
                        <tbody>

                          <tr style="height:21px">
                            <td rowspan="1" colspan="4" style="background-color:rgb(159,197,232);font-weight:bold;text-align:center">
                              Collection Request Details</td>
                          </tr>

                          <tr style="height:21px">
                            <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">  Client Name
                            </td>
                            <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                              Sharqi - Admin<br>
                              Account user :hello@sharqi.shop
                            </td>

                          </tr>

                          <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Date
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">'. $dayNum ." ".$monthName.' - <span class="aBn" data-term="goog_409149626" tabindex="0"></span>
                              </td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Time</td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                              Available between <span class="aBn" data-term="goog_409149627" tabindex="0">
                              <span class="aQJ">9:00 - 11:00 am</span>
                              </span>
                              <br>Or<br>
                              <span class="aBn" data-term="goog_409149628" tabindex="0">
                                <span class="aQJ">4:30 - 10:30 pm</span>
                              </span>
                               </td>
                            </tr>

                            <tr style="height:21px"><td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Pick up Address</td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">Saudi Arabia - المملكة السعودية<br>Dammam - الدمام<br>Badr Area - Panda&nbsp; (حي بدر - بنده)<br>Behind Mouwasat Hospital - خلف مستشفى المواساة</td>
                            </tr>


                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Contact Person
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                Mohammad Ahmad Kasem
                              </td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Contact Number
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                  <a href="tel:+966%2050%20253%203381" value="+966502533381" target="_blank">+966 50 253 3381</a>
                              </td>
                            </tr>


                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">Shipment Size<br>Requires (Car/Van)</td><td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">Car</td>
                            </tr>

                            <tr style="height:21px">
                              <td style="background-color:rgb(230,145,56);font-weight:bold;text-align:center">
                                Special Instructions
                              </td>
                              <td rowspan="1" colspan="3" style="background-color:rgb(222,235,246)">
                                Fragile, be careful please
                              </td>
                            </tr>
                          </tbody>
                        </table>';

                $to = 'support@fetchr.us';
                $subject = "New Shipment Request";
                $txt = $html;

                $headers = "From: hello@sharqi.shop". "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

                mail($to,$subject,$txt,$headers);

                DB::table('orders')->where([
                    ['status', '=', "Shipment Created"],
                    ['mailed', '=', false]])->update(['mailed' => true]);

            }
        })->dailyAt('23:55')->timezone('Asia/Riyadh');


        $schedule->call(function () {

            Log::useDailyFiles(storage_path().'/logs/updatecost.log');


            $updateCost = DB::table('orders')->where([
                ['status', '=', "Shipment Created"],
                ['mailed', '=', false]])->get();

            $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
            $session = $client->login('username', 'password');


            foreach($updateCost as $order){
                $items = DB::table('items')->where('orderid', '=', $order->orderid)->get();

                Log::info("**********");
                Log::info("Items");
                Log::info($items);

                foreach($items as $item) {
                    $result = $client->call($session, 'catalog_product.update', array($item->sku, array(
                        'cost' => $item->cost
                    )));

                    Log::info("**********");
                    Log::info($result);
                }
            }
        })->dailyAt('11:53')->timezone('Asia/Riyadh');
        
        $schedule->call(function () {

            Log::useDailyFiles(storage_path().'/logs/updatecost.log');


            $updateCost = DB::table('orders')->where([
                ['status', '=', "Shipment Created"],
                ['mailed', '=', false]])->get();

            $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
            $session = $client->login('username', 'password');


            foreach($updateCost as $order){
                $items = DB::table('items')->where('orderid', '=', $order->orderid)->get();

                Log::info("**********");
                Log::info("Items");
                Log::info($items);

                foreach($items as $item) {
                    $result = $client->call($session, 'catalog_product.update', array($item->sku, array(
                        'cost' => $item->cost
                    )));

                    Log::info("**********");
                    Log::info($result);
                }
            }
        })->dailyAt('23:53')->timezone('Asia/Riyadh');



    }
}
