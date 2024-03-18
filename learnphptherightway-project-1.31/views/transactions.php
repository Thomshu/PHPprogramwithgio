<!DOCTYPE html>
<html lang="en">
    <head>
        <title>Transactions</title>
        <style>
            table {
                width: 100%;
                border-collapse: collapse;
                text-align: center;
            }

            table tr th, table tr td {
                padding: 5px;
                border: 1px #eee solid;
            }

            tfoot tr th, tfoot tr td {
                font-size: 20px;
            }

            tfoot tr th {
                text-align: right;
            }
        </style>
    </head>
    <body>
        <table>
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Check #</th>
                    <th>Description</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <?php if(! empty($transactions)): //Simple check to see if transactions array is empty?>
                    <?php foreach($transactions as $line): ?>
                        <tr>
                            <?php
                                $date = date('M j, Y', strtotime($line[0])); //date() function to change it to date
                            ?>
                            <td><?= $date ?></td>
                            <td><?= $line[1] ?></td>
                            <td><?= $line[2] ?></td>
                            <?php if ($line[3][0] === '-'): //Note that this is not the best way to do it, as our csv could have been formatted different ways?>
                                <td style="color:red"><?= $line[3] ?></td>
                            <?php else: ?>
                                <td style="color:green"><?= $line[3] ?></td>
                            <?php endif ?>
                        </tr>
                    <?php endforeach?>
                <?php endif?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="3">Total Income:</th>
                    <td>
                        <?= "$" . number_format($calculations[0], 2) ?? 0  ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Total Expense:</th>
                    <td>
                        <?= "-$" . number_format($calculations[1], 2) ?? 0  ?>
                    </td>
                </tr>
                <tr>
                    <th colspan="3">Net Total:</th>
                    <td>
                        <?php if ($calculations[2] < 0): ?>
                            <?php $total = (float)str_replace('-', '', $calculations[2]) ?>
                            <?= "$" . number_format($total, 2) ?? 0 ?>
                        <?php else: ?>
                            <?= "$" . number_format($calculations[2], 2) ?? 0 ?>
                        <?php endif ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </body>
</html>
