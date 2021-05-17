<?php

unset( $data['csstidy']['all_properties']['binding'] );

$data['csstidy']['all_properties']['text-size-adjust'] = 'CSS3.0';

// Support browser prefixes for properties only in the latest CSS draft
foreach ( $data['csstidy']['all_properties'] as $property => $levels ) {
	if ( strpos( $levels, "," ) === false ) {
		$data['csstidy']['all_properties']['-moz-' . $property] = $levels;
		$data['csstidy']['all_properties']['-webkit-' . $property] = $levels;
		$data['csstidy']['all_properties']['-ms-' . $property] = $levels;
		$data['csstidy']['all_properties']['-o-' . $property] = $levels;
		$data['csstidy']['all_properties']['-khtml-' . $property] = $levels;

		if ( in_array( $property, $data['csstidy']['unit_values'] ) ) {
			$data['csstidy']['unit_values'][] = '-moz-' . $property;
			$data['csstidy']['unit_values'][] = '-webkit-' . $property;
			$data['csstidy']['unit_values'][] = '-ms-' . $property;
			$data['csstidy']['unit_values'][] = '-o-' . $property;
			$data['csstidy']['unit_values'][] = '-khtml-' . $property;
		}

		if ( in_array( $property, $data['csstidy']['color_values'] ) ) {
			$data['csstidy']['color_values'][] = '-moz-' . $property;
			$data['csstidy']['color_values'][] = '-webkit-' . $property;
			$data['csstidy']['color_values'][] = '-ms-' . $property;
			$data['csstidy']['color_values'][] = '-o-' . $property;
			$data['csstidy']['color_values'][] = '-khtml-' . $property;
		}
	}
}

foreach ( $data['csstidy']['multiple_properties'] as $property ) {
	if ( '-' != $property[0] ) {
		$data['csstidy']['multiple_properties'][] = '-o-' . $property;
		$data['csstidy']['multiple_properties'][] = '-ms-' . $property;
		$data['csstidy']['multiple_properties'][] = '-webkit-' . $property;
		$data['csstidy']['multiple_properties'][] = '-moz-' . $property;
		$data['csstidy']['multiple_properties'][] = '-khtml-' . $property;
	}
}

/**
 * CSS Animation
 *
 * @see https://developer.mozilla.org/en/CSS/CSS_animations
 */
$data['csstidy']['at_rules']['-webkit-keyframes'] = 'at';
$data['csstidy']['at_rules']['-moz-keyframes'] = 'at';
$data['csstidy']['at_rules']['-ms-keyframes'] = 'at';
$data['csstidy']['at_rules']['-o-keyframes'] = 'at';

/**
 * Non-standard viewport rule.
 */
$data['csstidy']['at_rules']['viewport'] = 'is';
$data['csstidy']['at_rules']['-webkit-viewport'] = 'is';
$data['csstidy']['at_rules']['-moz-viewport'] = 'is';
$data['csstidy']['at_rules']['-ms-viewport'] = 'is';

/**
 * Non-standard CSS properties.  They're not part of any spec, but we say
 * they're in all of them so that we can support them.
 */
$data['csstidy']['all_properties']['-webkit-filter'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['-moz-filter'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['-ms-filter'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['filter'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['scrollbar-face-color'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['-ms-interpolation-mode'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['text-rendering'] = 'CSS2.0,CSS2.1,CSS3.0';
$data['csstidy']['all_properties']['-webkit-transform-origin-x'] = 'CSS3.0';
$data['csstidy']['all_properties']['-webkit-transform-origin-y'] = 'CSS3.0';
$data['csstidy']['all_properties']['-webkit-transform-origin-z'] = 'CSS3.0';
$data['csstidy']['all_properties']['-webkit-font-smoothing'] = 'CSS3.0';
$data['csstidy']['all_properties']['-moz-osx-font-smoothing'] = 'CSS3.0';
$data['csstidy']['all_properties']['-font-smooth'] = 'CSS3.0';
$data['csstidy']['all_properties']['-o-object-fit'] = 'CSS3.0';
$data['csstidy']['all_properties']['object-fit'] = 'CSS3.0';
$data['csstidy']['all_properties']['-o-object-position'] = 'CSS3.0';
$data['csstidy']['all_properties']['object-position'] = 'CSS3.0';
$data['csstidy']['all_properties']['text-overflow'] = 'CSS3.0';
$data['csstidy']['all_properties']['zoom'] = 'CSS3.0';
$data['csstidy']['all_properties']['pointer-events'] = 'CSS3.0';

/**
 * CSS properties not part of CSSTidy
 */
$data['csstidy']['all_properties']['grid-gap'] = 'CSS3.0';
$data['csstidy']['all_properties']['grid-template-columns'] = 'CSS3.0';