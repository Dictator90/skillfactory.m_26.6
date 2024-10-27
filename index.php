<?php

include './Iterator/Html.php';

$htmlCode = new Html(__DIR__ . '/page.html');

$changePage = fopen(__DIR__ . '/page.html','w+b');
$receivedPage = fopen(__DIR__ . '/resultPage.txt','w+b');

foreach ($htmlCode as $key => $row) {
    $isMatched = preg_match('/<+\bmeta\s\bname+=+"+keywords|description+"+[^>]*>|<+title+>+[^>]*>/', $row);
    if (!$isMatched) {
        print(trim($row));
        fwrite($changePage, $row);
    } else {
        fwrite($receivedPage, ltrim($row));
    }
}

fclose($changePage);
fclose($receivedPage);
