<?php
/**
 * WXR XML Exporter Script
 */
$wp_load = dirname(__DIR__, 3) . '/wp-load.php';
require_once $wp_load;
require_once ABSPATH . 'wp-admin/includes/export.php';

ob_start();
export_wp(array('content' => 'all'));
$xml = ob_get_clean();

$export_dir = __DIR__ . '/export';
if (!is_dir($export_dir)) {
    mkdir($export_dir, 0777, true);
}

$xml_file = $export_dir . '/haber-wordpress-content.xml';
file_put_contents($xml_file, $xml);
echo "XML dışa aktarma başarıyla tamamlandı: " . $xml_file . " (" . strlen($xml) . " bayt)\n";
