<?php

namespace Kubinyete\Fraugster\Model;

enum PaymentMethodBrand: string
{
    case Affirm = 'affirm';
    case Afterpay = 'afterpay';
    case Alipay = 'alipay';
    case AmazonPay = 'amazon_pay';
    case ApplePay = 'apple_pay';
    case Bancontact = 'bancontact';
    case Billpay = 'billpay';
    case BonusCard = 'bonus_card';
    case Eprzelewy24 = 'eprzelewy24';
    case Eps = 'eps';
    case Giropay = 'giropay';
    case GooglePay = 'google_pay';
    case Ideal = 'ideal';
    case Myone = 'myone';
    case Oney = 'oney';
    case Jaccs = 'jaccs';
    case Konbini = 'konbini';
    case Paybright = 'paybright';
    case Paydirekt = 'paydirekt';
    case Paypal = 'paypal';
    case Postfinance = 'postfinance';
    case RakutenPay = 'rakuten_pay';
    case Sepa = 'sepa';
    case Sofort = 'sofort';
    case Twint = 'twint';
    case Masterpass = 'masterpass';
    case VisaCheckout = 'visa_checkout';
    case Trustly = 'trustly';
    case Billink = 'billink';
    case BancontactMobile = 'bancontact_mobile';
    case Belfius = 'belfius';
    case Blik = 'blik';
    case Coupons = 'coupons';
    case CreditCards = 'credit_cards';
    case Cryptocurrency = 'cryptocurrency';
    case Dotpay = 'dotpay';
    case KlarnaPayNow = 'klarna_pay_now';
    case KlarnaPayLater = 'klarna_pay_later';
    case MbWay = 'mb_way';
    case MobilePay = 'mobile_pay';
    case Multibanco = 'multibanco';
    case MyBank = 'my_bank';
    case Neteller = 'neteller';
    case Paysafecard = 'paysafecard';
    case Paysera = 'paysera';
    case Payshop = 'payshop';
    case Paytrail = 'paytrail';
    case RapidTransfer = 'rapid_transfer';
    case Skrill = 'skrill';
    case Swish = 'swish';
    case Vipps = 'vipps';
    case Zimpler = 'zimpler';
    case KbcCbc = 'kbc_cbc';
    case Cashpresso = 'cashpresso';
    case Mondu = 'mondu';
    case MonduInstallments = 'mondu_installments';
}
