<?php
$cpanel_username = "sandsl23";
$cpanel_password = "d0mainsecur1ty@123!@#x%1";
$subdomain = 'newsubdomain';
$domain = 'sandslab.com';
$source_file = '/home/sandsl23/public_html/createsubdomain/application.zip'; // Source file path
$destination_path = "/home/sandsl23/public_html/$subdomain/"; // Destination folder path

// Move the zip file to the destination folder
if (copy($source_file, $destination_path . 'application.zip')) {
    // Open the zip file
    $zip = zip_open($destination_path . 'application.zip');
    if ($zip) {
        // Extract each file from the zip
        while ($zip_entry = zip_read($zip)) {
            // Get the name of the file inside the zip
            $filename = zip_entry_name($zip_entry);
            // Create the destination directory if it doesn't exist
            $dirname = dirname($destination_path . $filename);
            if (!is_dir($dirname)) {
                mkdir($dirname, 0755, true);
            }
            // Extract the file
            if (zip_entry_open($zip, $zip_entry, "r")) {
                $file_content = zip_entry_read($zip_entry, zip_entry_filesize($zip_entry));
                file_put_contents($destination_path . $filename, $file_content);
                zip_entry_close($zip_entry);
            }
        }
        zip_close($zip);
        echo "Zip file extracted successfully.";
    } else {
        echo "Failed to open the zip file.";
    }
} else {
    echo "Failed to move the zip file.";
}
?>
