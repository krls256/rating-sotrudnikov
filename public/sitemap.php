<?php

use app\Repositories\Base\BaseCompaniesRepository;

require_once '../config.php';

$companiesRepo = new BaseCompaniesRepository();
$companies = $companiesRepo->getPublishedCompanies();

header('Content-type: application/xml; charset=utf-8');
echo '<?xml version="1.0" encoding="UTF-8"?>';

	$protocol = ((!empty($_SERVER['HTTPS'])) ? 'https' : 'http') . '://';
	$URL = $protocol . $_SERVER['SERVER_NAME'];
?>
<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd">
<url>
	<loc><?php echo $URL?>/</loc>
	<lastmod>2020-01-06T10:09:13+01:00</lastmod>
	<priority>1.0</priority>
</url>
<url>
	<loc><?php echo $URL?>/all-review</loc>
	<lastmod>2020-01-06T10:09:13+01:00</lastmod>
	<priority>1.0</priority>
</url>
<url>
	<loc><?php echo $URL?>/contacts</loc>
	<lastmod>2020-01-06T10:09:17+01:00</lastmod>
	<priority>1.0</priority>
</url>
<?php
    foreach ($companies as $company) {
        $url = $company->url ?? '';
?>
<url>
    <loc><?php echo $URL?>/otzyvy-sotrudnikov-<?= $url ?>/</loc>
    <lastmod>2020-09-06T10:09:20+01:00</lastmod>
    <priority>0.6</priority>
</url>
<url>
    <loc><?php echo $URL?>/otzyvy-sotrudnikov-<?= $url ?>/1/positive</loc>
    <lastmod>2020-09-06T10:09:20+01:00</lastmod>
    <priority>0.6</priority>
</url>
<url>
    <loc><?php echo $URL?>/otzyvy-sotrudnikov-<?= $url ?>/1/negative</loc>
    <lastmod>2020-09-06T10:09:20+01:00</lastmod>
    <priority>0.6</priority>
</url>
<?php
    }
?>
</urlset>
