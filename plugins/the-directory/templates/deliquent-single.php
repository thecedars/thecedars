<?php

$letter_post = wp_cache_get( 'dirhoa_letter_post' );

if (isset( $_GET["csv"] )) :

	$deliquent = explode(",",get_post_meta( $letter_post->ID, "dirhoa_checkboxen", true ));

	if (!empty($deliquent)) {
		header('Content-Type: text/csv; charset=utf-8');
		header('Content-Disposition: attachment; filename=addresses-the-cedars.csv');

		$output = fopen('php://output', 'w');

		fputcsv($output, array('bName','bAddress','bCity','bState','bZip','rListingName','rChildren','rStreetNumber','rStreetName','rPhone','rEmail1','rEmail2'));

		foreach ($deliquent as $item) {
			$person = dirhoa_get_resident( $item );
			if (!$person) continue;

			$row = array();
			if ($person->bAddress) {
				$row[]=$person->bName;
				$row[]=$person->bAddress;
				$row[]=$person->bCity;
				$row[]=$person->bState;
				$row[]=$person->bZip;
			} else {
				$row[]=$person->rListingName;
				$row[]=$person->rStreetNumber . ' ' . $person->rStreetName;
				$row[]=$person->rCity;
				$row[]=$person->rState;
				$row[]=$person->rZip;
			}

			$row[]=$person->rListingName;
			$row[]=$person->rChildren;
			$row[]=$person->rStreetNumber;
			$row[]=$person->rStreetName;
			$row[]=$person->rPhone;
			$row[]=$person->rEmail1;
			$row[]=$person->rEmail2;

			fputcsv($output, $row);
		}
	}

	die;

endif;

?><!doctype html>
<html>
<head>

	<link rel="stylesheet" href="<?php echo esc_url( get_template_dirhoa_uri() ); ?>/css/print.css" type="text/css" media="all">

</head>
<body>

	<?php if ( have_posts() ) : while ( have_posts() ) : the_post();

		if (!current_user_can("manage_options")) {
			echo '<div class="page hide-on-print">';
			echo 'Must be logged in and admin.';
			echo '</div>';

			continue;
		}

		echo '<div class="page hide-on-print">';
		echo '<a href="'.add_query_arg(array("letter"=>$letter_post->post_name), get_site_url()).'">View Letters</a> | <a href="'.add_query_arg(array("letter"=>$letter_post->post_name,"showbilling"=>1), get_site_url()).'">View Addresses</a> | <a href="'.add_query_arg(array("letter"=>$letter_post->post_name,"csv"=>1), get_site_url()).'">CSV</a> | <a href="' . add_query_arg(array("letter"=>$letter_post->post_name,"temp"=>1), get_site_url()) . '">Template</a>';
		echo '</div>';

		$temp = isset( $_GET['temp'] ) && $_GET['temp'] == '1';

		$fields = dirhoa_fields();

		$deliquent = explode(",",get_post_meta( $letter_post->ID, "dirhoa_checkboxen", true ));

		if (empty( $deliquent )) echo '<div class="page">' . apply_filters("the_content", apply_filters('the_content',$letter_post->post_content)) . '</div>';


		foreach ($deliquent as $item) {

			$person = dirhoa_get_resident( $item );
			if (!$person) continue;

			if (isset( $_GET["showbilling"] )) :

				echo '<div class="page no-break">';

				echo "<div class=\"hide-on-screen\" style=\"height:10em\"></div>";

				if ($person->bAddress) {
					echo "
						{$person->bName}<br>
						{$person->bAddress}<br>
						{$person->bCity}, {$person->bState}, {$person->bZip}
					";
				} else {
					echo "
						{$person->rListingName}<br>
						{$person->rStreetNumber} {$person->rStreetName}<br>
						{$person->rCity}, {$person->rState}, {$person->rZip}
					";
				}

			else :
				echo '<div class="page">';

				if ($person->bEmail) {
					echo '<div class="has-email hide-on-print" title="'.$person->bEmail.'">&#10004; Has a Billing Email</div>';
				}

				$content = $letter_post->post_content;

				foreach ($fields as $field) {
					if (!$temp) $content = str_replace('{{'.$field.'}}', $person->$field, $content);
				}

				echo apply_filters("the_content", $content );

			endif;

			echo '</div>';

			if ($temp)
				break;
		}

	endwhile; endif; ?>

</body>
</html>