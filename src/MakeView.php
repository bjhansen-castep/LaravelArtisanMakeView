<?php

namespace LaravelMakeView;
use Illuminate\Console\Command;

class MakeView extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:view {viewname} {--extends=masterpages.default}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Make a new Blade View';

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
        $viewname = $this->argument('viewname');
        $extends = $this->option('extends');

        $dir = resource_path('views');

        if($viewname == $extends) {
            $html = "<!DOCTYPE html>\n<html lang='en'>\n\t<head>\n\t\t<meta charset='utf-8'>\n\n\t\t<title>{{ \$title }}</title>\n\t</head>\n\t<body>\n\n\t</body>\n</html>";

            if(strpos($viewname, '.') !== false) {
                $parts = explode(".", $viewname);
                $count = count($parts);

                $viewfile = $parts[$count-1].".blade.php";

                for($i = 0; $i < $count-1; $i++) {
                    $folder = $parts[$i];
                    $dir .= "/".$folder;

                    if(!file_exists($dir)) {
                        mkdir($dir);
                    }
                }

                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, $html);
                    $this->info("\n\n\tView [$viewname] created successfully!\n");
                } else {
                    $this->error("\n\n\tView [$viewname] already exists!\n");
                }
            } else {
                $viewfile = $viewname.".blade.php";
                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, $html);
                    $this->info("\n\n\tView [$viewname] created successfully!\n");
                } else {
                    $this->error("\n\n\tView [$viewname] already exists!\n");
                }
            }
        } else {
            if(strpos($viewname, '.') !== false) {
                $parts = explode(".", $viewname);
                $count = count($parts);

                $viewfile = $parts[$count-1].".blade.php";

                for($i = 0; $i < $count-1; $i++) {
                    $folder = $parts[$i];
                    $dir .= "/".$folder;

                    if(!file_exists($dir)) {
                        mkdir($dir);
                    }
                }

                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, "@extends('$extends')");
                    $this->info("\n\n\tView [$viewname] created successfully!\n");
                } else {
                    $this->error("\n\n\tView [$viewname] already exists!\n");
                }
            } else {
                $viewfile = $viewname.".blade.php";
                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, "@extends('$extends')");
                    $this->info("\n\n\tView [$viewname] created successfully!\n");
                } else {
                    $this->error("\n\n\tView [$viewname] already exists!\n");
                }
            }
        }
    }
}
