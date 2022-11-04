<?php

require_once implode(DIRECTORY_SEPARATOR, [__DIR__, '..', 'vendor', 'autoload.php']);

use Faker\Factory;
use Kubinyete\Fraugster\Core\Environment;
use Kubinyete\Fraugster\Core\FraugsterClient;
use Kubinyete\Fraugster\Model\Billing;
use Kubinyete\Fraugster\Model\Card;
use Kubinyete\Fraugster\Model\Customer;
use Kubinyete\Fraugster\Model\Email;
use Kubinyete\Fraugster\Model\Gender;
use Kubinyete\Fraugster\Model\PaymentMethod;
use Kubinyete\Fraugster\Model\PaymentMethodBrand;
use Kubinyete\Fraugster\Model\Shipping;
use Kubinyete\Fraugster\Model\Transaction;
use Kubinyete\Fraugster\Model\Transaction\Async\CancelledUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Async\CapturedUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Async\ChargebackUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Async\FraudConfirmedUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Async\FraudSuspiciousUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Async\RefundUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Sync\ApprovedUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Sync\DeclinedUpdatePacket;
use Kubinyete\Fraugster\Model\Transaction\Sync\FrgDeclinedUpdatePacket;
use Kubinyete\Fraugster\Type\Country;
use Kubinyete\Fraugster\Type\Currency;
use Kubinyete\Fraugster\Type\IpAddress;
use Kubinyete\Fraugster\Type\State;
use Symfony\Component\VarDumper\VarDumper;

$username   = getenv('FRAUGSTER_USER') ?? '';
$secret     = getenv('FRAUGSTER_SECRET') ?? '';

$client = new FraugsterClient(Environment::staging());
$token  = $client->getSessionToken($username, $secret);

if (!$token) {
    throw new Exception("Could not receive an session token");
} else {
    echo "Session token received!" . PHP_EOL;
}

//

$faker = Factory::create();

$client->useToken($token);

$id = 'ID' . time();
$mid = 'M' . $id;
$amount = $faker->randomFloat(2, 100, 200);
$currency = new Currency($faker->currencyCode());

$card = $faker->creditCardDetails();
$card = new Card(substr($card['number'], 0, 6), $card['name'], substr($card['number'], strlen($card['number']) - 4), str_replace('/', '', $card['expirationDate']), $card['number']);

$transaction = new Transaction(
    $id,
    new DateTime(),
    $amount,
    $currency,
    'ipag',
    true,
    new IpAddress($faker->ipv4()),
    PaymentMethod::Card,
    PaymentMethodBrand::CreditCards,
    null,
    'm' . time(),
    billing: new Billing($faker->address(), null, null, null, $faker->postcode(), $faker->city(), new State('SP'), new Country($faker->countryCode()), $faker->name()),
    shipping: new Shipping($faker->address(), null, null, null, $faker->postcode(), $faker->city(), new State('SP'), new Country($faker->countryCode()), $faker->name(), null),
    card: $card,
    customer: new Customer($id, (new DateTime('today'))->sub(new DateInterval('P18Y')), new Email($faker->email()), Gender::Male, $faker->name(), true, false),
);

echo "Creating transaction with ID $id" . PHP_EOL;
$recommendation = $client->createTransaction($transaction);
VarDumper::dump($recommendation);

echo "Updating transaction with ID $id" . PHP_EOL;
$response = $client->updateTransaction(new ApprovedUpdatePacket($id, new DateTime(), null));
// $response = $client->updateTransaction(new DeclinedUpdatePacket($id, new DateTime(), null, null));
// $response = $client->updateTransaction(new FrgDeclinedUpdatePacket($id, new DateTime()));
// $response = $client->updateTransaction(new CapturedUpdatePacket($id, new DateTime()));
// $response = $client->updateTransaction(new CancelledUpdatePacket($id, new DateTime()));
// $response = $client->updateTransaction(new RefundUpdatePacket($id, new DateTime(), $amount, $currency));
// $response = $client->updateTransaction(new ChargebackUpdatePacket($id, new DateTime(), null, $amount, $currency));
// $response = $client->updateTransaction(new FraudSuspiciousUpdatePacket($id, new DateTime()));
// $response = $client->updateTransaction(new FraudConfirmedUpdatePacket($id, new DateTime()));

VarDumper::dump($response);
