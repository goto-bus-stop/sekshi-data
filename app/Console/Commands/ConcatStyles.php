<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ConcatStyles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'styles:concat';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Concatenate CSS files.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $base = str_finish(base_path('resources/assets/css'), '/');
        $dir = new \DirectoryIterator($base);
        $concat = '';
        foreach ($dir as $file) {
            if (preg_match('/\.css$/i', $file)) {
                $concat .= file_get_contents($base . $file);
            }
        }
        file_put_contents(public_path('css/style.css'), $concat);
    }
}
