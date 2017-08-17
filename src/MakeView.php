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
    protected $signature = "make:view {viewname} {--extends=} {--bootstrap}";

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
        $bootstrap = $this->option('bootstrap');

        if($extends == "" || is_null($extends)) {
            $this->error("You have not configured or supplied a view to extend!\nYou must either configure BASE_VIEW in your .env file or use the \"--extends=base.view\" argument when creating a view!");
            return false;
        }

        $dir = resource_path('views');

        if($viewname == $extends) {
            if($bootstrap) {
                $html = "<!DOCTYPE html>\n<html lang=\"en\">\n\t<head>\n\t\t<meta charset=\"utf-8\">\n\t\t<meta name=\"viewport\" content=\"width=device-width, initial-scale=1\">\n\n\t\t<link href=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css\" rel=\"stylesheet\" integrity=\"sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u\" crossorigin=\"anonymous\">\n\n\t\t<title>{{ \$title }}</title>\n\n\t\t<script src=\"https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js\"></script>\n\t\t<script src=\"https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js\" integrity=\"sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa\" crossorigin=\"anonymous\"></script>\n\t</head>\n\t<body>\n\n\t</body>\n</html>";
            } else {
                $html = "<!DOCTYPE html>\n<html lang=\"en\">\n\t<head>\n\t\t<meta charset=\"utf-8\">\n\n\t\t<title>{{ \$title }}</title>\n\t</head>\n\t<body>\n\n\t</body>\n</html>";
            }

            if(strpos($viewname, '.') !== false) {
                $parts = explode(".", $viewname);
                $count = count($parts);

                $viewfile = end($parts).".blade.php";

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

                $viewfile = end($parts).".blade.php";

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
