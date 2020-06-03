<?php

namespace VCComponent\Laravel\Search\ValidRule;

class Operator
{
    const EQUALS     = "=";
    const LIKE       = "LIKE";
    const GREATER    = ">";
    const GREATER_EQ = ">=";
    const LESS       = "<";
    const LESS_EQ    = "<=";
    const NOT_LIKE   = "NOT LIKE";
    const NOT_EQUALS = "!=";
    const SUBSTRING  = "%LIKE%";
    const START_WITH = "LIKE%";
    const END_WITH   = "%LIKE";
}
