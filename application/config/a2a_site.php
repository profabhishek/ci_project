<?php defined('BASEPATH') OR exit('No direct script access allowed');
/*
 * A2A public site settings (contact details, languages, search scope).
 * Change the contact details HERE; header, footer, home and Contact Us all read them.
 *
 * CHECK BEFORE GOING LIVE: the phone numbers below were on the old Contact Us
 * page but had been commented out. Confirm with the section which numbers and
 * timings should be published.
 */
$config['a2a_contact'] = array(
    'office'   => 'Indian Council for Cultural Relations (Headquarters)',
    'address'  => 'Azad Bhavan, I.P. Estate, New Delhi - 110002, India',
    'phones'   => array('+91-11-23370794', '+91-11-23379249'),
    'hours'    => 'Monday to Friday, 9:30 AM to 6:00 PM IST',
    'email'    => 'iccr@vocman.in',          // technical help (from the old Contact Us page)
    'email_label' => 'Technical help',
    'map_url'  => 'https://www.google.com/maps/search/?api=1&query=ICCR+Azad+Bhavan+IP+Estate+New+Delhi',
    'missions_url' => 'https://www.mea.gov.in/indian-missions-abroad-new.htm',
);

// Languages offered in the header switch. Code => [CI language folder, label shown, html lang]
$config['a2a_languages'] = array(
    'en' => array('english', 'English', 'en'),
    'hi' => array('hindi',   'हिन्दी',  'hi'),
);
