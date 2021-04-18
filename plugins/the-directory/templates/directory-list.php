<!doctype html>
<html>
<head>

    <link rel="stylesheet" href="<?php echo plugin_dir_url( DIRHOA_PLUGIN_FILE ) ?>/css/print.css" type="text/css" media="all">
    <style type="text/css">
        @page { margin: 0.25in; margin-left:0; }

        .page {
            font-size: 0.7em;
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
            table-layout:fixed;
        }

        table td {
            border:0;
            word-break: break-all;
        }

        table td:last-child {
            width:53%;
        }

        table tr {
            border:0;
        }

        .street,
        .last {
            white-space:nowrap;
            text-align:left;
        }

        .last {
            font-weight:700;
            overflow:hidden;
            text-overflow:ellipsis;
            white-space:nowrap;
        }

        .street {
            font-size:1.2em;
            width:23px;
        }

        .phone {
            font-size:1.3em;
        }

        @media print {
            .page {
                padding-left:5em;
            }
            .column {
                font-size: 0.9em;
            }
        }
    </style>
</head><?php $image = '';// '<img style="display:block;" src="data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7" width="200" height="1">'; ?>
<body>

    <div class="page">
        <?php
        $directory = new CedarsDirectory();
        $streets = $directory->get_street_names();
        usort($streets,"_dirhoa_streetname_sort");
        ?>
        <?php foreach ($streets as $index => $street) : ?>
            <h1><?php _e( $street->rStreetName ) ?></h1>
            <?php $people = $directory->get_by( array("rStreetName"=>$street->rStreetName) ) ?>
            <div class="column">
                <?php usort($people, "_dirhoa_streetnumber_sort"); ?>

                <?php
                $peoplecount = count( $people );
                $columncount = ceil($peoplecount/3);
                $lastcolumncount = $peoplecount - $columncount *2;
                $middlecolumnstart = $peoplecount - $columncount - $lastcolumncount +1;
                $lastcolumnstart = $peoplecount-$lastcolumncount +1;
                $count = 1;
                ?>
                <?php foreach ($people as $person) :
                if($count == $middlecolumnstart) { echo '</div><div class="column">'; }
                if($count == $lastcolumnstart) { echo '</div><div class="column last-column">'; }

                $phone_array = explode("\n",$person->rPhone);
                $phone = current( $phone_array );

                ?>
                    <table><tr><td class="street"><?php _e( $person->rStreetNumber ) ?></td><td class="last"><?php echo $image; _e( $person->rLastName ) ?></td><td class="phone"><?php _e( ($phone == "(913)541-1237") ? "" : format_phone($phone) ) ?></td></tr></table>
                <?php $count++; endforeach; ?>
            </div>

            <div style="clear:both"></div>

            <?php if ($index == 2 ) : ?><div class="page-break"></div><?php endif; ?>
        <?php endforeach; ?>
    </div>

</body>
</html>