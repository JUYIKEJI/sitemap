<?php
class Sitemap_Action extends Typecho_Widget implements Widget_Interface_Do
{
	public function action()
	{
		$db = Typecho_Db::get();
		$options = Typecho_Widget::widget('Widget_Options');

		$pages = $db->fetchAll($db->select()->from('table.contents')
		->where('table.contents.status = ?', 'publish')
		->where('table.contents.created < ?', $options->gmtTime)
		->where('table.contents.type = ?', 'page')
		->order('table.contents.created', Typecho_Db::SORT_DESC));

		$articles = $db->fetchAll($db->select()->from('table.contents')
		->where('table.contents.status = ?', 'publish')
		->where('table.contents.created < ?', $options->gmtTime)
		->where('table.contents.type = ?', 'post')
		->order('table.contents.created', Typecho_Db::SORT_DESC));

		$seen = array();
		$latestModified = 0;
		foreach ($pages as $item) {
			if (!empty($item['modified']) && $item['modified'] > $latestModified) {
				$latestModified = $item['modified'];
			}
		}
		foreach ($articles as $item) {
			if (!empty($item['modified']) && $item['modified'] > $latestModified) {
				$latestModified = $item['modified'];
			}
		}

		header("Content-Type: application/xml");
		echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
		echo "<?xml-stylesheet type='text/xsl' href='" . $options->pluginUrl . "/Sitemap/sitemap.xsl'?>\n";
		echo "<urlset xmlns:xsi=\"http://www.w3.org/2001/XMLSchema-instance\"\nxsi:schemaLocation=\"http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd\"\nxmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">";

		$home = $options->index;
		if (!empty($home) && !in_array($home, $seen, true)) {
			$seen[] = $home;
			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlspecialchars($home, ENT_QUOTES, 'UTF-8') . "</loc>\n";
			if (!empty($latestModified)) {
				echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $latestModified) . "</lastmod>\n";
			}
			echo "\t\t<changefreq>daily</changefreq>\n";
			echo "\t\t<priority>1.0</priority>\n";
			echo "\t</url>\n";
		}

		foreach ($pages as $page) {
			$type = $page['type'];
			$routeExists = (NULL != Typecho_Router::get($type));
			if (!$routeExists) {
				continue;
			}
			$page['pathinfo'] = Typecho_Router::url($type, $page);
			$page['permalink'] = Typecho_Common::url($page['pathinfo'], $options->index);
			if (empty($page['permalink']) || $page['permalink'] === '#' || in_array($page['permalink'], $seen, true)) {
				continue;
			}
			$seen[] = $page['permalink'];

			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlspecialchars($page['permalink'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
			echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $page['modified']) . "</lastmod>\n";
			echo "\t\t<changefreq>weekly</changefreq>\n";
			echo "\t\t<priority>0.8</priority>\n";
			echo "\t</url>\n";
		}
		foreach ($articles as $article) {
			$type = $article['type'];
			$article['categories'] = $db->fetchAll($db->select()->from('table.metas')
					->join('table.relationships', 'table.relationships.mid = table.metas.mid')
					->where('table.relationships.cid = ?', $article['cid'])
					->where('table.metas.type = ?', 'category')
					->order('table.metas.order', Typecho_Db::SORT_ASC));
			$article['category'] = urlencode(current(Typecho_Common::arrayFlatten($article['categories'], 'slug')));
			$article['slug'] = urlencode($article['slug']);
			$article['date'] = new Typecho_Date($article['created']);
			$article['year'] = $article['date']->year;
			$article['month'] = $article['date']->month;
			$article['day'] = $article['date']->day;
			$routeExists = (NULL != Typecho_Router::get($type));
			if (!$routeExists) {
				continue;
			}
			$article['pathinfo'] = Typecho_Router::url($type, $article);
			$article['permalink'] = Typecho_Common::url($article['pathinfo'], $options->index);
			if (empty($article['permalink']) || $article['permalink'] === '#' || in_array($article['permalink'], $seen, true)) {
				continue;
			}
			$seen[] = $article['permalink'];

			echo "\t<url>\n";
			echo "\t\t<loc>" . htmlspecialchars($article['permalink'], ENT_QUOTES, 'UTF-8') . "</loc>\n";
			echo "\t\t<lastmod>" . date('Y-m-d\TH:i:s\Z', $article['modified']) . "</lastmod>\n";
			echo "\t\t<changefreq>monthly</changefreq>\n";
			echo "\t\t<priority>0.5</priority>\n";
			echo "\t</url>\n";
		}
		echo "</urlset>";
	}
}
