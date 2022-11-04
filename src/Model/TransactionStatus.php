<?php

namespace Kubinyete\Fraugster\Model;


enum TransactionStatus: string
{
        // Sync
    case Approved = 'approved';
    case ApprovedRecurring = 'approved_recurring';
    case Declined = 'declined';
    case DeclinedFraudscreening = 'declined_fraudscreening';
    case Error = 'error';
    case FrgDeclined = 'frg_declined';
    case PaymentPending = 'payment_pending';
        // Async
    case ApprovedManual = 'approved_manual';
    case CancellationRequested = 'cancellation_requested';
    case FraudConfirmed = 'fraud_confirmed';
    case FraudSuspicious = 'fraud_suspicious';
    case Refund = 'refund';
    case Returned = 'returned';
        // BNPL
    case DebtCollectionLoss = 'debt_collection_loss';
    case DebtCollection = 'debt_collection';
    case DunningFees = 'dunning_fees';
    case PreDebtCollectionLoss = 'pre_debt_collection_loss';
        // Cards
    case CancelledClaim = 'cancelled_claim';
    case Chargeback = 'chargeback';
    case Captured = 'captured';
        // Cash
    case Closed = 'closed';
        // Misc
    case BankTransferReturn = 'bank_transfer_return';
    case Cancelled = 'cancelled';
    case CancelledRecurring = 'cancelled_recurring';
    case DisputeAccepted = 'dispute_accepted';
    case DisputeCancelled = 'dispute_cancelled';
    case DisputeDenied = 'dispute_denied';
    case DisputeOpened = 'dispute_opened';
    case Paid = 'paid';
    case Reversed = 'reversed';
}
