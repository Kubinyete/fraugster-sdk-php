<?php

namespace Kubinyete\Fraugster\Model\Recommendation;

enum ApprovedStatus: int
{
    case Decline = 0;
    case Approve = 1;
    case ManualReview = 2;
    case CustomAction = 3;
}
