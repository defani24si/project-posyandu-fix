<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeCrudPosyandu extends Command
{
    protected $signature = 'make:crud:posyandu';
    protected $description = 'Generate CRUD for Posyandu (model, migration, controller, views, route)';

    public function handle()
    {
        $name = 'Posyandu';
        $namePlural = Str::pluralStudly($name);
        $table = Str::snake($namePlural);
        $modelFqn = "App\\Models\\{$name}";

        $fields = [
            ['name' => 'nama', 'type' => 'string'],
            ['name' => 'alamat', 'type' => 'string'],
            ['name' => 'rt', 'type' => 'string'],
            ['name' => 'rw', 'type' => 'string'],
            ['name' => 'kontak', 'type' => 'string'],
        ];

        // 1. buat model + migration
        $this->call('make:model', [
            'name' => $name,
            '--migration' => true,
        ]);

        // 2. update migration
        $this->updateMigration($table, $fields);

        // 3. buat controller
        $this->call('make:controller', [
            'name' => "{$name}Controller",
            '--resource' => true
        ]);

        $this->updateController($name, $table, $modelFqn, $fields);

        // 4. buat views
        $this->makeViews($name, $table, $fields);

        // 5. append route
        $this->appendRoute($name, $table);

        $this->info("CRUD Posyandu berhasil dibuat!");
    }

    protected function updateMigration($table, $fields)
    {
        $migrations = File::files(database_path('migrations'));
        $targetFile = null;
        foreach ($migrations as $migration) {
            if (str_contains($migration->getFilename(), "create_{$table}_table")) {
                $targetFile = $migration->getPathname();
                break;
            }
        }

        if (!$targetFile) {
            $this->error('Migration tidak ditemukan!');
            return;
        }

        $fieldsMigration = "";
        foreach ($fields as $field) {
            $fieldsMigration .= "\$table->{$field['type']}('{$field['name']}');\n        ";
        }

        $stub = <<<PHP
public function up(): void
{
    Schema::create('$table', function (Blueprint \$table) {
        \$table->bigIncrements('posyandu_id');
        {$fieldsMigration}\$table->timestamps();
    });
}
PHP;

        $content = File::get($targetFile);
        $content = preg_replace('/public function up\(\): void\s*\{[\s\S]*?\}/', $stub, $content);
        File::put($targetFile, $content);
    }

    protected function updateController($name, $table, $modelFqn, $fields)
    {
        $controllerPath = app_path("Http/Controllers/{$name}Controller.php");
        if (!File::exists($controllerPath)) {
            $this->error('Controller tidak ditemukan!');
            return;
        }

        $modelVar = Str::camel($name);
        $modelVarPlural = Str::plural($modelVar);

        $rules = "";
        foreach ($fields as $field) {
            $rules .= "'{$field['name']}' => 'required|string',\n            ";
        }

        $fillable = array_map(fn($f) => "'".$f['name']."'", $fields);
        $fillableString = implode(', ', $fillable);

        $controllerTemplate = <<<PHP
<?php

namespace App\Http\Controllers;

use $modelFqn;
use Illuminate\Http\Request;

class {$name}Controller extends Controller
{
    public function index()
    {
        \${$modelVarPlural} = {$name}::latest()->paginate(10);
        return view('{$table}.index', compact('{$modelVarPlural}'));
    }

    public function create()
    {
        return view('{$table}.create');
    }

    public function store(Request \$request)
    {
        \$data = \$request->validate([
            {$rules}
        ]);

        {$name}::create(\$data);

        return redirect()->route('{$table}.index')->with('success', '{$name} berhasil dibuat.');
    }

    public function show({$name} \${$modelVar})
    {
        return view('{$table}.show', compact('{$modelVar}'));
    }

    public function edit({$name} \${$modelVar})
    {
        return view('{$table}.edit', compact('{$modelVar}'));
    }

    public function update(Request \$request, {$name} \${$modelVar})
    {
        \$data = \$request->validate([
            {$rules}
        ]);

        \${$modelVar}->update(\$data);

        return redirect()->route('{$table}.index')->with('success', '{$name} berhasil diupdate.');
    }

    public function destroy({$name} \${$modelVar})
    {
        \${$modelVar}->delete();
        return redirect()->route('{$table}.index')->with('success', '{$name} berhasil dihapus.');
    }
}
PHP;

        File::put($controllerPath, $controllerTemplate);

        // update fillable model
        $modelPath = app_path("Models/{$name}.php");
        $content = File::get($modelPath);
        if (!str_contains($content, 'fillable')) {
            $fillable = <<<PHP

    protected \$fillable = [$fillableString];
PHP;
            $content = str_replace("use HasFactory;\n", "use HasFactory;$fillable\n", $content);
            File::put($modelPath, $content);
        }
    }

    protected function makeViews($name, $table, $fields)
    {
        $viewsPath = resource_path("views/{$table}");
        if (!File::exists($viewsPath)) File::makeDirectory($viewsPath, 0755, true);
        if (!File::exists($viewsPath.'/partials')) File::makeDirectory($viewsPath.'/partials', 0755, true);

        File::put($viewsPath.'/index.blade.php', $this->indexView($name, $table, $fields));
        File::put($viewsPath.'/create.blade.php', $this->createView($name, $table));
        File::put($viewsPath.'/edit.blade.php', $this->editView($name, $table));
        File::put($viewsPath.'/show.blade.php', $this->showView($name, $table, $fields));
        File::put($viewsPath.'/partials/form.blade.php', $this->formView($name, $table, $fields));
    }

    // --- View templates (index, create, edit, show, form) ---
    // Copy isi view seperti di MakeCrud yang kamu kirim
    protected function indexView($name, $table, $fields){ /* isi seperti kode sebelumnya */ return "@index view"; }
    protected function createView($name, $table){ return "@create view"; }
    protected function editView($name, $table){ return "@edit view"; }
    protected function showView($name, $table, $fields){ return "@show view"; }
    protected function formView($name, $table, $fields){ return "@form view"; }

    protected function appendRoute($name, $table)
    {
        $routePath = base_path('routes/web.php');
        $route = "Route::resource('{$table}', \\App\\Http\\Controllers\\{$name}Controller::class);\n";
        File::append($routePath, $route);
    }
}
