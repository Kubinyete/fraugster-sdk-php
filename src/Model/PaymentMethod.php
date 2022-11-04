<?php

namespace Kubinyete\Fraugster\Model;

enum PaymentMethod: string
{
    case Cash = 'cash';
    case DirectDebit = 'direct_debit';
    case Bnpl = 'bnpl';
    case BankingTransfer = 'banking_transfer';
    case Wallet = 'wallet';
    case Card = 'card';
    case PrepaidVoucherGiftcard = 'prepaid_voucher_giftcard';
    case Mobile = 'mobile';
}
