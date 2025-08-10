<?php

// ->should(
//  function (Builder $should) {
//      $should
//          ->match()
//          ->match();
//  },
// )
// ->minimumShouldMatch(1);

Must::bool(
    $should(
        $match(),
        $match(),
        $match(),
    )
)

->should(
    matches: [
        Mat::ch('field1', 'value'),
        Mat::ch('field2', 'value'),
        Mat::ch('field3', 'value'),
    ],
)
->minimunShouldMatch(1);

Bool::must(
    
)

Bool::should()
    ->match('field1', 'value')
    ->match('field2', 'value')
    ->match('field3', 'value')
    ->minimumShouldMatch(1)
;