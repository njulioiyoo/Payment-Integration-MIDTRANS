<?php
namespace App\Http\Controllers;

use Session;
use App\Product;
use Veritrans_Snap;
use Veritrans_Transaction;

use Illuminate\Http\Request;

class MidtransController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
    //
  }

  public function create_transaction_view (Request $request, $name)
  {
    $product_id = $name;
    $getProduct = Product::where('type', '=', $product_id)->first();

    return view("checkout", [
      "client_key" => config("app.midtrans.client_key"),
      "product_id" => $product_id,
      "product" => $getProduct
    ]);
  }

  public function create_transaction (Request $request)
  {
    $product_id = $request->input("id");
    $getProduct = Product::where('type', '=', $product_id)->first();

    // Optional
    $billing_address = array(
      'first_name'    => "Julio",
      'last_name'     => "Notodiprodyo",
      'address'       => "-",
      'city'          => "Bekasi Timur",
      'postal_code'   => "-",
      'phone'         => "081297341974",
      'country_code'  => 'IDN'
    );

    // Optional
    $shipping_address = array(
      'first_name'    => "Julio",
      'last_name'     => "Notodiprodyo",
      'address'       => "-",
      'city'          => "Bekasi Timur",
      'postal_code'   => "-",
      'phone'         => "08113366345",
      'country_code'  => 'IDN'
    );

    // Optional
    $customer_details = array(
      'first_name'    => "Julio",
      'last_name'     => "Notodiprodyo",
      'email'         => "njulioiyoo@gmail.com",
      'phone'         => "081297341974",
      'billing_address'  => $billing_address,
      'shipping_address' => $shipping_address
    );

    $transaction = [
      "transaction_details" => [
        "order_id" => "TX" . rand(),
        "gross_amount" => $getProduct->price
      ],
      "customer_details" => $customer_details,
      "item_details" => [
        [
          "id" => $product_id,
          "name" => $getProduct->name,
          "price" => $getProduct->price,
          "quantity" => 1,
        ]
      ]
    ];

    $token = $this->get_snap_token($transaction);

    return response()->json([
      "token" => $token
    ]);
  }

  private function get_snap_token ($transaction)
  {
    $token = Veritrans_Snap::getSnapToken($transaction);

    return $token;
  }

  public function get_tx_status (Request $request, $id)
  {
    $status = Veritrans_Transaction::status($id);

    return response()->json([
      "id" => $id,
      "status" => $status
    ]);
  }

  public function cancel_tx (Request $request, $id)
  {
    $status = Veritrans_Transaction::cancel($id);

    return response()->json([
      "id" => $id,
      "status" => $status
    ]);
  }
}
