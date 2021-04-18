<!doctype html>
<html style="background:#fff;">
<head>

	<link rel="stylesheet" href="<?php echo plugin_dir_url( DIRHOA_PLUGIN_FILE ) ?>/css/print.css" type="text/css" media="all">
    <style>
        body {
            font-size:11px;
        }
        td {
            border:solid 1px #000;
            padding:5px;
        }
        table {
            max-width:99%;
        }
    </style>

</head>
<body>
    <h1>CHA Annual Dues Checklist <div style="float:right;font-size:0.5em;font-style:normal"><?php echo date("l, F j, Y"); ?></div></h1>

    <table>
        <thead>
            <tr>
                <th colspan="2">Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Check #</th>
                <th>Date</th>
                <th>Deposit</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($people as $person) : ?>
                <tr>
                    <td><?php echo $person->rLastName; ?></td>
                    <td><?php echo $person->rListingName; ?></td>
                    <td><?php echo $person->rStreetNumber; ?> <?php echo $person->rStreetName; ?></td>
                    <td><?php echo $person->rPhone; ?></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>