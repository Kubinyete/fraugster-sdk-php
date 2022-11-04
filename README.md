# Fraugster SDK PHP

This is a Fraugster SDK for PHP 8.x, 
if you have any suggestions or changes please contribute to this project by sending a pull request.

Official Fraugster documentation can be found [here](https://docs.fraugster.com/).

## Usage

You can start sending transactions right away with the example below, in this scenario, we are authenticating with two environment variables:
`FRAUGSTER_USER` and `FRAUGSTER_SECRET`, after receiving back a session token, we generate a random transaction and send it to Fraugster.

Recommendation details can be accessed via our own `Recommendation` class, wrapping everything and converting responses 
a friendly approach using PHP 8.1 [Enums](https://www.php.net/manual/en/language.enumerations.overview.php).

For dispatching status updates, we provide a simple `UpdatePacket` class ta wraps everything need in every case,
for exemple, if we need to approve a transaction, we just send a `ApprovedUpdatePacket`, passing it to the
Fraugster client.

```php
// Credentials
$username   = getenv('FRAUGSTER_USER') ?? '';
$secret     = getenv('FRAUGSTER_SECRET') ?? '';

// API Client
$client     = new FraugsterClient(Environment::staging());
$token      = $client->getSessionToken($username, $secret);

if (!$token) {
    throw new Exception("An error ocurred while trying to authenticate");
} else {
    // Sets the current token
    $client->useToken($token);
}

// Generating a random credit card
$card = $faker->creditCardDetails();
$card = new Card(substr($card['number'], 0, 6), $card['name'], substr($card['number'], strlen($card['number']) - 4), str_replace('/', '', $card['expirationDate']), $card['number']);

// Creating a random transaction
$transaction = new Transaction(
    ($transactionId = 'TRANSACTION_ID' . time()),
    new DateTime(),
    129.99,
    new Currency('BRL'),
    'MERCHANT_ID',
    true,
    new IpAddress($faker->ipv4()),
    PaymentMethod::Card,
    PaymentMethodBrand::CreditCards,
    billing: new Billing($faker->address(), null, null, null, $faker->postcode(), $faker->city(), new State('SP'), new Country($faker->countryCode()), $faker->name()),
    shipping: new Shipping($faker->address(), null, null, null, $faker->postcode(), $faker->city(), new State('SP'), new Country($faker->countryCode()), $faker->name(), null),
    card: $card,
    customer: new Customer($id, (new DateTime('today'))->sub(new DateInterval('P18Y')), new Email($faker->email()), Gender::Male, $faker->name(), true, false),
);

// Dispatching to Fraugster
$recommendation = $client->createTransaction($transaction);
echo "Transaction sent received recommendation to {$recommendation->fraugsterApproved()->name}" . PHP_EOL;

// Updating status
if ($recommendation->fraugsterApproved() == ApprovedStatus::Approve) {
    $client->updateTransaction(new ApprovedUpdatePacket($transactionId, new DateTime(), null));
} else {
    $client->updateTransaction(new FrgDeclinedUpdatePacket($transactionId, new DateTime()));
}

```
