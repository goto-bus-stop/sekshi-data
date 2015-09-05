<?php

namespace App\Console\Commands;

use Storage;
use Illuminate\Console\Command;

class GenerateBadgeSprites extends Command
{
    const BADGE_SIZE = 70;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'badges:generate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate images and CSS for plug.dj badges.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Downloading app.css...');
        // any room URL will do
        $home = file_get_contents('https://plug.dj/loves-kpop');
        $matches = [];
        preg_match('#https://cdn\.plug\.dj/_/static/css/app\..*?\.css#', $home, $matches);
        $cssUrl = $matches[0];
        $appcss = file_get_contents($cssUrl);

        $this->info('Extracting badge CSS...');
        // plug.dj badge sheets are split into a few categories. The category is
        // added as a single-character CSS class by plug.dj.
        preg_match_all('/\.bdg(\.\w+)?\.large\{.*?background-image:url\(\'(.*?)\'\).*?\}/i', $appcss, $matches, PREG_SET_ORDER);
        $sheets = collect();
        foreach ($matches as list (, $name, $url)) {
            if ($name === '') {
                $name = 'default';
            } else {
                $name = substr($name, 1);
            }
            $sheets->put($name, $url);
        }
        // find all large badges with _just_ a background position.
        // animated large badges have additional CSS with a background URL, and
        // we only want the static versions of those badges anyway.
        preg_match_all('/\.bdg-([-_a-z0-9]+)\.large\{background-position:(.*?)\}/i', $appcss, $matches, PREG_SET_ORDER);
        $offsets = collect();
        foreach ($matches as list (, $name, $cssPosition)) {
            $offsets->put($name, $cssPosition);
        }
        $this->comment('Found ' . $sheets->count() . ' badge sheets with ' . $offsets->count() . ' badges.');

        $this->info('Downloading sheets...');
        if (!is_dir(public_path('img/badges'))) {
            mkdir(public_path('img/badges'), 0700, true);
        }
        $backgrounds = collect();
        foreach ($sheets as $name => $url) {
            $sheetPath = public_path('img/badges/' . $name . '.png');
            file_put_contents($sheetPath, file_get_contents($url));
            list ($width, $height) = getimagesize($sheetPath);
            $backgrounds->put($name, [
                'url' => '../img/badges/' . $name . '.png',
                'width' => $width,
                'height' => $height,
                'percentSize' => max($width, $height) / self::BADGE_SIZE * 100
            ]);
            $this->comment('  Downloaded "' . $name . '" sheet.');
        }

        $this->info('Generating CSS...');
        $css = '
            .Badge {
                background-image: url("' . $backgrounds['default']['url'] . '");
                background-size: ' . $backgrounds['default']['percentSize'] . '%;
            }
        ';
        foreach ($offsets as $name => $offset) {
            $css .= '.Badge--' . $name . ' { ';
            $bgName = preg_match('/-\w$/', $name) ? substr($name, -1) : 'default';
            $bg = $backgrounds[$bgName];
            if ($bgName !== 'default') {
                $css .= 'background-image: url("' . $bg['url'] . '"); ';
                $css .= 'background-size: ' . $bg['percentSize'] . '%; ';
            }
            $css .= 'background-position: ' . $this->toPercents($offset, $bg) . '; }' . "\n";
        }

        file_put_contents(public_path('css/badges.css'), $css);
    }

    /**
     * Convert a CSS "${X}px ${Y}px" style position to percentages.
     *
     * @param  string  $offset
     * @param  array  $size  Size [x, y] in pixels of the background image sheet.
     * @return string
     */
    private function toPercents($offset, array $size)
    {
        list ($x, $y) = array_map(function ($coord) {
            return (int) str_replace('px', '', $coord);
        }, explode(' ', $offset));
        return ($x / self::BADGE_SIZE * 100) . '% ' . ($y / self::BADGE_SIZE * 100) . '%';
    }
}
