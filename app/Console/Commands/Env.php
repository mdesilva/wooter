<?php

namespace Wooter\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class Env extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:env';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Copy .envs file if this don\'t exit!';

    /**
     * Create a new command instance.
     *
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Store env file
     *
     * @return boolean
     */
    public function store_env($files) {
        file_put_contents($files['theENV'], file_get_contents($files["originalENV"]));
        $this->comment("Awesome! .env file was stored!");
    }

    /**
     * Update env file
     *
     * @return boolean
     */
    public function update_env($files) {
        $content = [
            file_get_contents($files["originalENV"]),
            file_get_contents($files["theENV"])
        ];

        $ct = $content[1];

        $content = $this->dispatchLines($content);
        $content = $this->cleaner($content);

        $cleaned = trim($ct).(($content == PHP_EOL)?'':PHP_EOL.$content);
        file_put_contents($files['theENV'], $cleaned);
        $this->comment("Awesome! .env file was updated!");
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(){

        $files = [
            "originalENV" => base_path('.env.example'),
            "theENV" => base_path('.env')
        ];

        $fileConds = [
            "originalENV" => file_exists($files["originalENV"]),
            "theENV" => file_exists($files["theENV"])
        ];

        if(!$fileConds["theENV"]){
            $this->store_env($files);
        } else {
            $this->update_env($files);
        }

    }

    private function dispatchLines($content) {
        foreach($content as $k => $ct){
            $content[$k] = explode(PHP_EOL, $ct);

            foreach($content[$k] as $i => $line){
                $content[$k][$i] = explode('=',$line);
            }
        }
        return $content;
    }

    private function cleaner($content) {
        foreach($content[1] as $i => $ct){
            foreach($content[0] as $k => $it){
                if(trim($content[0][$k][0]) == trim($content[1][$i][0])){
                    unset($content[0][$k]);
                }
            }
        }
        unset($content[1]);
        foreach($content as $k => $ct){
            foreach($ct as $i => $it){
                $it[0] = trim($it[0]);
                $it[1] = trim($it[1]);

                $content[$k][$i] = implode('=', $it);
            }
        }

        $content = implode(PHP_EOL, $content[0]);
        return $content;
    }
}
