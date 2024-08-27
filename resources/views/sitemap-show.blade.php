<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>

<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
        xmlns:image="http://www.google.com/schemas/sitemap-image/1.1">
    @foreach($series as $show)
         <url>
             <loc>{{ url('show/'.$show->id) }}</loc>
             <priority>1</priority>
             <image:image>
                 <image:loc>{{ url('files/thumbnails/'.$show->thumb) }}</image:loc>
                 <image:caption>{{ $show->title }}</image:caption>
             </image:image>
             <changefreq>daily</changefreq>
         </url>
    @endforeach
</urlset>
