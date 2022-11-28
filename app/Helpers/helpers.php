<?php

function formatDate($date)
{
    $date = date_create($date);
    $date = date_format($date, 'd M, Y');
    return $date;
}


// borrowers date return function
function returnDate($date)
{
    $date = date_create($date);
    $date = date_add($date, date_interval_create_from_date_string("10 days"));
    $date = date_format($date, 'd M, Y');
    return $date;
}

function returnDateTime($date)
{
    $date = date_create($date);
    $date = date_format($date, 'H:ia, d M');
    return $date;
}