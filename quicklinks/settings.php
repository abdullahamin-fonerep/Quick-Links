<?php
defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    // Add setting for the number of links
    $settings->add(new admin_setting_configselect(
        'quicklinks/num_links',
        get_string('num_links', 'mod_quicklinks'),
        get_string('num_links_desc', 'mod_quicklinks'),
        3, // Default number of links
        array_combine(range(1, 5), range(1, 5)) // Options from 1 to 5
    ));

    // Function to render the title and link inputs dynamically
    if(!function_exists('render_links_settings')){
        function render_links_settings($num_links,$settings) {
            
    
            for ($i = 1; $i <= $num_links; $i++) {
                $settings->add(new admin_setting_configtext(
                    "quicklinks/link_title_$i",
                    get_string('link_title', 'mod_quicklinks', $i),
                    get_string('link_title_desc', 'mod_quicklinks', $i),
                    '',
                    PARAM_TEXT
                ));
                
                $settings->add(new admin_setting_configtext(
                    "quicklinks/link_url_$i",
                    get_string('link_url', 'mod_quicklinks', $i),
                    get_string('link_url_desc', 'mod_quicklinks', $i),
                    '',
                    PARAM_URL
                ));
            }
        }
    
    }
  
    // Get the number of links
    $num_links = get_config('quicklinks', 'num_links');

    // Render title and link inputs based on the number of links
    render_links_settings($num_links,$settings);

    // Display the saved links
    $links = [];
    for ($i = 1; $i <= $num_links; $i++) {
        $title = get_config('quicklinks', "link_title_$i");
        $url = get_config('quicklinks', "link_url_$i");
        if ($title && $url) {
            $links[] = html_writer::link($url, s($title));
        }
    }

    
   // Output HTML and CSS
//    echo '<style>
//    table {
//        width: 100%;
//        border-collapse: collapse;
//        margin: 20px 0;
//    }
//    th, td {
//        padding: 10px;
//        border: 1px solid #ddd;
//        text-align: left;
//    }
//    th {
//        background-color: #f4f4f4;
//    }
//    td {
//        vertical-align: top;
//    }
// </style>';

// echo '<table>';
// echo '<tr>';
// echo '<th>Links</th>';
// echo '<th>Additional Content</th>';
// echo '</tr>';
// echo '<tr>';
// echo '<td>';
// echo '<h3>Quick Links</h3>';
// if (!empty($links)) {
//    foreach ($links as $link) {
//        echo '<p>' . $link . '</p>';
//    }
// } else {
//    echo '<p>No links available.</p>';
// }
// echo '</td>';
// echo '<td>';
// echo '<h3>Write Something</h3>';
// echo '<p>This space is for writing or adding additional content.</p>';
// echo '</td>';
// echo '</tr>';
// echo '</table>';
}

