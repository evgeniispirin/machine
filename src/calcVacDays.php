<?php
date_default_timezone_set("Europe/Berlin");

if (!file_exists($pathToFile = (string)$argv[1])) {
    echo 'Please pass a path to a file as the first argument as in the example below:'
        . PHP_EOL . 'php calcVacDays.php path_to_file';
    die;
}


$csvFile = fopen($pathToFile, 'r');
$resultCsvFile = fopen(preg_replace("~\.csv~", '' , $pathToFile) . 'Done.csv', 'w');
fputcsv($resultCsvFile, ['Employee', 'Vacation days']);

$isFirstLine = true;
while(!feof($csvFile)) {
    $vacationDays = 0;
    $usr = explode(';', fgetcsv($csvFile)[0]);
    if ($isFirstLine) {
        $isFirstLine = false;
        continue;
    }

    $currentDate = new \DateTime('');
    $age = date_diff(new \DateTime($usr[1]), $currentDate)->y;
    $periodAtWork = date_diff(new \DateTime($usr[2]), $currentDate);
    $vacDaysPerYear = !empty($usr[3]) ? (int)$usr[3] : 26;

    $vacationDays +=
        ($vacDaysPerYear / 12) * ($periodAtWork->y * 12 + $periodAtWork->m)
        + ($periodAtWork->d * $vacDaysPerYear / 365)
    ;

    if ($age >= 30 && $periodAtWork->y >= 5) {
        $vacationDays += (int)($periodAtWork->y / 5);
    }

    fputcsv($resultCsvFile, [
        $usr[0],
        (int)$vacationDays
    ]);
}

fclose($csvFile);
fclose($resultCsvFile);

Echo 'Well Done :-)';
