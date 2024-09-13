<?php

use Elegantly\Seo\Facades\SeoManager;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Request;

it('renders default seo from config using Facade', function () {

    $title = 'The app title';
    $description = 'The app description';

    config()->set('seo.defaults.title', $title);
    config()->set('seo.defaults.description', $description);

    $manager = SeoManager::current();

    $url = Request::url();
    $locale = App::getLocale();
    $robots = config('seo.defaults.robots');

    expect(
        $manager->toTags()->toHtml()
    )->toBe(implode("\n", [
        // standard
        '<title >'.$title.'</title>',
        '<link rel="canonical" href="'.$url.'" />',
        '<meta name="description" content="'.$description.'" />',
        '<meta name="robots" content="'.$robots.'" />',
        // opengraph
        '<meta property="og:title" content="'.$title.'" />',
        '<meta property="og:url" content="'.$url.'" />',
        '<meta property="og:description" content="'.$description.'" />',
        '<meta property="og:locale" content="'.$locale.'" />',
        '<meta property="og:site_name" content="'.config('app.name').'" />',
        '<meta property="og:type" content="website" />',
        // twitter
        '<meta name="twitter:card" content="summary" />',
        '<meta name="twitter:title" content="'.$title.'" />',
        '<meta name="twitter:description" content="'.$description.'" />',
        // JSON
        '<script type="application/ld+json">'.json_encode([
            '@context' => 'https://schema.org',
            '@type' => 'WebPage',
            'name' => $title,
            'description' => $description,
            'url' => $url,
        ]).'</script>',
    ]));
});
