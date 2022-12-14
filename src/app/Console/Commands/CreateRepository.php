<?php

namespace App\Console\Commands;

use Illuminate\Console\Concerns\CreatesMatchingTest;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Symfony\Component\Console\Input\InputArgument;

class CreateRepository extends GeneratorCommand
{
    protected $signature = 'make:repository {name} {--model=}';

    protected $description = 'Create a new repository class.';

    protected $type = 'Repository';

    private string|false $model = false;

    /**
     * @return int
     * @throws FileNotFoundException
     */
    public function handle(): int
    {
        if ($this->isReservedName($this->getNameInput())) {
            $this->error('The name "'.$this->getNameInput().'" is reserved by PHP.');

            return 0;
        }

        if (!is_null($this->option('model')))
            $this->setModel($this->option('model'));

        $name = $this->qualifyClass($this->getNameInput());

        $path = $this->getPath($name);

        if ((! $this->hasOption('force') ||
                ! $this->option('force')) &&
            $this->alreadyExists($this->getNameInput())) {
            $this->error($this->type.' already exists!');

            return 0;
        }

        $this->makeDirectory($path);

        $this->files->put($path, $this->sortImports($this->buildClass($name)));

        if ($this->model)
            if (!file_put_contents($path, $this->replaceModel($path, $this->model))) {
                unlink($path);

                $this->error('Not possible to set model in repository.');

                return 0;
            }

        $this->info($this->type.' created successfully.');

        if (in_array(CreatesMatchingTest::class, class_uses_recursive($this))) {
            $this->handleTestCreation($path);
        }

        return 1;
    }

    /**
     * @param string $path
     * @param string $model
     * @return string
     */
    private function replaceModel(string $path, string $model): string
    {
        if (!$file_content = file_get_contents($path)) {
            unlink($path);

            $this->error('Not possible to get content from repository.');

            exit();
        }

        return str_replace('ModelRepository', $model, $file_content);
    }

    /**
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name): string
    {
        $stub = parent::replaceClass($stub, $name);

        $name = explode('\\', $name);

        return str_replace('RepositoryName', end($name), $stub);
    }

    /**
     * @return string
     */
    protected function getStub(): string
    {
        if (!$this->model)
            return base_path('stubs/repository-without-model.stub');

        return base_path('stubs/repository-with-model.stub');
    }

    /**
     * @param string $model
     * @return void
     */
    private function setModel(string $model): void
    {
        $this->model = ucfirst($model);
    }

    /**
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace): string
    {
        return $rootNamespace . '\Repositories';
    }

    /**
     * @return array
     */
    protected function getArguments(): array
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the repository.'],
        ];
    }
}
