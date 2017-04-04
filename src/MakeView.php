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
    protected $signature = "make:view {viewname} {--extends}";

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
        $extends = env('BASE_VIEW', $this->option('extends'));
        
        if($extends == "" || is_null($extends)) {
            $this->error('You have not configured or supplied a view to extend!\nYou must either configure BASE_VIEW in your .env file or use the \"--extends=base.view\" argument when creating a view!');
        }

        $dir = resource_path('views');

        if($viewname == $extends) {
            $html = "<!DOCTYPE html>\n<html lang=\"en\">\n\t<head>\n\t\t<meta charset=\"utf-8\">\n\n\t\t<title>{{ \$title }}</title>\n\t</head>\n\t<body>\n\n\t</body>\n</html>";

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
                    $this->info("View [$viewname] created successfully!");
                } else {
                    $this->error("View [$viewname] already exists!");
                }
            } else {
                $viewfile = $viewname.".blade.php";
                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, $html);
                    $this->info("View [$viewname] created successfully!");
                } else {
                    $this->error("View [$viewname] already exists!");
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
                    $this->info("View [$viewname] created successfully!");
                } else {
                    $this->error("View [$viewname] already exists!");
                }
            } else {
                $viewfile = $viewname.".blade.php";
                if(!file_exists($dir."/".$viewfile)) {
                    touch($dir."/".$viewfile);
                    file_put_contents($dir."/".$viewfile, "@extends('$extends')");
                    $this->info("View [$viewname] created successfully!");
                } else {
                    $this->error("View [$viewname] already exists!");
                }
            }
        }
    }
}
