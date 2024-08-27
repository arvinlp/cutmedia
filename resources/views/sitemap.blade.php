<?= '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<sitemapindex>

    <sitemap>
        <loc>{{ url('sitemap-show.xml') }}</loc>
        <lastmod><?= date('Y-m-d') ?></lastmod>
    </sitemap>

    <?php
      $n=$show_count/100;
      $n=ceil($n)+1;
    ?>
    @for($i=1;$i<$n;$i++)
        <sitemap>
            <loc>{{ url('show/'.$i.'/sitemap-episodes.xml') }}</loc>
            <lastmod><?= date('Y-m-d') ?></lastmod>
        </sitemap>
    @endfor
</sitemapindex>
