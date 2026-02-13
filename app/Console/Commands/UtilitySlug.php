<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sluggable\SlugOptions;

class UtilitySlug extends Command {

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'utility:slug {model} {--slug=slug} {--name=name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will refresh the slug with the name (If slug is empty)';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        $model = "App\\Models\\{$this->argument('model')}";
        $slugCol = $this->option('slug');
        $nameCol = $this->option('name');

        if (class_exists($model)) {
            $rows = $model::where($slugCol, '=', '')->orWhereNull($slugCol)->withTrashed()->get();
            $bar = $this->output->createProgressBar(count($rows));
            $bar->start();
            foreach ($rows as $row) {
                $row->generateSlug();
                \DB::table($row->getTable())->where($row->getKeyName(), $row->getKey())->update([$slugCol => $row->$slugCol]);
                $bar->advance();
                $this->info(class_basename($row).": {$row->$nameCol} - Slug: {$row->$slugCol}");
            }
            $bar->finish();
            $this->info("");
        } else {
            $this->info("{$model} class not exists");
        }
    }

}
