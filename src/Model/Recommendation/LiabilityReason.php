<?php

namespace Kubinyete\Fraugster\Model\Recommendation;


enum LiabilityReason: string
{
    case Declined = 'declined';
    case HighAmount = 'high_amount';
    case NotFraudFree = 'not_ffp';
    case UnknownAmount = 'unknown_amount';
    case ApproveList = 'approve_list';
}
