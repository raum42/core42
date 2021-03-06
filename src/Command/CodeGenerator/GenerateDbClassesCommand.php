<?php

/*
 * core42
 *
 * @package core42
 * @link https://github.com/kiwi-suite/core42
 * @copyright Copyright (c) 2010 - 2017 kiwi suite (https://www.kiwi-suite.com)
 * @license MIT License
 * @author kiwi suite <dev@kiwi-suite.com>
 */

namespace Core42\Command\CodeGenerator;

use Core42\Command\AbstractCommand;
use Core42\Command\ConsoleAwareTrait;
use Zend\Db\Metadata\Source\Factory;
use Zend\Filter\Word\UnderscoreToCamelCase;
use ZF\Console\Route;

class GenerateDbClassesCommand extends AbstractCommand
{
    use ConsoleAwareTrait;

    /**
     * @var string
     */
    protected $directory;

    /**
     * @var string
     */
    protected $namespace;

    /**
     * @var string
     */
    protected $table;

    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $all;

    /**
     * @var bool
     */
    protected $generateGetterSetter = false;

    /**
     * @var bool
     */
    protected $overwrite = false;

    /**
     * @var string
     */
    protected $adapterName = 'Db\Master';

    /**
     * @var bool
     */
    protected $transaction = false;

    /**
     * @param string $directory
     * @return $this
     */
    public function setDirectory($directory)
    {
        $this->directory = $directory;

        return $this;
    }

    /**
     * @param string $namespace
     * @return $this
     */
    public function setNamespace($namespace)
    {
        $this->namespace = $namespace;

        return $this;
    }

    /**
     * @param string $table
     * @return $this
     */
    public function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @param string $adapterName
     * @return $this
     */
    public function setAdapterName($adapterName)
    {
        $this->adapterName = $adapterName;

        return $this;
    }

    /**
     * @param string $all
     * @return $this
     */
    public function setAll($all)
    {
        $this->all = $all;

        return $this;
    }

    /**
     * @param bool $generateGetterSetter
     * @return $this
     */
    public function setGenerateGetterSetter($generateGetterSetter)
    {
        $this->generateGetterSetter = $generateGetterSetter;

        return $this;
    }

    /**
     * @param bool $overwrite
     * @return $this
     */
    public function setOverwrite($overwrite)
    {
        $this->overwrite = $overwrite;

        return $this;
    }

    /**
     *
     */
    protected function preExecute()
    {
        if (empty($this->directory)) {
            $this->addError('directory', 'directory parameter not set');

            return;
        }

        if (empty($this->namespace)) {
            $this->addError('namespace', 'namespace parameter not set');

            return;
        }

        if ($this->all !== null && (!empty($this->table) || !empty($this->name))) {
            $this->addError('all', 'both usage of name/table arguments and --all argument is not allowed');

            return;
        }
        if ($this->all === null && (empty($this->table) || empty($this->name))) {
            $this->addError('all', 'Whether name/table arguments or --all argument are required');

            return;
        }

        if (!$this->getServiceManager()->has($this->adapterName)) {
            $this->addError('adapter', "adapter '" . $this->adapterName . "' not found");

            return;
        }

        if (!\is_dir($this->directory)) {
            $this->addError('directory', "directory '" . $this->directory . "' doesn't exist");

            return;
        }

        if (!\is_dir($this->directory . '/' . 'Model')) {
            $this->addError('directory', "directory '" . $this->directory . "/Model' doesn't exist");

            return;
        }

        if (!\is_dir($this->directory . '/' . 'TableGateway')) {
            $this->addError('directory', "directory '" . $this->directory . "/TableGateway' doesn't exist");

            return;
        }

        if (!\is_writable($this->directory . '/' . 'Model')) {
            $this->addError('directory', "directory '" . $this->directory . "/Model' isn't writeable");

            return;
        }

        if (!\is_writable($this->directory . '/' . 'TableGateway')) {
            $this->addError('directory', "directory '" . $this->directory . "/TableGateway' isn't writeable");

            return;
        }

        $this->directory = \rtrim($this->directory, '/') . '/';
    }

    /**
     *
     */
    protected function execute()
    {
        if ($this->all !== null) {
            $adapter = $this->getServiceManager()->get($this->adapterName);
            $metadata = Factory::createSourceFromAdapter($adapter);
            $tables = $metadata->getTableNames();

            $filter = new UnderscoreToCamelCase();

            foreach ($tables as $table) {
                if (\in_array($table, ['migrations'])) {
                    continue;
                }
                if ($this->all != '*' && \mb_substr($table, 0, \mb_strlen($this->all)) != $this->all) {
                    continue;
                }

                $this->consoleOutput('Generate files for: ' . $table);

                $name = \ucfirst($filter->filter(\mb_strtolower($table)));
                $this->generate($name, $table);
            }

            return;
        }

        $this->generate($this->name, $this->table);
    }

    /**
     * @param string $name
     * @param string $table
     * @throws \Exception
     */
    protected function generate($name, $table)
    {
        $modelClassName = $this->namespace . '\\Model\\' . $name;
        $tableGatewayClassName = $this->namespace . '\\TableGateway\\' . $name . 'TableGateway';

        $modelDirectory = $this->directory . 'Model/';
        $tableGatewayDirectory = $this->directory . 'TableGateway/';

        /** @var GenerateModelCommand $generateModel */
        $generateModel = $this->getCommand(GenerateModelCommand::class);
        $generateModel->setAdapterName($this->adapterName)
            ->setDirectory($modelDirectory)
            ->setClassName($modelClassName)
            ->setTableName($table)
            ->setGenerateSetterGetter($this->generateGetterSetter)
            ->setOverwrite($this->overwrite)
            ->run();

        /** @var GenerateTableGatewayCommand $generateTableGateway */
        $generateTableGateway = $this->getCommand(GenerateTableGatewayCommand::class);
        $generateTableGateway->setAdapterName($this->adapterName)
            ->setDirectory($tableGatewayDirectory)
            ->setClassName($tableGatewayClassName)
            ->setTableName($table)
            ->setModel($modelClassName)
            ->setOverwrite($this->overwrite)
            ->run();
    }

    /**
     * @param Route $route
     * @return void
     */
    public function consoleSetup(Route $route)
    {
        $this->setDirectory($route->getMatchedParam('directory'));
        $this->setNamespace($route->getMatchedParam('namespace'));

        $table = $route->getMatchedParam('table');
        if (!empty($table)) {
            $this->setTable($table);
        }

        $name = $route->getMatchedParam('name');
        if (!empty($name)) {
            $this->setName($name);
        }

        $this->setAll($route->getMatchedParam('all', null));

        $this->setGenerateGetterSetter($route->getMatchedParam('getter-setter'));
        $this->setOverwrite($route->getMatchedParam('overwrite'));

        $adapterName = $route->getMatchedParam('adapter');
        if (!empty($adapterName)) {
            $this->setAdapterName($adapterName);
        }
    }
}
