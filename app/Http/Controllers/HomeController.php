<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use Auth;
use DB;
use App\User;
use App\Product;
use Hash;
use SoapClient;
use Log;
use DateTime;
use PDF;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 1){

            $users = DB::table('users')->get();

            return view('home', compact('users'));
        }
        elseif (Auth::user()->role == 2){
            return $this->showOnHold();
        }
        elseif (Auth::user()->role == 3){
            return redirect('/accounting/summary');
        }
        else{
            return $this->showorder();
        }
    }

    public function newSupplier()
    {
        return view('new');
    }


    public function showInvoice ($id){

        $order = DB::table('orders')->where('orderid', $id)->get();
        $items = DB::table('items')->where('orderid', $id)->get();

        // create new PDF document
        $pdf = new PDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

        $pdf::SetTitle($order[0]->orderid);

        // set default header data

        $pdf::setPrintHeader(false);
// ---------------------------------------------------------

        $pdf::SetFont('aealarabiya', '', 14);
        // set font



        $lg = Array();
        $lg['a_meta_charset'] = 'UTF-8';
        $lg['a_meta_dir'] = 'rtl';
        $lg['a_meta_language'] = 'fa';
        $lg['w_page'] = 'page';

        // set some language-dependent strings (optional)
        $pdf::setLanguageArray($lg);
        $pdf::AddPage();


        $tbl = <<<EOD
            <table cellspacing="0" cellpadding="1" >
                <tr>
                    <td ></td>
                    <td></td>
                      <td>رقم الهاتف: ٠٥٠٩٦٦٦٥٣٢</td>

                </tr>
                <tr>

                    <td style="font-size:28px;">لي أريج </td>
                    <td></td>
                    <td>بريد الدعم الفني: hello@sharqi.shop</td>
                </tr>
                <tr>
                   <td></td>
                   <td></td>
                   <td>الرقم الضريبي: ٣٠٠٤٠٤٦٦١٤٠٠٠٣</td>
                </tr>
                <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                </tr>
                <tr>
                   <td></td>
                   <td></td>
                   <td></td>
                </tr>

            </table>
            <h1 align="center">فاتورة مبيعات</h1>
EOD;

        $pdf::writeHTML($tbl, true, false, false, false, '');


// create some HTML content


        $tbl ='
            <table cellspacing="0" cellpadding="1" >
                <tr>
                <td></td>
                <td></td>
                <td></td>
                </tr>

                <tr>
                <td></td>
                <td></td>
                <td></td>
                </tr>

                <tr>
                    <td ><h3>فاتورة السيد/ة</h3></td>
                    <td align="center" ><h3>فاتورة رقم</h3></td>
                    <td align="center"><h3>المجموع</h3></td>
                </tr>
                <tr>
                    <td >'. $order[0]->name .'</td>
                    <td align="center">'.$items[0]->orderid.'</td>
                    <td ></td>
                </tr>
                <tr>
                   <td>'. $order[0]->phone ." ". str_replace('&&', ' ', $order[0]->street_one)  .'</td>
                   <td align="center"><h3>'. date("Y/m/d") .' </h3></td>
                   <td align="center"><h1>'.$order[0]->total .' ر.س</h1></td>
                </tr>

            </table> ';

        $pdf::writeHTML($tbl, true, false, false, false, '');

        $trTag="";
        $total=0;

        foreach($items as $item) {
            $trTag .= "<tr>";
            $trTag .= "<td>".$item->sku."</td>";
            $trTag .= "<td>".$item->name."</td>";
            $trTag .= "<td>".$item->qty."</td>";
            $trTag .= "<td>".$item->price."</td></tr>";
            $total+= $item->price;

        }
        $pdf::SetFont('dejavusans', '', 10);
        //(($order[0]->total)-(($order[0]->total*5/100)))

        $html = '
            <h2 align="right">المنتجات:</h2>

            <table border="1" cellpadding="4">
                <tr>
                    <th align="center"><b>الكود</b></th>
                    <th align="center" style="width:40%;"><b>اسم المنتج</b></th>
                    <th align="center" style="width:10%;"><b>العدد</b></th>
                    <th align="center"><b>السعر الافرادي</b></th>
                </tr>'.$trTag .'

                <tr>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                </tr>

                <tr>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                    <td align="right"></td>
                </tr>

                <tr>
                <td align="right"></td>
                    <td align="right"></td>
                    <td align="right">خصم</td>
                    <td style="font-size:18px;" align="right">'. $order[0]->discount_amount*-1 .'</td>
                </tr>

                <tr>
                <td align="right"></td>
                    <td align="right"></td>
                    <td align="right">الشحن</td>
                    <td style="font-size:18px;" align="right">'. $order[0]->shipping_cost.'</td>
                </tr>
                <tr>
                <td align="right"></td>
                    <td align="right"></td>
                    <td align="right">الضريبة</td>
                    <td align="right">'. number_format((float)(($order[0]->total)-((100*$order[0]->total)/105)), 2, '.', '') .'ر.س</td>
                </tr>

                <tr>
                <td align="right"></td>
                    <td align="right"></td>
                    <td align="right">المجموع</td>
                    <td style="font-size:22px;" align="right">'.$order[0]->total.' ر.س</td>
                </tr>
            </table>';

        $pdf::writeHTML($html, true, false, true, false, '');

        $pdf::lastPage();

        $pdf::Output('Order_'.$order[0]->orderid, 'I');

    }

    public function showOnHold()
    {
        if (Auth::user()->role == 0)
            return $this->showorder();

        $pending  = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'onhold')->orWhere('status', 'First Attempt')->orWhere('status', 'Second Attempt')->get();//get();
        $ordersId = array_map(create_function('$o', 'return $o->orderid;'), $pending);
        $items    = DB::table('items')->whereIn('orderid',$ordersId)->get();

        $other  = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Shipment Created')->orWhere('status', 'Waiting for client reply')->orWhere('status', 'Canceld')->orWhere('status', 'return')->orWhere('status', 'pending')->get();//get();

        return view('onhold', compact('pending','items','other'));
    }

    public function action()

    {
        $orderId = $_GET['id'];
        $action  = $_GET['action'];

        switch ($action) {
            case 'Cancel':
            case 'Third Attempt':
                DB::table('orders')
                    ->where('orderid', '=', $orderId)
                    ->update(['status' => 'Canceld']);

            $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
            $session = $client->login('username', 'password');
            $client->call($session, 'sales_order.cancel', $orderId);

                break;
            case 'Confirm':
                DB::table('orders')
                    ->where('orderid', '=', $orderId)
                    ->update(['status' => 'pending']);
                Break;
            case 'First Attempt':
                DB::table('orders')
                    ->where('orderid', '=', $orderId)
                    ->update(['status' => 'First Attempt']);
                Break;
            case 'Second Attempt':
                DB::table('orders')
                    ->where('orderid', '=', $orderId)
                    ->update(['status' => 'Second Attempt']);
                Break;
        }
        return "Success update";
    }

    public function refund()
    {
        $orderId = $_GET['id'];

        DB::table('orders')
             ->where('orderid', '=', $orderId)
             ->update(['status' => 'return']);

        $client  = new SoapClient('https://MaindDomain.com/api/soap/?wsdl');
        $session = $client->login('username', 'password');
        $client->call($session, 'sales_order.cancel', $orderId);

        return "Success refund";
    }

    //Import new supplier
    public function saveSupplier(Request $request)
    {

        $this->validate($request , [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed',
        ]);

        $user = new User;


        $stud = explode("$",$request->name);
        $user->cat_id  = $stud[0];
        $user->name    = str_replace("_", " ", $stud[1]);


        $user->email    = $request->email;
        $user->password = Hash::make($request->password);

        $user->save();

        $client = new SoapClient('https://MainDomain.com/api/soap/?wsdl', array('trace' => true, 'keep_alive' => false));

        $session = $client->login('username', 'password');
        $result  = $client->call($session, 'catalog_category.assignedProducts', $stud[0]);

        foreach ($result as $pro) {

            if ($pro['type']!= 'simple')
                continue;

            $productInfo = $client->call($session,'catalog_product.info', $pro['product_id']);
            if ($productInfo['status'] == 1){

                $product = new Product;
                $product->name = $productInfo['name'];
                $product->sku  = $pro['sku'];

                $productStock   = $client->call($session, 'cataloginventory_stock_item.list',  $pro['product_id']);
                $product->stock = $productStock[0]['is_in_stock'];
                $product->qty   = $productStock[0]['qty'];

                $productMedia =  $client->call($session,'catalog_product_attribute_media.list', $pro['product_id']);
                if (isset($productMedia[0]))
                    $product->image = $productMedia[0]['url'];
                else
                    $product->image = "NoImage";
                $product->category  = $stud[0];

                $product->save();
            }
        }
        return view('new');
    }

    //Update supplier products to get all new items for this supplier, this function availbale only for ADMIN
    public function updateSupplier($id){

        $client = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
        $session = $client->login('username', 'password');
        $result  = $client->call($session, 'catalog_category.assignedProducts', $id);
        //sleep(2);

        foreach ($result as $pro) {

            if ($pro['type']!= 'simple')
                continue;

            if (!(empty(DB::table('products')->where('sku', $pro['sku'])->get())))
                continue;

            $productInfo = $client->call($session,'catalog_product.info', $pro['product_id']);
            if ($productInfo['status'] == 1){

                $product = new Product;
                $product->name = $productInfo['name'];//$request->input('status');
                $product->sku  = $pro['sku'];

                $productStock = $client->call($session, 'cataloginventory_stock_item.list',  $pro['product_id']);
                $product->stock = $productStock[0]['is_in_stock'];// $request->input('total');
                $product->qty = $productStock[0]['qty'];//$request->input('itemsnumber');

                //sleep(1);
                $productMedia =  $client->call($session,'catalog_product_attribute_media.list', $pro['product_id']);
                if (isset($productMedia[1]))
                    $product->image = $productMedia[1]['url'];//$request->input('productsname');
                elseif (isset($productMedia[0]))
                    $product->image = $productMedia[0]['url'];
                else
                    $product->image = "NoImage";
                $product->category = $id;//$request->input('productsqty');

                $product->save();
            }
        }
        return view('welcome');
    }

    //get list of products
    public function showProducts()
    {
        if(Auth::user()->role < 2){
            $products =DB::table('products')->paginate(80);
            return view('products', compact('products'));
        }
        return $this->showOnHold();

    }

     //disable product out of stock
    public function disable()
    {
        $productId = $_GET['sku'];
        $products = DB::table('products')->get();

        DB::table('products')
            ->where('sku', $productId)
            ->update(['stock' => false]);

        $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
        $session = $client->login('username', 'password');

        $stockItemData = array(
            'is_in_stock' => 0
        );
        $result = $client->call($session, 'product_stock.update',
            array(
                $productId,
                $stockItemData
            )
        );
    }


    //enable product in stock
    public function enable()
    {
        $productId = $_GET['sku'];
        DB::table('products')
            ->where('sku', $productId)
            ->update(['stock' => true]);

        $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
        $session = $client->login('username', 'password');

        $stockItemData = array(
            'is_in_stock' => 1
        );
        $result = $client->call($session, 'product_stock.update',
            array(
                $productId,
                $stockItemData
            )
        );
    }

     //show mainOrders list
    public function showOrder()
    {
        if (Auth::user()->role < 2) {
            $pending = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'pending')->orWhere('status', 'Client Approved')->paginate(100);//get();
            $created = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Shipment Created')->paginate(100);//get();
            $canceld = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Canceld')->orWhere('status', 'Client Reject')->paginate(100);//get();
            $waiting = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Waiting for client reply')->paginate(100);//get();

            $loadmin = true;
            return view('orders', compact('pending', 'created', 'canceld', 'waiting', 'loadmin'));
        }
        elseif (Auth::user()->role == 3) {

            $created = DB::table('orders')->orderBy('orderid', 'desc')->where('status', 'Shipment Created')->get();


            return view('invoiceOrders', compact('created'));
        }
        
        return $this->showOnHold();
    }

    //show items list of mainOrder
    public function showitems($id)
    {
        if (Auth::user()->role <= 3) {
            $itemsImages = array();
            $items = DB::table('items')->where('orderid', $id)->get();
            $skus = array_map(create_function('$o', 'return $o->sku;'), $items);

            foreach ($skus as $sku) {
                if (!(empty(DB::table('products')->where('sku', $sku)->pluck('image'))))
                    $itemsImages[] = DB::table('products')->where('sku', $sku)->pluck('image');
                else
                    $itemsImages[] = "NoImage";
            }

            $order = DB::table('orders')->where('orderid', $id)->get();

            return view('items', compact('items', 'order', 'itemsImages'));
        }
        return $this->showOnHold();
    }

    //when supplier take action for availability of order items this function will return right action button.
    public function itemAction()
    {

        if ($_GET['cost'] <=1)
            return 101;
        
        $sku = str_replace('XYYXZ', ' ', $_GET['id']);
        DB::table('items')
            ->where([
                ['sku', '=', $sku],
                ['orderid', '=', $_GET['sku']]])
            ->update(['status' => $_GET['action']]);

        DB::table('items')
            ->where([
                ['sku', '=', $sku],
                ['orderid', '=', $_GET['sku']]])
            ->update(['cost' => $_GET['cost']]);

        $qty    = DB::table('items')->where([
            ['orderid', $_GET['sku']],
            ['sku', $sku]])->pluck('qty');

        if ($_GET['action'] ==1){
            $status = DB::table('orders')->where('orderid', '=', $_GET['sku'])->get();

            $uQty = $qty[0] + $status[0]->instock;

            DB::table('orders')->where('orderid', '=', $_GET['sku'])
                ->update(['instock' => $uQty ]);
        }

        if ($_GET['action'] ==0){
            $status = DB::table('orders')->where('orderid', '=', $_GET['sku'])->get();

            $uQty = $qty[0]+$status[0]->outofstock;
            DB::table('orders')->where('orderid', '=', $_GET['sku'])
                ->update(['outofstock' => $uQty]);
        }


        $order = DB::table('orders')->where('orderid', '=', $_GET['sku'])->get();

        $instock    = $order[0]->instock;
        $outofstock = $order[0]->outofstock;
        $bag_count  = $order[0]->bag_count;

        if($instock == $bag_count)
            return "ship";
        elseif (($instock+$outofstock == $bag_count) && ($instock != 0) )
            return "notify";
        elseif ($outofstock == $bag_count)
            return "cancel";
        else
            return "still";
    }

    //Update mainOrder status based on supplier action
    public function orderStatus(Request $req)
    {
        $items =DB::table('items')->where('orderid', $_GET['orderid'])->get();
        $order =DB::table('orders')->where('orderid', $_GET['orderid'])->get();

        $message="";
        $header = "";

        switch ($_GET['action']) {
            case 'ship':
                if ($order[0]->status != "Shipment Created") {
                    $createShipment = $this->createShipment($order);

                    if ($createShipment == 'true') {
                        DB::table('orders')->where('orderid', '=', $_GET['orderid'])
                            ->update(['status' => 'Shipment Created']);
                        $message = "success";
                    }
                    else
                        $message = "failed";
                }
                break;

            case 'notify':
                DB::table('orders')->where('orderid', '=', $_GET['orderid'])
                    ->update(['status' => 'Waiting for client reply']);
                $message="notify";
                $this->notify($order);
                break;

            case 'cancel':
                DB::table('orders')->where('orderid', '=', $_GET['orderid'])
                    ->update(['status' => 'Canceld']);

                $client  = new SoapClient('https://MainDomain.com/api/soap/?wsdl');
                $session = $client->login('username', 'password');
                $client->call($session, 'sales_order.cancel', $_GET['orderid']);

                $message="cancel";
                break;
            case 'label':
                $createLable = $this->createLabel($_GET['orderid']);


                if ($createLable == "false")
                    $message = "failedLabel";
                else
                    $message = "successLabel";
                $header = $createLable;// header("Location: ".$result->data);
                break;

            default:

                break;
        }

        $skus = array_map(create_function('$o', 'return $o->sku;'), $items);

        foreach ($skus as $sku) {
            if (!(empty(DB::table('products')->where('sku', $sku)->pluck('image'))))
                $itemsImages[]=DB::table('products')->where('sku', $sku)->pluck('image');
            else
                $itemsImages[]="NoImage";
        }

        $items =DB::table('items')->where('orderid', $_GET['orderid'])->get();
        $order =DB::table('orders')->where('orderid', $_GET['orderid'])->get();


        return view('items', compact('message','items','order', 'itemsImages','header'));
    }

    private function createShipment($order)
    {
        $city = array(
            "أبها" => "Abha",
            "بقيق" => "Abqaiq",
            "" => "Al Badayea",
            "الهدا" => "Alhada",
            "الأحساء" => "Al Hassa",
            "هفوف" => "Al Hofuf",
            "الجش" => "Al-Jsh",
            "الجبيل" => "Al Jubail",
            "الخرج" => "Al Kharj",
            "الخبر" => "Al Khobar",
            "المجمعة" => "Al Majmaah",
            "" => "Al Oyun - Hofuf",
            "القطيف" => "Al Qatif",
            "الرس" => "AlRass",
            "عنك" => "Anak",
            "عرعر" => "Arar",
            "الشقيق" => "Ash Shuqaiq",
            "" => "Ath Thybiyah",
            "عوامية" => "Awamiah",
            "" => "Bahara",
            "" => "Baqayq - Hofuf",
            "بيشة" => "Bishah",
            "بكيرية" => "Bukeiriah",
            "بريدة" => "Buraydah",
            "الدمام" => "Dammam",
            "الظهران" => "Dhahran", //double check
            "دومة الجندل" => "Domat Al Jandal",//double check
            "دومة الجندل" => "Dumah Al Jandal",//double check
            "حفر الباطن" => "Hafar Al Batin",
            "حائل" => "Hail",
            "جفر" => "Jafar",
            "جازان" => "Jazan",
            "جدة" => "Jeddah",
            "جوف" => "Jouf",
            "خميس مشيط" => "Khamis Mushait",
            "خضرية" => "Khodaria",
            "" => "King Khalid Military City",
            "مكة المكرمة" => "Mecca",
            "المدينة المنورة" => "Medina",
            "مبرز" => "Mubaraz",
            "نابية" => "Nabiya",
            "نجران" => "Najran",
            "" => "Qarah",
            "القصيم" => "Qassim",
            "رحيمة" => "Rahima",
            "راس تنورة" => "Ras Tanura",
            "الرياض" => "Riyadh",
            "رياض الخبراء" => "Riyadh Al Khabra",
            "صفوى" => "Safwa",
            "سكاكا" => "Sakaka",
            "سيهات" => "Seihat",
            "تبوك" => "Tabuk",
            "الطائف" => "Taif",
            "تاروت" => "Tarut",
            "عضيلية" => "Udhailiyah - Hofuf",
            "عنيزة" => "Unayzah",
            "عيون" => "Uyun",
            "ينبع" => "Yanbu",
            "ينبع البحر" => "Yanbu Al Baher"

        );




        $amount = $order[0]->total;

        if ($order[0]->payment_type == 'cc'){
            $amount = 0 ;
//            $ordertotal = DB::table('items')
//                ->where([['orderid', '=', $order[0]->orderid],
//                    ['status','=','1']])->select('price', 'qty')->get();
//
//            foreach ($ordertotal as $item) {
//                $amount = $amount + ($item->price * $item->qty);
//            }
//            if($amount <= 300)
//                $amount = $amount + 27;
        }


        $address = explode("&&", $order[0]->street_one);
        $req = json_encode([
            "order_reference" => $order[0]->orderid,
            "payment_type" => $order[0]->payment_type,
            "consolidate_orders" => false,
            "is_express_delivery" => false,
            "receiver_data" => [
                "name" => $order[0]->name,
                "phone" => $order[0]->phone,
                "alternate_phone" => "",
                "email" => $order[0]->email,
                "country" => "Saudi Arabia",
                "state" => "",
                "city" => $city[$order[0]->city],
                "street_one" => $address[1].' >> '.$address[0],
                "street_two" => $address[1],
                "street_three" => "",
                "postal_code" => "",
                "instructions" => "FRAGILE, Handle with care, please"
            ],
            "package_data" => [
                [
                    "extra_data" => [
                        "extra_documents" => [
                            ""
                        ],
                        "origin_client_name" => "Admin"
                    ],
                    "pickup_address_id" => "My_Account_Code",
                    "package_reference" => $order[0]->orderid,
                    "type" => "fragile",
                    "price" => $amount,
                    "order_value" => $order[0]->total,
                    "description" => "Perfumes items",
                    "bag_count" => 1,//(int)$order[0]->bag_count,
                    "weight" => $order[0]->weight
                ]
            ]
        ]);

        Log::useDailyFiles(storage_path().'/logs/createShipment.log');
        Log::info("Request=>".$req);


        $curl = curl_init("https://api.fetchr.us/v3/orders/dropship");
        $token = "Bearer eyJhbGciOiJIUzI1NiIsImV4cCI6MTY2MzA2MjMxOCwiaWF0IjoxNTA3NTQyMzE4fQ.eyJYLUNsaWVudC1OYW1lIjoibGVhcmVlal9kb21fc2EiLCJzYW5kYm94IjpmYWxzZSwicHJpdmlsZWdlcyI6eyJjcmVkZW50aWFscyI6ImNydWQiLCJ0cmFja2luZyI6ImNydWQiLCJvcmRlcnMiOiJjcnVkIiwibm90aWZpY2F0aW9ucyI6ImNydWQifSwiWC1DbGllbnQtSUQiOjEwMzM4OTQ2fQ.uAndVQ23jEouyjWKNOxhipXH4TnhXdEgOXuViU5GGTU";

        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($curl, CURLOPT_HTTPHEADER, array("authorization: $token",
                'Content-Type: application/json',
                'Content-Length: ' . strlen($req))
        );

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $req);

        $results = json_decode(curl_exec($curl));

        curl_close($curl);

        Log::info("Response=>".print_r($results, true));


        if (isset($results->success)) {
            if ($results->success == true) {

                $date = new DateTime();

                DB::table('orders')->where('orderid', '=', $order[0]->orderid)
                    ->update(['tracking_id' => $results->data->package_data[0]->tracking_no]);

                DB::table('orders')->where('orderid', '=', $order[0]->orderid)
                    ->update(['shipment_time' => $date->getTimestamp()]);
                return 'true';
            } else
                return 'false';
        }
        else
            return 'false';
    }

    private function createLabel($orderid)
    {
        $trackingId = DB::table('orders')->where('orderid', $orderid)->get();

        $data = json_encode(array(
            "format"       => 'PDF',
            "type"         => 'label',
            "search_key"   => 'tracking_no',
            "search_value" => array($trackingId[0]->tracking_id),
            "start_date"   => null,
            "end_date"     => null,
        ));

        Log::useDailyFiles(storage_path().'/logs/createLabel.log');
        Log::info("Request=>".$data);

        $url="https://business.fetchr.us/api/client/awb";
        $token ='d6adaad23b8188a9b6575c35229f51aac1';
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("authorization: $token",
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
        );
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = json_decode(curl_exec($ch));

        curl_close($ch);

        Log::info("Response=>".print_r($result, true));

        if (isset($result->status)){
            if ($result->status == "success")
            {

                return $result->data;
            }
        }
        return "false";
    }

    //Send email notification for customer once his order will miss some items.
    private function notify($order)
    {
        $missing  =  DB::table('items')
            ->where([
                ['orderid', $order[0]->orderid],
                ['status', 0]])->get();

        $listOfMissed ="";
        foreach ($missing as $missed) {
            $listOfMissed= $listOfMissed."<li>".$missed->name."</li>";
        }

        $html = 'We just want to let you know that <ul>'.
            $listOfMissed

            .'</ul>
            will not be added your order number '.$order[0]->orderid.'
            so, if you want to proceed with this missed itmes, please click Approve or reject if you want to cancel the whole order </br>
            <table cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" width="100" height="40" bgcolor="#5cb85c" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">
                    <a href="http://MainDomain/api/items/'.$order[0]->orderid.'/edit?result=Client Approved" style="font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block"><span style="color: #FFFFFF">Approve</span></a>
                </td>
                </tr>
            </table>
            <br/>
            <table cellspacing="0" cellpadding="0">
                <tr>
                <td align="center" width="100" height="40" bgcolor="#a5032b" style="-webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; color: #ffffff; display: block;">
                    <a href="http://MainDomain/'.$order[0]->orderid.'/edit?result=Client Reject" style="font-size:16px; font-weight: bold; font-family: Helvetica, Arial, sans-serif; text-decoration: none; line-height:40px; width:100%; display:inline-block"><span style="color: #FFFFFF">Reject</span></a>
                </td>
            </tr>
            </table>
            <p>Kindly approve/reject the order with this details</p>';

        $to = $order[0]->email;
        $subject = "Order missing notification";
        $txt = $html;

        $headers = "From: hello@sharqi.shop". "\r\n";
        $headers .= "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

        mail($to,$subject,$txt,$headers);
    }

}
