{foreach $urls as $url}
    <url>
        <loc>{$url}</loc>
        <lastmod>[[+date]]</lastmod>
        <changefreq>[[+update]]</changefreq>
        <priority>[[+priority]]</priority>
    </url>
{/foreach}