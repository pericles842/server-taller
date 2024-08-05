<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GenerateImplement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:Implement {file_name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Genera un implemento en la carpeta InventarioImplements';

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
     * @return int
     */
    public function handle()
    {
        $filename = ucfirst($this->argument('file_name'));
        $filePath = base_path('app/Http/InventarioImplements/' . $filename . 'Implement.php'); // Ruta absoluta dentro de la carpeta app

        // Verifica si el directorio donde se guardará el archivo existe, si no, créalo
        if (!file_exists(dirname($filePath))) mkdir(dirname($filePath), 0755, true);

        // Genera el contenido del archivo
        $content = '<?php' . PHP_EOL . PHP_EOL;
        $content .= 'namespace App\Http\InventarioImplements;' . PHP_EOL . PHP_EOL;
        $content .= 'class ' . pathinfo($filename.'Implement', PATHINFO_FILENAME) . ' {' . PHP_EOL;
        $content .= '    // Agrega tu lógica aquí' . PHP_EOL;
        $content .= '}' . PHP_EOL;

        // Guarda el archivo en la ubicación especificada
        file_put_contents($filePath, $content);

        $this->info("Archivo generado en $filePath");
    }
}
