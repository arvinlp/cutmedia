<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($episodes as $episode)
         <url>
             <loc>{{ url('show/'.$episode->tvShow()->slug.'/episodes/'.$episode->slug) }}</loc>
             <priority>1</priority>
             <image:image>
                 <image:loc>{{ url('files/thumbnails/'.$episode->thumb) }}</image:loc>
                 <image:caption>{{ $episode->title }}</image:caption>
             </image:image>
             <changefreq>weekly</changefreq>
         </url>
    @endforeach
</urlset>
