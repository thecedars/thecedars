<?php
$directory = new CedarsDirectory();
$people = $directory->get_all( "rLastName" );
?><!doctype html>
<html>
<head>

    <link rel="stylesheet" href="<?php echo plugin_dir_url( DIRHOA_PLUGIN_FILE ) ?>/css/print.css" type="text/css" media="all">
    <style type="text/css">
        @page { margin: 0.5in; margin-left:0; }

        .page {
            font-size: 0.8em;
        }

        h1 {
            font-size: 1.5em;
        }
        ul {
            list-style: none;
            padding:0;
            margin:0;
        }

        ul:after {
            content:"";
            clear:both;
            width:100%;
            height:0;
            display: block;
        }

        ul li {
            float:left;
            width:33.33%;
            -webkit-box-sizing: border-box;
            -moz-box-sizing: border-box;
            -ms-box-sizing: border-box;
            box-sizing: border-box;
            padding:0 1em;
        }

        ul li:nth-child(3n+1) {
            clear: both;
        }

        .column {
            float:left;
            width:33.3%;
        }

        table {
            width: 100%;
            table-layout: fixed;
        }

        table td {
            border:0;
        }

        table td:last-child {
        }

        table tr {
            border:0;
        }

        .number {
            text-align:right;
            padding-right:10px;
        }

        tr:nth-child(odd) {
            background-color:#ddd;
        }

        .street,
        .email {
            white-space:nowrap;
        }

        .email {
            text-align:right;
            padding-right:10px;
        }

        .listing,
        .children {
        }

        .last {
            padding-left:10px;
            white-space:nowrap;
            text-overflow:ellipsis;
            overflow:hidden;
        }

        .last {width:72px;font-size:1.1em;font-weight:700;}
        .listing {width:150px}
        .children {width:118px;font-size:0.8em;}
        .street {width:100px}
        .email {width:auto;}

        .email-text {font-size:0.8em;}

        @media print {
            .page {
                padding-left:5em;
            }
            .column {
                font-size: 0.9em;
            }
        }
    </style>
</head><?php $image = '<img style="display:block;" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" width="200" height="1">'; ?>
<body>

    <div class="page">
        <table class="">
            <tbody>
                <?php foreach ($people as $row ) { ?>
                    <tr>
                        <td class="last"><?php echo $row->rLastName ?></td>
                        <td class="listing"><?php echo $row->rListingName ?></td>
                        <td class="children"><?php echo $image; echo $row->rChildren ?></td>
                        <td class="street"><?php echo $row->rStreetNumber ?> <?php echo $row->rStreetName ?></td>
                        <td class="email"><?php echo $image; _e( ($row->rPhone == "(913)541-1237") ? "" : format_phone($row->rPhone) ) ?></td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>

</body>
</html>