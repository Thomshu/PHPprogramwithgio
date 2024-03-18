<?php

declare(strict_types = 1);

// Your Code
function readCSVFiles(string $directory) : array{ //Return type is an array as specified
    $filesArray = [];

    //To scan the directory, we use the scandir() function. Scandir() returns an array containing the different files. We use foreach to go through those individual files
    foreach(scandir($directory) as $file){

        //For the parent/current directory encountered
        if ($file === '.' || $file === ".."){
            continue;
        }
        #Alternative code below:
        /* if (is_dir($file)){
            continue;
        }
        */

        //var_dump($file); //Just checking to make sure its working! Initial attempt, it also includes . (current directory) and .. (parent directory)
        $filesArray[] = $directory . $file; //Appending to the array, note we're also including the directory appended to the files for ease later
    }

    /*echo '<pre>';
    print_r($filesArray);
    echo '</pre>';
    */

    return $filesArray;
}

function readFileValues(string $fileName) : array{
    //First Column is date of transaction
    //Second column is check #, optional not always provided
    //Third column is transaction description
    //Fourth column is the amount (negative = expense, positive = income)

    # Always error checking first!
    if (! file_exists($fileName)){
        trigger_error($fileName . ' does not exist', E_USER_ERROR);
    }

    //Opening the file to read
    $file = fopen($fileName, 'r');

    $transactionValuesArray = [];

    fgetcsv($file); //This is to get rid of the very first line of the csv which is the columns

    while (($line = fgetcsv($file)) !== false){ //strict not comparison. Because the line itself could be a value that eventually evaluates to false which can lead to bugs

        /*echo '<pre>';
        print_r($line);
        echo '</pre>';
        */
        $transactionValuesArray[] = $line; //From video he does $transactionValuesArray[] = extractTransaction($line)
    }
    return $transactionValuesArray;
}

function AmountCalc(array $transactions) : array{
    $calcArray = [];
    $income = 0.0;
    $expense = 0.0;
    $total = 0.0;
    $replaceChar = ['-', '$', ','];

    foreach($transactions as $line){
        //line[3] is the amount value column's value, while line[3][0] is the first character of the string
        //I will use this to determine if its a positive or negative number
        if ($line[3][0] === '-') { //this is expense!
            $number = (float)str_replace($replaceChar, '', $line[3]);
            $expense += $number;
            $total -= $number;
        }
        else{ //this is income!
            $number = (float)str_replace($replaceChar, '', $line[3]);
            $income += $number;
            $total += $number;
        }
    }
    $calcArray[] = round($income, 2);
    $calcArray[] = round($expense,2);
    $calcArray[] = round($total,2);
    return $calcArray;
}

//This is the function from his video
function extractTransaction(array $transactionRow): array{
    [$date, $checkNumber, $description, $amount] = $transactionRow;

    $amount = (float)str_replace(['$', ','],'', $amount);

    return [
        'date' => $date,
        'checkNumber' => $checkNumber,
        'description' => $description,
        'amount' => $amount,
    ];
}

//His calculateTotals version
function calculateTotals(array $transactions): array
{
    $totals = ['netTotal' => 0, 'totalIncome' => 0, 'totalExpense' => 0];

    foreach($transactions as $transaction){
        $totals['netTotal'] += $transaction['amount'];

        if ($transaction['amount'] >= 0){
            $totals['totalIncome'] += $transaction['amount'];
        } else{
            $totals['totalExpense'] += $transaction['amount'];
        }
    }
}
